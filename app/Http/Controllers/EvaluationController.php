<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Student;
use App\Models\UserCommittee;
use App\Models\GroupEvaluation;
use App\Models\IndividualEvaluation;
use App\Utils\TokenGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\View\View;
use Random\RandomException;

// Importe a classe View

class EvaluationController extends Controller
{
    /**
     * PONTO DE ENTRADA PRINCIPAL
     * Decide se o usuário deve AVALIAR ou VER RESULTADOS.
     * @throws RandomException
     */
    public function index(Committee $committee): View|RedirectResponse
    {

        $user = Auth::user();
        $ra = $user->student?->ra;

        // 1. Definição de Permissões
        $isAuthorizedByGate = Gate::allows('view-evaluation', $committee);
        $isFutureCommittee = $committee->start > now();

        $hasParticipation = false;
        if ($user->access_level === 1 && $ra) {
            $hasParticipation = IndividualEvaluation::where('ra', $ra)
                ->whereHas('userCommittee', function($q) use ($committee) {
                    $q->where('committee_id', $committee->id);
                })->exists();
        }

        // --- REGRA DE ACESSO PARA ALUNOS ---
        if ($user->access_level === 1 && !$user->isAdmin()) {

            // O aluno só entra se:
            // (Ele tem nota OU é uma banca futura do grupo atual)
            $canAccess = $hasParticipation || ($isAuthorizedByGate && $isFutureCommittee);

            if (!$canAccess) {
                return back()->with([
                    'flash.banner' => 'Acesso negado: Esta banca já ocorreu e você não participou dela.',
                    'flash.bannerStyle' => 'warning'
                ]);
            }
        }
        // --- REGRA DE ACESSO PARA OUTROS (Admin/Avaliadores) ---
        else if (!$isAuthorizedByGate && !$user->isAdmin()) {
            return back()->with([
                'flash.banner' => 'Você não tem permissão para acessar esta avaliação.',
                'flash.bannerStyle' => 'danger'
            ]);
        }
        // Inicializa o DynamicToken
        TokenGenerator::initializeTab();

        $userCommittee = $committee->members()
            ->where('user_id', $user->id)
            ->first();

        if ($user->access_level === 2){
            if(is_null($userCommittee?->evaluated_at) && $response = $this->validateCommitteeSchedule($committee)) {
                return $response;
            }
            return $this->showEvaluatorView($userCommittee);
        }

        else if ($user->access_level === 1 || $user->isAdmin())
        {
            if (Gate::allows('evaluate-paper', $committee)) {
                if($this->validateCommitteeSchedule($committee)) {
                    return $this->showResultsView($committee);
                }
                return $this->showEvaluatorView($userCommittee);

            } else {
                return $this->showResultsView($committee); // Mostra as TABS
            }
        }
        // Caminho de Segurança:
        else {
            abort(403, 'Seu nível de acesso não tem permissão para esta página.');
        }
    }

    private function validateCommitteeSchedule($committee)
    {
        $now = Carbon::now();
        $start = Carbon::parse($committee->start);
        $end = Carbon::parse($committee->end)->addHours(4);

        if(is_null($committee->start) && is_null($committee->end)){
            return back()->with([
                'flash.banner' => 'Banca não agendada!',
                'flash.bannerStyle' => 'danger'
            ]);
        } else if($now->lt($start)) {
            return back()->with([
                'flash.banner' => 'Banca não iniciada!',
                'flash.bannerStyle' => 'danger'
            ]);
        } else if($now->gt($end)){
            return back()->with([
                'flash.banner' => 'Banca finalizada!',
                'flash.bannerStyle' => 'danger'
            ]);
        }

        return null;
    }

    /**
     * CAMINHO A: Prepara e retorna a View de RESULTADOS (TABS)
     * para Alunos e Coordenadores não-membros.
     */
    private function showResultsView(Committee $committee): View
    {
        // Variavel usada para pegar os RAs de todos os alunos que receberam nota individual nesta banca
        $evaluatedRAs = IndividualEvaluation::whereHas('userCommittee', function($q) use ($committee) {
            $q->where('committee_id', $committee->id);
        })->distinct()->pluck('ra')->toArray();

        // 1. Carrega os dados base
        $committee->load('paper.group.students.user', 'rubrics.rubric.axes.criteria');

        // 2. Carrega TODOS os avaliadores que JÁ SUBMETERAM a avaliação
        $completedEvaluations = $committee->members()
            ->whereNotNull('evaluated_at')
            ->with(['user', 'groupEvaluations', 'individualEvaluations'])
            ->get();

        // 3. Formata os dados da Rubrica e Alunos (Igual a antes)
        $data = $this->formatBaseEvaluationData($committee);

        $data['students'] = collect($data['students'])->filter(function ($student) use ($evaluatedRAs) {
            return in_array($student['id'], $evaluatedRAs);
        })->values()->all();

        // 4. Formata as AVALIAÇÕES COMPLETAS em um array para as TABS
        $data['evaluations'] = $completedEvaluations->map(function ($eval) {
            // Formata avaliações de GRUPO [criteria_id => grade]
//            $groupSels = $eval->groupEvaluations->pluck('grade', 'criteria_id');
            $groupSels = $eval->groupEvaluations->mapWithKeys(function($ge) {
                return [$ge->criteria_id => ['grade' => (float)$ge->grade, 'comment' => $ge->comment]];
            });

            // Formata avaliações INDIVIDUAIS [ra => [criteria_id => grade]]
            $indivSels = [];
            foreach ($eval->individualEvaluations as $iEval) {
//                $indivSels[$iEval->ra][$iEval->criteria_id] = (float)$iEval->grade; // Converte para número
                $indivSels[$iEval->ra][$iEval->criteria_id] = [
                    'grade' => (float)$iEval->grade,
                    'comment' => $iEval->comment,
                ];
            }



            return [
                'evaluatorName' => $eval->user->name,
                'evaluatedAt' => $eval->evaluated_at->format('d/m/Y \à\s H:i'),
                'groupSelections' => $groupSels,
                'individualSelections' => $indivSels,
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
                ->mapWithKeys(fn($e) => [
                    $e->criteria_id => [
                        'grade' => (float)$e->grade,
                        'comment' => $e->comment,
                    ]
                ]);

            $indivSels = [];
            foreach ($userCommittee->individualEvaluations as $eval) {
                $indivSels[$eval->ra][$eval->criteria_id] = [
                    'grade'=>(float)$eval->grade,
                    'comment'=>$eval->comment,];
            }
            $data['individualSelections'] = (object)$indivSels;
        }

        return view('evaluation.evaluation', ['evaluationData' => $data]);
    }


    /**
     * Função auxiliar para formatar os dados base (Rubrica, Alunos, etc.)
     * Reutilizada pelos dois métodos acima para evitar duplicação.
     */

    private function formatAxis($axis, $type) // $type é 'in group' ou 'individual'
    {
        $criteriaCount = $axis->amount > 0 ? $axis->amount : $axis->criteria->count();

        return [
            'id'   => $axis->id,
            'name' => $axis->name,
            'type' => $type, // <-- Usa o TIPO que passámos (da rubrica mãe)
            // Adicionamos '?? 0' para segurança, caso a relação não traga o pivô
            'weight'   => $axis->pivot->weight ?? 1,
            'amount'   => $criteriaCount,
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
    }
    private function formatBaseEvaluationData(Committee $committee)
    {
        // 1. Carrega as relações N:N corretamente
        $committee->loadMissing([
            'paper.group.students.user',
            'rubrics.rubric.axes.criteria' // Committee -> CommitteeRubric -> Rubric -> Axis -> Criterion
        ]);

        $paper = $committee->paper;
        $group = $paper->group;

        // 1. Pegamos os RAs de quem REALMENTE tem nota nesta banca (Histórico)
        $evaluatedRAs = IndividualEvaluation::whereHas('userCommittee', function($q) use ($committee) {
            $q->where('committee_id', $committee->id);
        })->distinct()->pluck('ra')->toArray();

        // 2. Pegamos os RAs de quem está no grupo HOJE (Futuro/Presente)
        $currentRAs = $group->students->pluck('ra')->toArray();

        // 3. Unimos os dois (sem duplicatas)
        $allRAs = array_unique(array_merge($evaluatedRAs, $currentRAs));

        $committeeRubrics = $committee->rubrics;

        $groupCommitteeRubric = $committeeRubrics->first(function ($cr) {
            // Verifica se a rubrica existe E se o tipo dela é 1 (Grupo)
            return $cr->rubric && $cr->rubric->type == 1;
        });

        $individualCommitteeRubric = $committeeRubrics->first(function ($cr) {
            // Verifica se a rubrica existe E se o tipo dela é 2 (Individual)
            return $cr->rubric && $cr->rubric->type == 2;
        });

        // 4. Extrai os modelos 'Rubric' reais
        $groupRubric = $groupCommitteeRubric ? $groupCommitteeRubric->rubric : null;
        $individualRubric = $individualCommitteeRubric ? $individualCommitteeRubric->rubric : null;

        if (!$paper || !$group || $committeeRubrics->isEmpty()) {
            abort(404, 'Dados incompletos para esta banca (Falta Paper, Grupo ou Rubrica).');
        }

        $students = Student::whereIn('ra', $allRAs)
            ->with('user:id,name')
            ->get()
            ->map(function ($student) {
                return [
                    'id'   => $student->ra,
                    'name' => $student->user->name,
                ];
            });
        $allAxes = collect();

        // Adiciona os Eixos da Rubrica de GRUPO (Type 1)
        if ($groupRubric) {
            $groupAxes = $groupRubric->axes->map(function ($axis) {
                return $this->formatAxis($axis, 'in group'); // Corrigido
            });
            $allAxes = $allAxes->merge($groupAxes);
        }

        // Adiciona os Eixos da Rubrica INDIVIDUAL (Type 2)
        if ($individualRubric) {
            $individualAxes = $individualRubric->axes->map(function ($axis) {
                return $this->formatAxis($axis, 'individual'); // Corrigido
            });
            $allAxes = $allAxes->merge($individualAxes);
        }


        $gradeLevels = [
            ['label' => 'Insatisfatório', 'value' => 2, 'key' => 'insatisfatorio'],
            ['label' => 'Regular',       'value' => 6, 'key' => 'regular'],
            ['label' => 'Bom',           'value' => 8, 'key' => 'bom'],
            ['label' => 'Excelente',     'value' => 10, 'key' => 'excellent']
        ];


        // Retorna o pacote de dados base
        return [
            'evaluatorName' => Auth::user()->name,
            'groupName'     => $group->theme,
            'paperTitle'    => $paper->title,
            'paperProject'  => $paper->project,
            'students'      => $students,
            'gradeLevels'   => $gradeLevels,
            'committeeName' => $committee->name,
            'committeeStart' => $committee->start ?? null,
            'committeeEnd'   => $committee->end ?? null,
            'rubric'        => [
                'id' => $committee->id,
                'nameGroup' => $groupRubric->name,
                'nameIndividual' => $individualRubric->name,
                'axes' => $allAxes,
                'groupRubricWeight' => $groupCommitteeRubric ? $groupCommitteeRubric->weight : 1,
                'individualRubricWeight' => $individualCommitteeRubric ? $individualCommitteeRubric->weight : 1,
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
            'group_evaluations' => 'required|array',
            'group_evaluations.*.grade' => 'numeric|in:2,6,8,10', // Garante que as notas são as permitidas
            'group_evaluations.*.comment' => 'nullable|string|max:1000',

            'individual_evaluations' => 'required|array',
            'individual_evaluations.*.*.grade' => 'numeric|in:0,2,6,8,10', // Garante as notas
            'individual_evaluations.*.*.comment' => 'nullable|string|max:1000',
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
                foreach ($validatedData['group_evaluations'] as $criteria_id => $selection) {
                    GroupEvaluation::updateOrCreate(
                        [ // Condições para encontrar (se já existir)
                            'user_committee_id' => $userCommitteeId,
                            'criteria_id' => $criteria_id,
                            'grade' => $selection['grade'],
                            'comment' => $selection['comment'] ?? null,
                        ]
                    );
                }
            }

            // B. Salvar Avaliações INDIVIDUAIS
            if (!empty($validatedData['individual_evaluations'])) {
                foreach ($validatedData['individual_evaluations'] as $student_ra => $criteria) {
                    foreach ($criteria as $criteria_id => $selection) {
                        IndividualEvaluation::updateOrCreate(
                            [ // Condições
                                'user_committee_id' => $userCommitteeId,
                                'ra' => $student_ra,
                                'criteria_id' => $criteria_id,
                                'grade' => $selection['grade'],
                                'comment' => $selection['comment'] ?? null,
                            ]
                        );
                    }
                }
            }

            // C. Marcar a avaliação como concluída na tabela 'user_committees'
            $userCommittee->evaluated_at = Carbon::now();
            $userCommittee->save();

            $committee = Committee::with('paper:id,title,submitted_at')
                ->find($userCommittee->committee_id);

            $paper = $committee?->paper;

            if ($paper && $paper->submitted_at === null) {
                $paper->submitted_at = now();
                $paper->save();
            }

            DB::commit(); // Sucesso! Confirma as operações no banco.

            return response()->json(['success' => 'Avaliação salva com sucesso!']);

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Erro ao salvar avaliação', [
                'exception' => $e,
            ]);

            return response()->json([
                'error' => 'Ocorreu um erro ao salvar a avaliação.',
            ], 500);
        }
    }

}
