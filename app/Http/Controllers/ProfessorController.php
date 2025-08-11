<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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

        $professors = Professor::with('user:id,name,email,state')->paginate(10);

        $data = $professors->getCollection()->map(function ($professor) {
            return [
                'id' => $professor->id,
                'user_id' => $professor->user_id,
                'name' => $professor->user->name,
                'email' => $professor->user->email,
                'state' => (int) $professor->user->state,
            ];
        });

        return view('management.professors', [
            'professors' => $data,
            'current_page' => $professors->currentPage(),
            'last_page' => $professors->lastPage(),
        ]);
    }

    public function show(Request $request): JsonResponse
    {
        //DB::enableQueryLog();
        $query = Professor::with('user:id,name,email,state'); // Carrega dados do usuário

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
        $data = $professors->getCollection()->map(function ($professor) {
            return [
                'id'    => $professor->id,
                'user_id' => $professor->user_id,
                'name'  => $professor->user->name,
                'email' => $professor->user->email,
                'state' => (int) $professor->user->state,
            ];
        });

        return response()->json([
            'data' => $data,
            'current_page' => $professors->currentPage(),
            'last_page' => $professors->lastPage(),
        ]);
    }

    public function store(Request $request, CreateNewUser $creator): JsonResponse
    {
        //$start = microtime(true);
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
        ]);

        // Cria o usuário usando o Fortify
        $user = $creator->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'access_level' => 2, // 2 = Professor
            'state' => 1,
        ]);

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

        $professor = Professor::with('user:id,name,email,state')->where('user_id', $id)->first();

        if(!$professor || !$professor->user) {
            return response()->json([
                'message' => 'Professor não encontrado!',
            ],422);
        }

        $professor->user->update([
            'name' => $request['name'],
            'email' => $request['email'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Professor atualizado com sucesso.',
            'data' => [
                'id'    => $professor->id,
                'user_id' => $professor->user_id,
                'name'  => $professor->user->name,
                'email' => $professor->user->email,
                'state' => (int) $professor->user->state,
            ]
        ]);
    }

    public function inactivate($id): JsonResponse
    {
        $professor = Professor::with('user:id,name,email,state')->where('user_id', $id)->first();

        if (!$professor || !$professor->user) {
            return response()->json([
                'message' => 'Professor não encontrado!',
            ], 422);
        }

        $professor->user->update(['state' => 0]);

        $professor->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Professor inativado com sucesso.'
        ]);
    }

    public function activate($id): JsonResponse
    {
        $professor = Professor::with('user:id,name,email,state')->where('user_id', $id)->first();

        if (!$professor || !$professor->user) {
            return response()->json([
                'message' => 'Professor não encontrado!',
            ], 422);
        }

        $professor->user->update(['state' => 1]);

        $professor->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Professor inativado com sucesso.'
        ]);
    }
}
