<?php

namespace App\Http\Controllers;

// Common
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

// Users/Models
use App\Actions\Fortify\CreateNewUser;
use App\Models\Coordinator;

// Log
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Log;

// Static Classes and utils
use Random\RandomException;
use App\Utils\TokenGenerator;
use App\Utils\PasswordGenerator;

class CoordinatorController extends Controller
{
    /**
     * @throws RandomException
     */
    public function index (): View
    {
        // Inicializa o DynamicToken
        TokenGenerator::initializeTab();

        $coordinators = Coordinator::with(
            'user:id,name,email,state,updated_at,created_at'
        )->orderBy('id')->paginate(15);

        $coordinatorsData = $coordinators->getCollection()->map(function ($coordinator) {
            return [
                'id' => $coordinator->id,
                'user_id' => $coordinator->user_id,
                'name' => $coordinator->user->name,
                'email' => $coordinator->user->email,
                'state' => (int) $coordinator->user->state,
                'created_at' => $coordinator->created_at,
                'updated_at' => $coordinator->updated_at,
            ];
        })->values();

        return view('management.coordinators', [
            'coordinators' => $coordinatorsData,
            'current_page' => $coordinators->currentPage(),
            'last_page' => $coordinators->lastPage(),
        ]);
    }

    public function show (Request $request): jsonResponse
    {
        //DB::enableQueryLog();
        // Consulta no banco, join user com alguns campos ordenados por id
        $query = Coordinator::with(
            'user:id,name,email,state,updated_at,created_at'
        )->orderBy('id');

        #region Filtros
        // searchTerm: por nome ou email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user',function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        // statusFilter: ativo ou inativo
        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->whereHas('user', function ($q) use ($status) {
                $q->where('state', $status);
            });
        }
        // registerPeriod: período de cadastro
        if ($request->filled('period')) {
            $period = $request->input('period');
            $query->when($period === 'today', function ($q) {
                $q->whereDate('created_at', today());
            });
            $query->when($period === 'week', function ($q) {
                $q->whereBetween('created_at', [now()->subDays(7), now()]);
            });
            $query->when($period === 'month', function ($q) {
                $q->whereBetween('created_at', [now()->subDays(30), now()]);
            });
        }
        #endregion

        //paginação dos dados que vieram do banco
        $coordinators = $query->paginate(15);
        //Log::info('Queries executadas:', DB::getQueryLog());

        // Mapeia para retornar somente os campos necessários com chaves amigáveis
        $coordinatorsData = $coordinators->getCollection()->map(function ($coordinator) {
            return [
                'id' => $coordinator->id,
                'user_id' => $coordinator->user_id,
                'name' => $coordinator->user->name,
                'email' => $coordinator->user->email,
                'state' => (int) $coordinator->user->state,
                'created_at' => $coordinator->created_at,
                'updated_at' => $coordinator->updated_at,
            ];
        })->values();

        // Retorna dos dados dos coordenadores + pagina atual e última página
        return response()->json([
            'data' => $coordinatorsData,
            'current_page' => $coordinators->currentPage(),
            'last_page' => $coordinators->lastPage(),
        ]);
    }

    /**
     * @throws RandomException
     */
    public function store (Request $request, CreateNewUser $creator): jsonResponse
    {
        //$start = microtime(true);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
        ]);

        $password = PasswordGenerator::random();

        // Cria o usuário usando o Fortify
        $user = $creator->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $password,
            'password_confirmation' => $password,
            'access_level' => 3, // 3 = Coordinator
            'state' => 1,
        ]);

        // Envio da senha para o usuário cadastrado pelo e-mail por fila no banco
        $user->sendTemporaryPasswordNotification($password);

        // Cria o coordenador vinculado ao usuário
        $coordinator = Coordinator::create([
            'user_id' => $user->id,
        ]);
        //$end = microtime(true);
        //Log::info('Tempo criação user direto + coordenador: ' . ($end - $start) . ' segundos');

        return response()->json([
            'success' => true,
            'message' => 'Coordenador cadastrado com sucesso.',
            'data' => [
                'id' => $coordinator->id,
                'user_id' => $coordinator->user_id,
                'name' => $user->name,
                'email' => $user->email,
                'state' => (int) $user->state,
                'created_at' => $coordinator->created_at,
                'updated_at' => $coordinator->updated_at,
            ]
        ]);
    }

    public function update (Request $request, $id): JsonResponse
    {
        if(!$id) {
            return response()->json([
                'message' => 'Selecione um Coordenador!',
            ],422);
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => "required|email:rfc,dns|unique:users,email,{$id},id",
        ]);

        $coordinator = Coordinator::with(
            'user:id,name,email,state,updated_at,created_at'
        )->where('user_id', $id)
         ->first();

        if(!$coordinator || !$coordinator->user) {
            return response()->json([
                'message' => 'Coordenador não encontrado!',
            ],422);
        }

        // Atualiza os campos em memória
        $coordinator->user->fill([
            'name' => $request['name'],
            'email' => $request['email'],
        ]);

        // Só salva se houver mudanças
        if($coordinator->user->isDirty()) {
            $coordinator->user->save(); // Salva apenas se houver mudança, isNotDirty
            $coordinator->touch(); // Atualiza timestamps do coordenador
        }

        return response()->json([
            'success' => true,
            'message' => 'Coordenador atualizado com sucesso.',
            'data' => [
                'id' => $coordinator->id,
                'user_id' => $coordinator->user_id,
                'name' => $coordinator->user->name,
                'email' => $coordinator->user->email,
                'state' => (int) $coordinator->user->state,
                'created_at' => $coordinator->created_at,
                'updated_at' => $coordinator->updated_at,
            ]
        ]);
    }

    public function toggleStatus($id,$action): JsonResponse
    {
        $coordinator = Coordinator::with(
            'user:id,name,email,state'
        )->where('user_id', $id)->first();

        if (!$coordinator || !$coordinator->user) {
            return response()->json([
                'message' => 'Coordenador não encontrado!',
            ], 422);
        }
        // O usuário autenticado na sessão atual não pode se inativar
        if(auth()->user()->id === $coordinator->user_id) {
            return response()->json([
                'message' => 'Você não pode inativar a própria conta!'
            ],403);
        }

        if ($action === 'inactivate') {
            $coordinator->user->update(['state' => 0]);
        } elseif ($action === 'activate') {
            $coordinator->user->update(['state' => 1]);
        }  else {
            return response()->json([
                'message' => 'Ação inválida!'
            ], 422);
        }

        $coordinator->touch();

        return response()->json([
            'success' => true,
            'message' => 'Coordenador atualizado com sucesso!',
            'state' => (int) $coordinator->user->state,
            'created_at' => $coordinator->created_at ?? $coordinator->user->created_at,
            'updated_at' => $coordinator->updated_at ?? $coordinator->user->updated_at,
        ]);
    }
}
