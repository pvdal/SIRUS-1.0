<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Coordinator;

// Log
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Random\RandomException;

class CoordinatorController extends Controller
{
    /**
     * @throws RandomException
     */
    public function index (): View
    {
        //if (!session()->has('custom_token')) {}
        session(['dynamic_token' => bin2hex(random_bytes(16))]);

        $coordinators = Coordinator::with('user:id,name,email,state,updated_at,created_at')->orderBy('id')->paginate(10);

        $coordinatorsData = $coordinators->getCollection()->map(function ($coordinator) {
            $user = $coordinator->user;

            $updated_at = $coordinator->updated_at;

            if ($user && $user->updated_at) {
                $updated_at = $user->updated_at->gt($coordinator->updated_at)
                    ? $user->updated_at
                    : $coordinator->updated_at;
            }

            return [
                'id' => $coordinator->id,
                'user_id' => $coordinator->user_id,
                'name' => $coordinator->user->name,
                'email' => $coordinator->user->email,
                'state' => (int) $coordinator->user->state,
                'created_at' => $coordinator->created_at,
                'updated_at' => $updated_at,
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
        $query = Coordinator::with('user:id,name,email,state,updated_at,created_at')->orderBy('id');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user',function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->whereHas('user', function ($q) use ($status) {
                $q->where('state', $status);
            });
        }

        if ($request->filled('period')) {
            $period = $request->input('period');
            $query->whereHas('user', function ($q) use ($period) {
                $q->when($period === 'today', fn($q) => $q->whereDate('created_at', today()))
                  ->when($period === 'week', fn ($q) => $q->whereDate('created_at', [now()->subDays(7), now()]))
                  ->when($period === 'month', fn ($q) => $q->whereDate('created_at', [now()->subDays(30), now()]));
            });
        }

        $coordinators = $query->paginate(10);
        //Log::info('Queries executadas:', DB::getQueryLog());

        // Mapeia para retornar somente os campos necessários
        $coordinatorsData = $coordinators->getCollection()->map(function ($coordinator) {
            $user = $coordinator->user;

            $updated_at = $coordinator->updated_at;

            if ($user && $user->updated_at) {
                $updated_at = $user->updated_at->gt($coordinator->updated_at)
                    ? $user->updated_at
                    : $coordinator->updated_at;
            }

            return [
                'id' => $coordinator->id,
                'user_id' => $coordinator->user_id,
                'name' => $coordinator->user->name,
                'email' => $coordinator->user->email,
                'state' => (int) $coordinator->user->state,
                'created_at' => $coordinator->created_at,
                'updated_at' => $updated_at,
            ];
        })->values();

        return response()->json([
            'data' => $coordinatorsData,
            'current_page' => $coordinators->currentPage(),
            'last_page' => $coordinators->lastPage(),
        ]);
    }

    function generateStrongPassword($length = 12) {
        $letters = Str::random(4);          // letras maiúsculas/minúsculas
        $numbers = rand(1000, 9999);        // números
        $symbols = ['!', '@', '#', '$', '%', '&', '*'];
        $symbol = $symbols[array_rand($symbols)];

        $password = str_shuffle($letters . $numbers . $symbol);
        return $password;
    }

    public function store (Request $request, CreateNewUser $creator): jsonResponse
    {
        //$start = microtime(true);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
        ]);

        $password = $this->generateStrongPassword();

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

        $coordinator = Coordinator::with('user:id,name,email,state,updated_at,created_at')->where('user_id', $id)->first();

        if(!$coordinator || !$coordinator->user) {
            return response()->json([
                'message' => 'Coordenador não encontrado!',
            ],422);
        }

        $coordinator->user->update([
            'name' => $request['name'],
            'email' => $request['email'],
        ]);

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
        $coordinator = Coordinator::with('user:id,name,email,state')->where('user_id', $id)->first();

        if (!$coordinator || !$coordinator->user) {
            return response()->json([
                'message' => 'Coordenador não encontrado!',
            ], 422);
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

        $coordinator->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Coordenador atualizado com sucesso!',
            'state' => (int) $coordinator->user->state,
            'created_at' => $coordinator->user->created_at,
            'updated_at' => $coordinator->user->updated_at,
        ]);
    }
}
