<?php

namespace App\Http\Controllers;

use App\Models\Axis;
use App\Models\Criterion;
use App\Models\Rubric;
use App\Utils\TokenGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Random\RandomException;



class RubricController extends Controller
{
    /**
     * @throws RandomException
     */
    public function index(): View
    {
        TokenGenerator::initializeTab();

        $axesAvailable = Axis::all(['name']);
        $rubrics = Rubric::with(['axes.criteria']) // eager load: axes -> criteria (cada criteria terá pivot axis_criteria)
            ->select(['id','name','type','state','created_at','updated_at'])
            ->orderBy('id') // Ordenar por mais recente é comum
            ->paginate(16);

        $rubricsData = $rubrics->getCollection()->map(function ($rubric) {
            return $this->mapRubric($rubric);
        })->values();

        return(view('evaluation.rubrics', [
            'rubrics' => $rubricsData,
            'axes' => $axesAvailable ,
            'page' => $rubrics->currentPage(),
            'totalPages' => $rubrics->lastPage(),
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // 1. Busca todos os eixos cadastrados no banco de dados.
        $axesAvailables = Axis::all();

        // 2. Retorna a view 'rubricas.create' e passa a variável
        return view('evaluation.rubrics', [
            'eixosDisponiveis' => $axesAvailables
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request): JsonResponse
    {
        Log::info($request);
        // 1. VALIDAÇÃO: O "filtro de segurança" que garante que os dados estão corretos.
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|integer|in:1,2',
            'axes' => 'required|array|min:1',
            'axes.*.id' => 'required|integer|exists:axes,id',
            'axes.*.weight' => 'required|numeric|min:1',
        ]);

        // Verificar se a soma dos pesos é exatamente 100
        $totalWeight = collect($validatedData['axes'])->sum('weight');

        if ($totalWeight !== 100) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'axes' => ['A soma dos pesos dos eixos deve ser exatamente 100%.'],
            ]);
        }

        // Busca critérios de todos os eixos informados
        $allCriteria = \App\Models\Axis::whereIn('id', collect($validatedData['axes'])->pluck('id'))
            ->with('criteria:id') // assumindo relação Axis->criteria()
            ->get()
            ->pluck('criteria.*.id')
            ->flatten();
        // Retorna exceção caso hajam eixos com critérios iguais
        if ($allCriteria->duplicates()->isNotEmpty()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'axes' => 'Existem critérios repetidos em eixos diferentes.'
            ]);
        }

        // 2. TRANSAÇÃO: Garante que a operação seja "tudo ou nada".
        try {
            $rubric = DB::transaction(function () use ($validatedData) {
                // 3. CRIA A RÚBRICA: Insere na tabela 'rubrics'.
                $newRubric = Rubric::create([
                    'name' => $validatedData['name'],
                    'type' => $validatedData['type'],
                    'state' => 1, // Ativo por padrão
                ]);

                // 4. O PONTO CENTRAL - PREPARA OS DADOS PARA A TABELA PIVÔ
                $axesToSync = [];
                foreach ($validatedData['axes'] as $axisData) {
                    // O formato do array é: [ id_do_eixo => [ dados_da_tabela_pivo ] ]
                    $axesToSync[$axisData['id']] = [
                        'weight' => $axisData['weight'],
                        // Adicione aqui valores padrão para outros campos da tabela pivô, se necessário
                        // 'amount' => 1,
                    ];
                }

                // 5. SALVA NA TABELA PIVÔ ('rubric_axis')
                // O método sync do Eloquent faz a mágica de criar as associações.
                $newRubric->axes()->sync($axesToSync);

                return $newRubric;
            });

            // 6. PREPARA A RESPOSTA DE SUCESSO
            // Carrega a relação 'axes' recém-criada para retornar os dados completos.
            $rubric->load('axes');
            $responseData = $this->mapRubric($rubric);

            return response()->json([
                'success' => true,
                'message' => 'Rubrica salva com sucesso!',
                'data' => $responseData
            ], 201);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao salvar a rúbrica.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function search(Request $request): JsonResponse
    {
        $q = $request->get('q');

        $axes = Criterion::where('name', 'like', "%{$q}%")
            ->where('state', 1)
            ->get();

        return response()->json($axes);
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse
    {
        // Cria a query inicial, trazendo rubrica com eixos e critérios
        $query = Rubric::with([
            'axes', // relacionamento Rubric -> RubricAxis -> Axis
            'axes.criteria' // relacionamento Axis -> AxisCriteria -> Criteria
        ])->orderBy('id');

        // ===== Filtros =====
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('axes', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%")
                            ->orWhereHas('criteria', function ($sub2) use ($search) {
                                $sub2->where('name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('state', $request->input('status'));
        }

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
        $rubrics = $query->paginate(16);

        $data = $rubrics->getCollection()->map(function ($rubric) {
            return $this->mapRubric($rubric);
        })->values();

        return response()->json([
            'data' => $data,
            'current_page' => $rubrics->currentPage(),
            'last_page' => $rubrics->lastPage(),
            'per_page' => $rubrics->perPage(),
            'total' => $rubrics->total(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id): JsonResponse
    {
//        dump($id);
//        dd($id);

//        if(!$id) {
//            return response()->json([
//                'message' => 'Selecione uma rubrica!',
//            ],422);
//        }
        $rubric = Rubric::findOrFail($id);
        // 1. VALIDAÇÃO: Similar ao store, mas ignora o nome da própria rúbrica na regra 'unique'.
//        $validatedData = $request->validate([
//            'name' => ['required', 'string', 'max:255', Rule::exists('rubrics', 'id'),
//            'type' => 'required|string|in:individual,in_group',
//            'axes' => 'required|array|min:1',
//            'axes.*.id' => ['required', 'integer', Rule::exists('axes', 'id')],
//            'axes.*.weight' => 'required|numeric|min:0',
//        ]);
//        dump($rubric);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|integer|in:1,2',
            'axes' => 'required|array|min:1',
            'axes.*.id' => 'required|integer|exists:axes,id',
            'axes.*.weight' => 'required|numeric|min:1',
        ]);

        // Verificar se a soma dos pesos é exatamente 100
        $totalWeight = collect($validatedData['axes'])->sum('weight');

        if ($totalWeight !== 100) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'axes' => ['A soma dos pesos dos eixos deve ser exatamente 100%.'],
            ]);
        }

        // 2. TRANSAÇÃO: Novamente, para garantir a integridade.
        DB::transaction(function () use ($validatedData, $rubric) {
            // 3. ATUALIZA A RÚBRICA: Modifica a linha na tabela 'rubrics'.
            $rubric->update([
                'name' => $validatedData['name'],
                'type' => $validatedData['type'],
            ]);

            // 4. PREPARA OS DADOS PARA A PIVÔ (Exatamente igual ao store)
            $axesToSync = [];
            foreach ($validatedData['axes'] as $axisData) {
                $axesToSync[$axisData['id']] = [
                    'weight' => $axisData['weight'],
                ];
            }

            // 5. A MAGIA DO SYNC NA ATUALIZAÇÃO
            // O sync vai:
            //   - Adicionar novos eixos que estão no array mas não no banco.
            //   - Remover eixos que estão no banco mas não no array.
            //   - Atualizar o 'weight' dos eixos que já existiam.
            $rubric->axes()->sync($axesToSync);
        });

        // 6. PREPARA A RESPOSTA DE SUCESSO
        $rubric->load('axes');

        return response()->json([
            'success' => true,
            'message' => 'Rubrica atualizada com sucesso!',
            'data' =>  $this->mapRubric($rubric)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function mapRubric(Rubric $rubric): array
    {
        return [
            'id' => $rubric->id,
            'name' => $rubric->name,
            'type' => $rubric->type,
            'state' => $rubric->state,
            'created_at' => $rubric->created_at,
            'updated_at' => $rubric->updated_at,
            'axes' => $rubric->axes->map(fn($axis) => [
                'id' => $axis->id,
                'name' => $axis->name, // Adicionado para conveniência
                // Acessando todos os dados da tabela pivô 'rubric_axis'
                'weight' => $axis->pivot->weight,
                'type' => $axis->pivot->type,
                'criteria' => $axis->criteria->map(fn($criterion) => [
                    'id' => $criterion->id,
                    'name' => $criterion->name,
                    'unsatisfactory' => $criterion->unsatisfactory,
                    'satisfactory' => $criterion->satisfactory,
                    'good' => $criterion->good,
                    'excellent' => $criterion->excellent,
                ])->values(),

            ])->values(),
        ];
    }

    public function toggleStatus($id,$action): JsonResponse
    {
        $rubric = Rubric::find($id);

        if (!$rubric) {
            return response()->json([
                'message' => 'Rubrica não encontrada!'
            ], 422);
        }

        if ($action === 'inactivate') {
            $rubric->update(['state' => 0]);
        } elseif ($action === 'activate') {
            $rubric->update(['state' => 1]);
        }  else {
            return response()->json([
                'message' => 'Ação inválida!'
            ], 422);
        }

        $rubric->touch();

        return response()->json([
            'success' => true,
            'message' => 'Rubrica atualizada com sucesso!',
            'state' => (int) $rubric->state,
            'created_at' => $rubric->created_at,
            'updated_at' => $rubric->updated_at,
        ]);
    }

    public function showModelView(Rubric $rubric)
    {
        // Carrega os eixos e, para cada eixo, carrega os seus critérios.
        $rubric->load('axes.criteria');

        // Retorna a nova view passando a rúbrica com todos os dados carregados.
        return view('components.evaluation.rubric-preview', [
            'rubric' => $rubric,
        ]);
    }
}
