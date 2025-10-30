<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\UserCommittee;
use App\Models\GroupEvaluation;
use App\Models\IndividualEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\View\View; // Importe a classe View

class EvaluationController extends Controller
{
    /**
     * PONTO DE ENTRADA PRINCIPAL
     * Decide se o usuário deve AVALIAR ou VER RESULTADOS.
     */
    public function index(Committee $committee): View // Define que o retorno é uma View
    {
        $user = Auth::user();

        // Tenta encontrar o registro de avaliação deste usuário para esta banca
        $userCommittee = $committee->members()
            ->where('user_id', $user->id)
            ->first();

        // --- A BIFURCAÇÃO (O "GARFO") ---

        // CONDIÇÃO:
        // 1. O usuário é Aluno (Nível 1)
        // 2. O usuário é Admin/Coordenador (Nível 3+) E NÃO é membro da banca
        if ($user->access_level === 1 || ($user->isAdmin() && $userCommittee === null))
        {
            // CAMINHO A: Mostrar a tela de TABS com TODOS os resultados
            return $this->showResultsView($committee);

        } else {

            // CAMINHO B: Mostrar o formulário de avaliação do PRÓPRIO usuário
            // (Garante que $userCommittee não é null, pois senão teria caído no 'if' acima)
            if (!$userCommittee) {
                // Segurança: Professor Nível 2 que não é da banca, mas o Gate 'view-evaluation' falhou.
                abort(403, 'Você não é membro desta banca.');
            }
            return $this->showEvaluatorView($userCommittee);
        }
    }

    /**
     * CAMINHO A: Prepara e retorna a View de RESULTADOS (TABS)
     * para Alunos e Coordenadores não-membros.
     */
    private function showResultsView(Committee $committee): View
    {
        // 1. Carrega os dados base
        $committee->load('paper.group.students.user', 'rubric.axes.criteria');

        // 2. Carrega TODOS os avaliadores que JÁ SUBMETERAM a avaliação
        $completedEvaluations = $committee->members()
            ->whereNotNull('evaluated_at')
            ->with(['user', 'groupEvaluations', 'individualEvaluations'])
            ->get();

        // 3. Formata os dados da Rubrica e Alunos (Igual a antes)
        $data = $this->formatBaseEvaluationData($committee);

        // 4. Formata as AVALIAÇÕES COMPLETAS em um array para as TABS
        $data['evaluations'] = $completedEvaluations->map(function ($eval) {
            // Formata avaliações de GRUPO [criteria_id => grade]
            $groupSels = $eval->groupEvaluations->pluck('grade', 'criteria_id');

            // Formata avaliações INDIVIDUAIS [ra => [criteria_id => grade]]
            $indivSels = [];
            foreach ($eval->individualEvaluations as $iEval) {
                $indivSels[$iEval->ra][$iEval->criteria_id] = (float)$iEval->grade; // Converte para número
            }

            return [
                'evaluatorName' => $eval->user->name,
                'evaluatedAt' => $eval->evaluated_at->format('d/m/Y \à\s H:i'),
                'groupSelections' => (object)$groupSels,
                'individualSelections' => (object)$indivSels,
            ];
        });

        // 5. Retorna a NOVA view 'evaluation.results'
        return view('evaluation.evaluation-results', ['pageData' => $data]);
    }


    /**
     * CAMINHO B: Prepara e retorna a View de FORMULÁRIO
     * para o Professor/Avaliador membro da banca.
     */
    private function showEvaluatorView(UserCommittee $userCommittee): View
    {
        // 1. Carrega os dados base
        $committee = $userCommittee->committee;
        $data = $this->formatBaseEvaluationData($committee);

        // 2. Define o estado de "somente leitura" (usando o Gate)
        $data['isReadOnly'] = Gate::denies('evaluate-paper', $committee);
        $data['userCommitteeId'] = $userCommittee->id;

        // 3. Carrega as avaliações salvas DESTE usuário
        $data['groupSelections'] = (object)[];
        $data['individualSelections'] = (object)[];

        if ($data['isReadOnly']) {
            $data['groupSelections'] = $userCommittee->groupEvaluations
                ->pluck('grade', 'criteria_id');

            $indivSels = [];
            foreach ($userCommittee->individualEvaluations as $eval) {
                $indivSels[$eval->ra][$eval->criteria_id] = (float)$eval->grade;
            }
            $data['individualSelections'] = (object)$indivSels;
        }


        return view('evaluation.evaluation', ['evaluationData' => $data]);
    }


    /**
     * Função auxiliar para formatar os dados base (Rubrica, Alunos, etc.)
     * Reutilizada pelos dois métodos acima para evitar duplicação.
     */
    private function formatBaseEvaluationData(Committee $committee)
    {
        // Garante que os dados estão carregados
        $committee->loadMissing('paper.group.students.user', 'rubric.axes.criteria');

        $paper = $committee->paper;
        $group = $paper->group;
        $rubric = $committee->rubric;

        if (!$paper || !$group || !$rubric) {
            abort(404, 'Dados incompletos para esta banca (Falta Paper, Grupo ou Rubrica).');
        }

        // Formata os dados
        $students = $group->students->map(function ($student) {
            return [
                'id'   => $student->ra,
                'name' => $student->user->name,
            ];
        });

        $gradeLevels = [
            ['label' => 'Insatisfatório', 'value' => 2, 'key' => 'insatisfatorio'],
            ['label' => 'Regular',       'value' => 6, 'key' => 'regular'],
            ['label' => 'Bom',           'value' => 8, 'key' => 'bom'],
            ['label' => 'Excelente',     'value' => 10, 'key' => 'excellent']
        ];

        $allAxes = $rubric->axes->map(function ($axis) {
            $axisType = $axis->pivot->type;
            return [
                'id'   => $axis->id,
                'name' => $axis->name,
                'type' => $axisType,
                'criteria' => $axis->criteria->map(function ($criterion) {
                    return [
                        'id'   => $criterion->id,
                        'name' => $criterion->name,
                        'descriptions' => [
                            'insatisfatorio' => $criterion->unsatisfactory,
                            'regular'        => $criterion->satisfactory,
                            'bom'            => $criterion->good,
                            'excellent'      => $criterion->excellent,
                        ]
                    ];
                })
            ];
        });

        // Retorna o pacote de dados base
        return [
            'evaluatorName' => Auth::user()->name, // Nome do usuário logado (Aluno ou Coord.)
            'groupName'     => $group->theme,
            'paperTitle'    => $paper->title,
            'paperProject'  => $paper->project,
            'students'      => $students,
            'gradeLevels'   => $gradeLevels,
            'rubric'        => [
                'id' => $rubric->id,
                'name' => $rubric->name,
                'axes' => $allAxes,
            ],
        ];
    }


    /**
     * FUNÇÃO 2: SALVAR A AVALIAÇÃO NO BANCO
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        // 1. --- VALIDAÇÃO DOS DADOS ---
        $validator = Validator::make($request->all(), [
            'user_committee_id' => 'required|integer|exists:user_committees,id',
            'group_evaluations' => 'nullable|array',
            'group_evaluations.*' => 'numeric|in:2,6,8,10', // Garante que as notas são as permitidas
            'individual_evaluations' => 'nullable|array',
            'individual_evaluations.*.*' => 'numeric|in:2,6,8,10', // Garante as notas
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $userCommitteeId = $request->input('user_committee_id');

        // 2. --- SEGURANÇA ---
        $userCommittee = UserCommittee::find($userCommitteeId);

        if ($userCommittee->user_id !== Auth::id()) {
            return response()->json(['error' => 'Não autorizado.'], 403);
        }

        if ($userCommittee->evaluated_at !== null) {
            return response()->json(['error' => 'Esta avaliação já foi enviada.'], 403);
        }

        // 3. --- LÓGICA DE SALVAMENTO (Transaction) ---
        // Usamos uma transaction para garantir que ou tudo é salvo, ou nada é.
        DB::beginTransaction();
        try {

            // A. Salvar Avaliações em GRUPO
            if (!empty($validatedData['group_evaluations'])) {
                foreach ($validatedData['group_evaluations'] as $criteria_id => $grade) {
                    GroupEvaluation::updateOrCreate(
                        [ // Condições para encontrar (se já existir)
                            'user_committee_id' => $userCommitteeId,
                            'criteria_id' => $criteria_id,
                        ],
                        [ // Valores para atualizar ou criar
                            'grade' => $grade
                        ]
                    );
                }
            }

            // B. Salvar Avaliações INDIVIDUAIS
            if (!empty($validatedData['individual_evaluations'])) {
                foreach ($validatedData['individual_evaluations'] as $student_ra => $criteria) {
                    foreach ($criteria as $criteria_id => $grade) {
                        IndividualEvaluation::updateOrCreate(
                            [ // Condições
                                'user_committee_id' => $userCommitteeId,
                                'ra' => $student_ra,
                                'criteria_id' => $criteria_id,
                            ],
                            [ // Valores
                                'grade' => $grade
                            ]
                        );
                    }
                }
            }

            // C. Marcar a avaliação como concluída na tabela 'user_committees'
            $userCommittee->evaluated_at = Carbon::now();
            $userCommittee->save();

            DB::commit(); // Sucesso! Confirma as operações no banco.

            return response()->json(['success' => 'Avaliação salva com sucesso!']);

        } catch (\Exception $e) {
            DB::rollBack(); // Algo deu errado, desfaz tudo.
            return response()->json(['error' => 'Ocorreu um erro ao salvar a avaliação.', 'message' => $e->getMessage()], 500);
        }
    }
}
