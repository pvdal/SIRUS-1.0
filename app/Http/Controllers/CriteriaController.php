<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Criterion;
use Illuminate\Support\Facades\Log;

class CriteriaController extends Controller
{
    /**
     * Exibição inicial de critérios (página principal)
     * 'READ'
     */
    public function index(): View
    {
        // Query inicial da tabela 'criteria' (15 por página).
        $criteria = Criterion::orderBy('name', 'asc')->paginate(15);

        // Mapeia a coleção para um array simples.
        $criteriaData = $criteria->getCollection()->map(function ($criterion) {
            return [
                'id' => $criterion->id,
                'name' => $criterion->name,
                'description' => $criterion->description,
                'state' => (int) $criterion->state,
                'created_at' => $criterion->created_at,
                'updated_at' => $criterion->updated_at,
            ];
        })->values();

        // Retorna a view de gestão de critérios com os dados.
        // Lembre-se de criar a view em: resources/views/management/criteria.blade.php
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
        $query = Criterion::query()->orderBy('name', 'asc');

        // Filtro de busca por texto
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtro por status (ativo/inativo)
        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('state', $status);
        }

        // Filtro por período de criação
        if ($request->filled('period')) {
            $period = $request->input('period');
            $query->when($period === 'today', fn($q) => $q->whereDate('created_at', today()));
            $query->when($period === 'week', fn($q) => $q->whereBetween('created_at', [now()->subDays(7), now()]));
            $query->when($period === 'month', fn($q) => $q->whereBetween('created_at', [now()->subDays(30), now()]));
        }

        $criteria = $query->paginate(15);

        $criteriaData = $criteria->getCollection()->map(function ($criterion) {
            return [
                'id' => $criterion->id,
                'name' => $criterion->name,
                'description' => $criterion->description,
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
            'description' => 'nullable|string',
        ]);

        // Adiciona o estado padrão como ativo (1)
        $validated['state'] = 1;

        $criterion = Criterion::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Critério cadastrado com sucesso.',
            'data' => [
                'id' => $criterion->id,
                'name' => $criterion->name,
                'description' => $criterion->description,
                'state' => (int) $criterion->state,
                'created_at' => $criterion->created_at,
                'updated_at' => $criterion->updated_at,
            ]
        ], 201); // HTTP 201 Created
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
            // Garante que o nome seja único, exceto para o próprio registro
            'name' => "required|string|max:255|unique:criteria,name,{$id}",
            'description' => 'nullable|string',
        ]);

        $criterion->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Critério atualizado com sucesso!',
            'data' => [
                'id' => $criterion->id,
                'name' => $criterion->name,
                'description' => $criterion->description,
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
            'state' => (int) $criterion->state,
            'updated_at' => $criterion->updated_at,
        ]);
    }
}
