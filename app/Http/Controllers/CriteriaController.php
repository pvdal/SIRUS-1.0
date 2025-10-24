<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\Criterion;

class CriteriaController extends Controller
{
    /**
     * Exibição inicial de critérios (página principal)
     * 'READ'
     */
    public function index(): View
    {
        $criteria = Criterion::orderBy('id', 'asc')->paginate(30);

        $criteriaData = $criteria->getCollection()->map(function ($criterion) {
            return [
                'id' => $criterion->id,
                'name' => $criterion->name,
                'excellent' => $criterion->excellent,
                'good' => $criterion->good,
                'satisfactory' => $criterion->satisfactory,
                'unsatisfactory' => $criterion->unsatisfactory,
                'state' => (int) $criterion->state,
                'created_at' => $criterion->created_at,
                'updated_at' => $criterion->updated_at,
            ];
        })->values();

        return view('management.criteria', [
            'criteria' => $criteriaData,
            'page' => $criteria->currentPage(),
            'totalPages' => $criteria->lastPage(),
        ]);
    }

    /**
     * Exibição com filtros via AJAX
     * 'READ'
     */
    public function show(Request $request): JsonResponse
    {
        $query = Criterion::query()->orderBy('id', 'asc');

        // Filtro por texto
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('excellent', 'like', "%{$search}%")
                    ->orWhere('good', 'like', "%{$search}%")
                    ->orWhere('satisfactory', 'like', "%{$search}%")
                    ->orWhere('unsatisfactory', 'like', "%{$search}%");
            });
        }

//         Filtro por status
        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('state', $status);
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('state', $status);
        }

        if ($request->filled('status') || $request->input('status') === '0') {
            $status = $request->input('status');
            $query->where('state', $status);
        }



        // Filtro por período
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

        // Paginação
       $criteria = $query->paginate(30);

        // Mapeando os dados
        $criteriaData = $criteria->getCollection()->map(function ($criterion) {
            return [
                'id' => $criterion->id,
                'name' => $criterion->name,
                'excellent' => $criterion->excellent,
                'good' => $criterion->good,
                'satisfactory' => $criterion->satisfactory,
                'unsatisfactory' => $criterion->unsatisfactory,
                'state' => (int) $criterion->state,
                'created_at' => $criterion->created_at,
                'updated_at' => $criterion->updated_at,
            ];
        })->values();

        return response()->json([
            'data' => $criteriaData,
            'page' => $criteria->currentPage(),
            'totalPages' => $criteria->lastPage(),
        ]);
    }

    /**
     * Cadastro de um novo critério
     * 'CREATE'
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:criteria,name',
            'excellent' => 'required|string',
            'good' => 'required|string',
            'satisfactory' => 'required|string',
            'unsatisfactory' => 'required|string',
        ]);
        // É sempre bom especificar se é nullable ou required
        $criterion = Criterion::create([
            'name' => $validated['name'],
            'excellent' => $validated['excellent'] ?? null,
            'good' => $validated['good'] ?? null,
            'satisfactory' => $validated['satisfactory'] ?? null,
            'unsatisfactory' => $validated['unsatisfactory'] ?? null,
            'state' => 1,
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Critério cadastrado com sucesso.',
            'data' => [
                'id' => $criterion->id,
                'name' => $criterion->name,
                'excellent' => $criterion->excellent,
                'good' => $criterion->good,
                'satisfactory' => $criterion->satisfactory,
                'unsatisfactory' => $criterion->unsatisfactory,

                'state' => (int) $criterion->state,
                'created_at' => $criterion->created_at,
                'updated_at' => $criterion->updated_at,
            ]
        ], 201);
    }

    /**
     * Atualização de um critério existente
     * 'UPDATE'
     */
    public function update(Request $request, $id): JsonResponse
    {
        $criterion = Criterion::find($id);

        if (!$criterion) {
            return response()->json(['message' => 'Critério não encontrado!'], 404);
        }

        $validated = $request->validate([
            'name' => "required|string|max:255|unique:criteria,name,{$id}",
            'excellent' => 'required|string',
            'good' => 'required|string',
            'satisfactory' => 'required|string',
            'unsatisfactory' => 'required|string',
        ]);

        $criterion->update([
            'name' => $validated['name'],
            'excellent' => $validated['excellent'] ?? null,
            'good' => $validated['good'] ?? null,
            'satisfactory' => $validated['satisfactory'] ?? null,
            'unsatisfactory' => $validated['unsatisfactory'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Critério atualizado com sucesso!',
            'data' => [
                'id' => $criterion->id,
                'name' => $criterion->name,
                'excellent' => $criterion->excellent,
                'good' => $criterion->good,
                'satisfactory' => $criterion->satisfactory,
                'unsatisfactory' => $criterion->unsatisfactory,

                'state' => (int) $criterion->state,
                'created_at' => $criterion->created_at,
                'updated_at' => $criterion->updated_at,
            ]
        ]);
    }

    /**
     * Alterna o status (ativo/inativo) de um critério
     */
    public function toggleStatus($id, $action): JsonResponse
    {
        $criterion = Criterion::find($id);

        if (!$criterion) {
            return response()->json(['message' => 'Critério não encontrado!'], 404);
        }

        if ($action === 'inactivate') {
            $criterion->update(['state' => 0]);
        } elseif ($action === 'activate') {
            $criterion->update(['state' => 1]);
        } else {
            return response()->json(['message' => 'Ação inválida!'], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status do critério atualizado com sucesso!',
            'state' => (int)$criterion->state,
            'updated_at' => $criterion->updated_at,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $results = Criterion::where('name', 'like', "%{$query}%")
            ->where('state', 1)
            ->get();

        return response()->json($results);
    }
}
