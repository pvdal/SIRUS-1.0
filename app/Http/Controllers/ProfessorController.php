<?php

namespace App\Http\Controllers;

// Common
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

// Users/Models
use App\Actions\Fortify\CreateNewUser;
use App\Models\Professor;

// Log
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Log;

// Static Classes and utils
use Random\RandomException;
use App\Utils\TokenGenerator;
use App\Utils\PasswordGenerator;

class ProfessorController extends Controller
{
    /**
     * @throws RandomException
     */
    public function index(): View
    {
        // Inicializa o DynamicToken
        TokenGenerator::initializeTab();

        // Faz uma query no banco trazendo 15 registros paginados
        $professors = Professor::with(
            'user:id,name,email,state,updated_at,created_at'
        )->orderBy('id')->paginate(15);

        // Pega a coleção paginada que retornou da query acima e mapeia com chaves amigáveis
        $professorsData = $professors->getCollection()->map(function ($professor) {
            $user = $professor->user;
            return [
                'id' => $professor->id,
                'user_id' => $professor->user_id,
                'name' => $user->name ?? '—',
                'email' => $user->email ?? '—',
                'state' => isset($user->state) ? (int) $user->state : 0,
                'created_at' => $professor->created_at ?? $user->created_at,
                'updated_at' => $professor->updated_at ?? $user->updated_at,
            ];
        })->values(); // Pega apenas a array de valores

        // Retorna os dados na view de gerenciamento de professores
        return view('management.professors', [
            'professors' => $professorsData,
            'current_page' => $professors->currentPage(),
            'last_page' => $professors->lastPage(),
        ]);
    }

    public function show(Request $request): JsonResponse
    {
        //DB::enableQueryLog();
        $query = Professor::with(
            'user:id,name,email,state,updated_at,created_at'
        )->orderBy('id'); // Carrega dados do usuário

        #region Filtros
        // searchTerm: por nome ou email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        // statusFilter: ativo ou inativo
        if($request->filled('status')) {
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

        // Transforma a query que recebeu os filtros em objeto paginado
        $professors = $query->paginate(15);
        //Log::info('Queries executadas:', DB::getQueryLog());

        // Mapeia para retornar somente os campos necessários
        $professorsData = $professors->getCollection()->map(function ($professor) {
            $user = $professor->user;
            return [
                'id'    => $professor->id,
                'user_id' => $professor->user_id,
                'name'  => $professor->user->name,
                'email' => $professor->user->email,
                'state' => (int) $professor->user->state,
                'created_at' => $professor->created_at ?? $user->created_at,
                'updated_at' => $professor->updated_at ?? $user->updated_at, // pega o mais recente
            ];
        })->values();

        // Retorna json com os registros filtrados
        return response()->json([
            'data' => $professorsData,
            'current_page' => $professors->currentPage(),
            'last_page' => $professors->lastPage(),
        ]);
    }

    /**
     * @throws RandomException
     */
    public function store(Request $request, CreateNewUser $creator): JsonResponse
    {
        //$start = microtime(true);
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
        ]);

        $password = PasswordGenerator::random();

        // Cria o usuário usando o controller nativo do Fortify
        $user = $creator->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $password,
            'password_confirmation' => $password,
            'access_level' => 2, // 2 = Professor
            'state' => 1,
        ]);

        // Envio da senha para o usuário cadastrado pelo e-mail por fila no banco
        $user->sendTemporaryPasswordNotification($password);

        // Cria o professor vinculado ao usuário
        $professor = Professor::create([
            'user_id' => $user->id,
        ]);
        //$end = microtime(true);
        //Log::info('Tempo criação user direto + professor: ' . ($end - $start) . ' segundos');

        return response()->json([
            'success' => true,
            'message' => 'Professor cadastrado com sucesso.',
            'data' => [
                'id'    => $professor->id,
                'user_id' => $professor->user_id,
                'name'  => $user->name,
                'email' => $user->email,
                'state' => (int) $user->state,
                'created_at' => $professor->created_at,
                'updated_at' => $professor->updated_at,
            ]
        ]);
    }

    public function update (Request $request, $id): JsonResponse
    {
        if(!$id) {
            return response()->json([
                'message' => 'Selecione um professor!',
            ],422);
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => "required|email:rfc,dns|unique:users,email,{$id},id",
        ]);

        $professor = Professor::with(
            'user:id,name,email,state,updated_at,created_at'
        )->where('user_id', $id)->first();

        if(!$professor || !$professor->user) {
            return response()->json([
                'message' => 'Professor não encontrado!',
            ],422);
        }

        // Adiciona os valores na memória
        $professor->user->fill([
            'name' => $request['name'],
            'email' => $request['email'],
        ]);
        // Se houver alteração comparado aos dados vindos do banco, isDirty retorna true
        if($professor->isDirty()) {
            $professor->user->save();
            $professor->touch(); // Atualiza timestamps do professor
        }

        return response()->json([
            'success' => true,
            'message' => 'Professor atualizado com sucesso.',
            'data' => [
                'id'    => $professor->id,
                'user_id' => $professor->user_id,
                'name'  => $professor->user->name,
                'email' => $professor->user->email,
                'state' => (int) $professor->user->state,
                'created_at' => $professor->created_at,
                'updated_at' => $professor->updated_at,
            ]
        ]);
    }

    public function toggleStatus($id, $action): JsonResponse
    {
        // Busca primeiro professor com o ‘ID’ passado como parâmetro
        $professor = Professor::with(
            'user:id,name,email,state'
        )->where('user_id', $id)->first();

        if (!$professor || !$professor->user) {
            return response()->json([
                'message' => 'Professor não encontrado!',
            ], 422);
        }

        // Inativa ou ativa a depender da $action
        if ($action === 'inactivate') {
            $professor->user->update(['state' => 0]);
        } elseif ($action === 'activate') {
            $professor->user->update(['state' => 1]);
        }  else {
            return response()->json([
                'message' => 'Ação inválida!'
            ], 422);
        }

        $professor->touch();

        return response()->json([
            'success' => true,
            'message' => 'Professor atualizado com sucesso!',
            'state' => (int) $professor->user->state,
            'created_at' => $professor->created_at ?? $professor->user->created_at,
            'updated_at' =>$professor->updated_at ?? $professor->user->updated_at,
        ]);
    }
}
