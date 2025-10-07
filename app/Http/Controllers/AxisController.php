<?php

namespace App\Http\Controllers;

use App\Models\Axis;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AxisController extends Controller
{
    /**
     * Lista os eixos.
     */
    public function index()
    {
        // MUDANÇA IMPORTANTE:
        // Não precisamos mais de withCount(). Apenas with('criteria') para o modal de edição.
        $axisCollection = Axis::with('criteria')->orderBy('name', 'asc')->paginate(15);

        $totalAmount = $axisCollection->total();

        // O map agora fica mais simples, pois 'amount' vem direto do banco.
        $axisData = $axisCollection->getCollection()->map(function ($axis) {
            return [
                'id' => $axis->id,
                'name' => $axis->name,
                'amount' => $axis->amount, // Lendo diretamente da coluna do banco.
                'state' => (int) $axis->state,
                'created_at' => $axis->created_at,
                'updated_at' => $axis->updated_at,
                'criteria' => $axis->criteria, // Necessário para o modal de edição
            ];
        })->values();

        return view('evaluation.axis', [
            'axis' => $axisData,
            'amount' => $totalAmount,
            'page' => $axisCollection->currentPage(),
            'totalPages' => $axisCollection->lastPage(),
        ]);
    }

    /**
     * Salva um novo Eixo e a contagem de critérios.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:axes,name',
            'criteria' => 'nullable|array',
            'criteria.*' => 'exists:criteria,id'
        ]);

        // MUDANÇA IMPORTANTE: Contamos os critérios antes de criar.
        $criteriaCount = count($validatedData['criteria'] ?? []);

        // Criamos o eixo já com o nome e a contagem.
        $axis = Axis::create([
            'name' => $validatedData['name'],
            'amount' => $criteriaCount,
            'state' => 1
        ]);

        if (!empty($validatedData['criteria'])) {
            $axis->criteria()->sync($validatedData['criteria']);
        }

        return response()->json($axis, 201);
    }

    /**
     * Atualiza um Eixo e a contagem de critérios.
     */
    public function update(Request $request, string $id)
    {
        $axis = Axis::findOrFail($id);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('axes')->ignore($axis->id)],
            'criteria' => 'nullable|array',
            'criteria.*' => 'exists:criteria,id'
        ]);

        // MUDANÇA IMPORTANTE: Recontamos os critérios.
        $criteriaCount = count($validatedData['criteria'] ?? []);

        // Atualizamos o eixo com o nome e a nova contagem.
        $axis->update([
            'name' => $validatedData['name'],
            'amount' => $criteriaCount
        ]);

        $axis->criteria()->sync($request->input('criteria', []));

        return response()->json($axis);
    }


    public function show(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = Axis::query()->orderBy('name');

        // Filtro por busca (nome do eixo)
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        // Filtro por status
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

        // Filtro por período de cadastro
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
        $perPage = 10;
        $page = $request->get('page', 1);
        $axes = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $axes->items(),
            'page' => $axes->currentPage(),
            'totalPages' => $axes->lastPage(),
        ]);
    }


    public function toggleStatus($id,$action): JsonResponse
    {
        $axis = Axis::find($id);

        if (!$axis) {
            return response()->json([
                'message' => 'Eixo não encontrado!'
            ], 422);
        }

        if ($action === 'inactivate') {
            $axis->update(['state' => 0]);
        } elseif ($action === 'activate') {
            $axis->update(['state' => 1]);
        }  else {
            return response()->json([
                'message' => 'Ação inválida!'
            ], 422);
        }

        $axis->touch();

        return response()->json([
            'success' => true,
            'message' => 'Grupo atualizado com sucesso!',
            'state' => (int) $axis->state,
            'created_at' => $axis->created_at,
            'updated_at' => $axis->updated_at,
        ]);
    }


}
