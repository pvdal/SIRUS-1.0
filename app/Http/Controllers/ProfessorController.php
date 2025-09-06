<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Professor;

// Log
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Log;
use Random\RandomException;

class ProfessorController extends Controller
{
    /**
     * @throws RandomException
     */
    public function index(): View
    {
        //if (!session()->has('custom_token')) {}
        session(['dynamic_token' => bin2hex(random_bytes(16))]);

        $professors = Professor::with('user:id,name,email,state,updated_at,created_at')->orderBy('id')->paginate(10);

        $professorsData = $professors->getCollection()->map(function ($professor) {
            $user = $professor->user;



            return [
                'id' => $professor->id,
                'user_id' => $professor->user_id,
                'name' => $user->name ?? '—',
                'email' => $user->email ?? '—',
                'state' => isset($user->state) ? (int) $user->state : 0,
                'created_at' => $user->created_at ?? $professor->created_at,
                'updated_at' => $user->updated_at ?? $professor->updated_at,
            ];
        })->values();

        return view('management.professors', [
            'professors' => $professorsData,
            'current_page' => $professors->currentPage(),
            'last_page' => $professors->lastPage(),
        ]);
    }

    public function show(Request $request): JsonResponse
    {
        //DB::enableQueryLog();
        $query = Professor::with('user:id,name,email,state,updated_at,created_at')->orderBy('id'); // Carrega dados do usuário

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if($request->filled('status')) {
            $status = $request->input('status');
            $query->whereHas('user', function ($q) use ($status) {
                $q->where('state', $status);
            });
        }

        if ($request->filled('period')) {
            $period = $request->input('period');
            $query->whereHas('user', function ($q) use ($period) {
                $q->when($period === 'today', fn($q) => $q->whereDate('created_at', today()))
                    ->when($period === 'week', fn($q) => $q->whereBetween('created_at', [now()->subDays(7), now()]))
                    ->when($period === 'month', fn($q) => $q->whereBetween('created_at', [now()->subDays(30), now()]));
            });
        }

        $professors = $query->paginate(10);
        //Log::info('Queries executadas:', DB::getQueryLog());

        // Mapeia para retornar somente os campos necessários
        $professorsData = $professors->getCollection()->map(function ($professor) {
            $user = $professor->user;

            $updated_at = $professor->updated_at;

            if ($user && $user->updated_at) {
                $updated_at = $user->updated_at->gt($professor->updated_at)
                    ? $user->updated_at
                    : $professor->updated_at;
            }
            return [
                'id'    => $professor->id,
                'user_id' => $professor->user_id,
                'name'  => $professor->user->name,
                'email' => $professor->user->email,
                'state' => (int) $professor->user->state,
                'created_at' => $professor->created_at,
                'updated_at' => $updated_at, // pega o mais recente
            ];
        })->values();

        return response()->json([
            'data' => $professorsData,
            'current_page' => $professors->currentPage(),
            'last_page' => $professors->lastPage(),
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

    public function store(Request $request, CreateNewUser $creator): JsonResponse
    {
        //$start = microtime(true);
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
        ]);

        $password = $this->generateStrongPassword();

        // Cria o usuário usando o Fortify
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
                'updated_at' => $professor->updated_at, // pega o mais recente
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

        $professor = Professor::with('user:id,name,email,state,updated_at,created_at')->where('user_id', $id)->first();

        if(!$professor || !$professor->user) {
            return response()->json([
                'message' => 'Professor não encontrado!',
            ],422);
        }

        $professor->user->update([
            'name' => $request['name'],
            'email' => $request['email'],
        ]);
        $user = $professor->user;

        $updated_at = $professor->updated_at;

        if ($user && $user->updated_at) {
            $updated_at = $user->updated_at->gt($professor->updated_at)
                ? $user->updated_at
                : $professor->updated_at;
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
                'updated_at' => $updated_at, // pega o mais recente
            ]
        ]);
    }

    public function toggleStatus($id,$action): JsonResponse
    {
        $professor = Professor::with('user:id,name,email,state')->where('user_id', $id)->first();

        if (!$professor || !$professor->user) {
            return response()->json([
                'message' => 'Professor não encontrado!',
            ], 422);
        }

        if ($action === 'inactivate') {
            $professor->user->update(['state' => 0]);
        } elseif ($action === 'activate') {
            $professor->user->update(['state' => 1]);
        }  else {
            return response()->json([
                'message' => 'Ação inválida!'
            ], 422);
        }

        $professor->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Professor atualizado com sucesso!',
            'state' => (int) $professor->user->state,
            'created_at' => $professor->user->created_at,
            'updated_at' => $professor->user->updated_at,
        ]);
    }
}
