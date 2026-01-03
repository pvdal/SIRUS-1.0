<?php

namespace App\Http\Controllers;

// Common
use App\Models\CommitteeRubric;
use App\Models\Paper;
use App\Models\Rubric;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// Models
use App\Models\Committee;
use App\Models\Coordinator;
use App\Models\Group;
use App\Models\MemberType;
use App\Models\Professor;
use App\Models\UserCommittee;
use App\Models\User;

// Transações no banco
use Illuminate\Support\Facades\DB;

// Log
//use Illuminate\Support\Facades\Log;

// Static Classes and utils
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Random\RandomException;
use App\Utils\TokenGenerator;

use Illuminate\Validation\Rule;
use Throwable;

class CommitteeController extends Controller
{
    /**
     * @throws RandomException
     */
    // Exibição inicial de bancas sem aplicação de filtros ou troca de página (‘READ’)
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        // Inicializa o DynamicToken
        TokenGenerator::initializeTab();

        // Paginação agora em cima de Committee
        $committees = Committee::with([
            'coordinator.user:id,name',
            'members.user:id,name,state,access_level', // todos membros (professor/coordenador)
            'members.memberType',
            'paper.group.students.user:id,name,state',
            'rubrics.rubric:id,name,type,state',
        ])
            ->orderBy('id')
            ->when(Gate::denies('manage-events'), function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('members', function ($sub) {
                        $sub->where('user_id', auth()->id());
                    })

                    ->orWhereHas('paper.group.students', function ($sub) {
                        $sub->where('user_id', auth()->id());
                    });
                })
                ->where('state', 1);
            })
            ->paginate(16);

        // Mapeamento dos dados paginados
        $committeesData = $committees->getCollection()->map(function ($committee) {
            return $this->mapCommittee($committee);
        })->values();

        $coordinators = [];
        $professors = [];
        $member_types = [];
        $groups = [];
        $rubrics = [];

        #region Dados auxiliares
        if(Gate::allows('manage-events')){
            $coordinators = Coordinator::with('user:id,name')
                ->whereHas('user', function ($sub) {
                    $sub->where('state', 1);
                })
                ->select(['id', 'user_id'])
                ->orderBy(
                    User::select('name')
                        ->whereColumn('users.id', 'coordinators.user_id')
                )
                ->get();

            $professors = Professor::with('user:id,name')
                ->whereHas('user', function ($sub) {
                    $sub->where('state', 1);
                })
                ->select(['id', 'user_id'])
                ->orderBy(
                    User::select('name')
                        ->whereColumn('users.id', 'professors.user_id')
                )
                ->get();

            $member_types = MemberType::orderBy('name')->get();

            $groups = Group::with('papers:id,title,file_path,group_id,version')
                ->where('state', 1)
                ->orderBy('theme')
                ->get()
                ->map(fn($g) => [
                    'id' => $g->id,
                    'theme' => $g->theme,
                    'papers' => $g->papers->map(fn($p) => [
                        'id' => $p->id,
                        'title' => $p->title,
                        'file_path' => $p->file_path,
                        'version' => $p->version,
                    ])->values()->all(),
                    'state' => ($g->state ?? 0),
                ])->values()->all();
        }
        #endregion

        return view('evaluation.committees', [
            'committees' => $committeesData,
            'member_types' => $member_types,
            'groups' => $groups,
            'academicStaff' => $this->mapAcademicStaff($coordinators, $professors),
            'page' => $committees->currentPage(),
            'totalPages' => $committees->lastPage(),
        ]);
    }

    // Buscar rubricas ativas por nome ou ‘id’ ordenados por nome
    public function searchRubrics(Request $request): JsonResponse
    {
        $this->authorize('manage-events');

        $q = strtolower($request->query('q', ''));

        // Mapeamento de palavras-chave para type
        $typeMap = [
            'grupo' => 1,
            'individual' => 2,
        ];

        // Verifica se a query corresponde a algum type
        $typeFilter = $typeMap[$q] ?? null;

        // Traz rubricas ativas com nome ou ‘id’ pesquisado
        $rubrics = Rubric::where('state', 1)
            ->where(function ($query) use ($q, $typeFilter) {
                if ($typeFilter) {
                    $query->where('type', $typeFilter);
                } else {
                    $query->where('name', 'like', '%' . $q . '%')
                        ->orWhere('id', 'like', '%' . $q . '%');
                }
            })
            ->limit(15)
            ->orderBy('name')
            ->get();

        // Mapeia rubricas para o formato JSON
        $mapped = $rubrics->map(fn($rubric) => [
            'id' => $rubric->id,
            'name' => $rubric->name ?? '(sem nome)',
            'type' => $rubric->type,
            'state' => $rubric->state,
        ])->toArray();

        return response()->json($mapped);
    }

    // Buscar professores / coordenadores ativos por nome ou ‘id’ ordenados por nome
    public function searchMembers(Request $request): JsonResponse
    {
        $this->authorize('manage-events');

        $q = $request->query('q', '');

        // Traz coordenadores ativos com nome ou ‘id’ pesquisado
        $coordinators = Coordinator::with('user:id,name')
            ->whereHas('user', function ($sub) {
                $sub->where('state', 1);
            })
            ->where(function ($query) use ($q) {
                $query->whereHas('user', function ($sub) use ($q) {
                    $sub->where('name', 'like', '%' . $q . '%');
                })
                    ->orWhere('id', 'like', '%' . $q . '%');
            })
            ->select(['id', 'user_id'])
            ->limit(5)
            ->orderBy(
                User::select('name')
                    ->whereColumn('users.id', 'coordinators.user_id')
            )
            ->get();

        // Traz professores ativos com nome ou ‘id’ pesquisado
        $professors = Professor::with('user:id,name')
            ->whereHas('user', function ($sub) {
                $sub->where('state', 1);
            })
            ->where(function ($query) use ($q) {
                $query->whereHas('user', function ($sub) use ($q) {
                    $sub->where('name', 'like', '%' . $q . '%');
                })
                    ->orWhere('id', 'like', '%' . $q . '%');
            })
            ->select(['id', 'user_id'])
            ->limit(15)
            ->orderBy(
                User::select('name')
                    ->whereColumn('users.id', 'professors.user_id')
            )
            ->get();

        // Retorna array concatenada dos coordenadores + professores
        return response()->json(
            $this->mapAcademicStaff($coordinators, $professors),
        );
    }

    // Exibição de bancas com aplicação de filtros ou troca de página (‘READ’)
    public function show(Request $request): JsonResponse
    {
        //DB::enableQueryLog();
        $query = Committee::with([
            'coordinator.user:id,name',
            'members.user:id,name,state',   // todos membros (professor/coordenador)
            'members.memberType',
            'paper.group.students.user:id,name,state',
            'rubrics.rubric:id,name,type,state',
        ])
            ->when(Gate::denies('manage-events'), function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('members', function ($sub) {
                        $sub->where('user_id', auth()->id());
                    })

                        ->orWhereHas('paper.group.students', function ($sub) {
                            $sub->where('user_id', auth()->id());
                        });
                })
                    ->where('state', 1);
            })
            ->orderBy('id');

        #region Filtros
        if($request->has('history') && $request->boolean('history')) {
            $query->whereHas('members', function ($q) {
                $q->whereHas('user', function ($sub) {
                    $sub->where('id', auth()->user()->id);
                });
            });
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('paper', function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%");
                })
                    ->orWhereHas('members', function ($sub) use ($search) {
                        $sub->whereHas('user', function ($sub2) use ($search) {
                            $sub2->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->orWhereHas('paper.group', function ($sub) use ($search) {
                        $sub->where('theme', 'like', "%{$search}%");
                    })
                    ->orWhereHas('paper.group.students', function ($sub) use ($search) {
                        $sub->whereHas('user', function ($sub2) use ($search) {
                            $sub2->where('name', 'like', "%{$search}%");
                        });
                    })
                    ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('state', $status);
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
        #endregion

        $committees = $query->paginate(16);
        //Log::info('Queries executadas:', DB::getQueryLog());

        // Mapeia para retornar somente os campos necessários
        $committeesData = $committees->getCollection()->map(function ($committee) {
            return $this->mapCommittee($committee);
        })->values();

        #region Dados auxiliares
        $coordinators = Coordinator::with('user:id,name')
            ->whereHas('user', function ($sub) {
                $sub->where('state', 1);
            })
            ->select(['id', 'user_id'])
            ->orderBy(
                User::select('name')
                    ->whereColumn('users.id', 'coordinators.user_id')
            )
            ->get();

        $professors = Professor::with('user:id,name')
            ->whereHas('user', function ($sub) {
                $sub->where('state', 1);
            })
            ->select(['id', 'user_id'])
            ->orderBy(
                User::select('name')
                    ->whereColumn('users.id', 'professors.user_id')
            )
            ->get();

        $member_types = MemberType::orderBy('name')->get();

        $groups = Group::with('papers:id,title,file_path,group_id')
            ->where('state', 1)
            ->get()
            ->map(fn($g) => [
                'id' => $g->id,
                'theme' => $g->theme,
                'papers' => $g->papers->map(fn($p) => [
                    'id' => $p->id,
                    'title' => $p->title,
                    'file_path' => $p->file_path,
                ])->values()->all(),
                'state' => (int) $g->state,
            ])->values()->all();
        #endregion

        return response()->json([
            'data' => $committeesData,
            'member_types' => $member_types,
            'groups' => $groups,
            'academicStaff' => $this->mapAcademicStaff($coordinators, $professors),
            'page' => $committees->currentPage(),
            'totalPages' => $committees->lastPage(),
        ]);
    }

    /**
     * @throws Throwable
     */
    // Cadastro de bancas (‘CREATE’)
    public function store(Request $request): JsonResponse
    {
        $this->authorize('manage-events');
        $request->validate([
            'name' => 'required|string|max:255|unique:committees,name',
            'group_id' => 'required|exists:groups,id',
            'paper_id' => 'required|exists:papers,id|unique:committees,paper_id',
            'rubrics' => 'required|array|min:2',
            'rubrics.*.id' => 'required|integer|exists:rubrics,id',
            'rubrics.*.weight' => 'required|numeric|min:1',
            'members' => 'required|array|min:3',
            'members.*.user_id' => 'required|exists:users,id',
            'members.*.member_type.id' => 'required|exists:member_types,id',
        ]);

        #region Verificação extra
        // Verificar se a soma dos pesos é exatamente 100
        $totalWeight = collect($request->rubrics)->sum('weight');
        if ($totalWeight !== 100) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'rubrics' => ['A soma dos pesos das rubricas deve ser exatamente 100%.'],
            ]);
        }
        // Verificar se há rubricas duplicadas
        $rubricIds = collect($request->rubrics)->pluck('id');
        if ($rubricIds->unique()->count() !== $rubricIds->count()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'rubrics' => ['Não podem haver rubricas duplicadas.'],
            ]);
        }
        // Verificar se há tipos de rubricas duplicadas
        $rubricTypes = collect($request->rubrics)->pluck('type');
        if ($rubricTypes->unique()->count() !== $rubricTypes->count()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'rubrics' => ['Pode haver apenas uma rubrica de cada tipo.'],
            ]);
        }
        // Verificar se há user_id duplicado
        $userIds = collect($request->members)->pluck('user_id');
        if ($userIds->unique()->count() !== $userIds->count()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'members' => ['Não podem haver usuários duplicados.'],
            ]);
        }
        // Verificar se a versão é de avaliação
        $paper = Paper::find($request->paper_id);
        if (!$paper || $paper->version !== 'evaluation') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'paper_id' => 'Apenas versões de avaliação são permitidas.',
            ]);
        }
        #endregion

        $coordinator = auth()->user()->coordinator;
        if (!$coordinator) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário logado não é um coordenador válido.',
            ], 422);
        }

        $request->merge(['coordinator_id' => $coordinator->id]);

        $committee = null;

        DB::transaction(function () use ($request, &$committee) {
            $committee = Committee::create([
                'name' => $request->name,
                'coordinator_id' => $request->coordinator_id,
                'paper_id' => $request->paper_id,
                'state' => 1,
            ]);

            foreach ($request->members as $member) {
                UserCommittee::create([
                    'committee_id' => $committee->id,
                    'user_id' => $member['user_id'],
                    'member_type_id' => $member['member_type']['id'],
                ]);
            }

            foreach ($request->rubrics as $rubric) {
                committeeRubric::create([
                    'committee_id' => $committee->id,
                    'rubric_id' => $rubric['id'],
                    'weight' => $rubric['weight'],
                    'state' => 1,
                ]);
            }
        });

        $committeeData = $this->mapCommittee($committee);

        return response()->json([
            'success' => true,
            'message' => 'Banca salva com sucesso!',
            'data' => $committeeData,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function update(Request $request, $id): JsonResponse
    {
        $this->authorize('manage-events');

        if(!$id) {
            return response()->json([
                'message' => 'Selecione uma banca!',
            ],422);
        }

        // Busca a banca existente
        $committee = Committee::with('paper')->find($id);

        if(!$committee) {
            return response()->json([
                'message' => 'Banca não encontrada!',
            ], 422);
        }

        $evaluated = $committee->paper->submitted_at ?? null;

        // Se já houve atualização, não pode atualizar
        if ($evaluated) {
            if($request->corrected_paper_id !== $committee->corrected_paper_id) {
                $request->validate([
                    'corrected_paper_id' => [
                        'nullable',
                        Rule::exists('papers', 'id')->where(function ($query) use ($request) {
                            $query->where('group_id', $request->group_id);
                        }),
                        "unique:committees,corrected_paper_id,{$id},id",
                        'different:paper_id',
                    ],
                ]);
                // Verificar se a versão é de avaliação
                $evaluationPaper = Paper::find($request->paper_id);
                if (!$evaluationPaper || $evaluationPaper->version !== 'evaluation') {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'paper_id' => 'Apenas versões de avaliação são permitidas.',
                    ]);
                }
                // Verificar se a versão é corrigida
                if($request->corrected_paper_id) {
                    $correctedPaper= Paper::find($request->corrected_paper_id);
                    if (!$correctedPaper || $correctedPaper->version !== 'corrected') {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'corrected_paper_id' => 'Apenas versões corrigidas são permitidas.',
                        ]);
                    }
                }
                if ($evaluationPaper && $evaluationPaper->submitted_at) {
                    $committee->update([
                        'corrected_paper_id' => $request->corrected_paper_id,
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Banca atualizada com sucesso!',
                    'data' => $this->mapCommittee($committee),
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'A banca já realizou esta avaliação. Só é permitido atualizar o trabalho corrigido.',
            ], 422);
        }

        $request->validate([
            'name' => "required|string|max:255|unique:committees,name,{$id},id",
            'group_id' => 'required|exists:groups,id',
            'paper_id' => [
                'required',
                Rule::exists('papers', 'id')->where(function ($query) use ($request) {
                    $query->where('group_id', $request->group_id);
                }),
                "unique:committees,paper_id,{$id},id",
            ],
            'corrected_paper_id' => [
                'nullable',
                Rule::exists('papers', 'id')->where(function ($query) use ($request) {
                    $query->where('group_id', $request->group_id);
                }),
                "unique:committees,corrected_paper_id,{$id},id",
                'different:paper_id',
            ],
            'rubrics' => 'required|array|min:2',
            'rubrics.*.id' => 'required|integer|exists:rubrics,id',
            'rubrics.*.weight' => 'required|numeric|min:1',
            'members' => 'required|array|min:3',
            'members.*.user_id' => 'required|exists:users,id',
            'members.*.member_type.id' => 'required|exists:member_types,id',
        ]);

        #region Verificação extra
        // Verificar se a soma dos pesos é exatamente 100
        $totalWeight = collect($request->rubrics)->sum('weight');
        if ($totalWeight !== 100) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'rubrics' => ['A soma dos pesos das rubricas deve ser exatamente 100%.'],
            ]);
        }
        // Verificar se há rubricas duplicadas
        $rubricIds = collect($request->rubrics)->pluck('id');
        if ($rubricIds->unique()->count() !== $rubricIds->count()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'rubrics' => ['Não podem haver rubricas duplicadas.'],
            ]);
        }
        // Verificar se há tipos de rubricas duplicadas
        $rubricTypes = collect($request->rubrics)->pluck('type');
        if ($rubricTypes->unique()->count() !== $rubricTypes->count()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'rubrics' => ['Pode haver apenas uma rubrica de cada tipo.'],
            ]);
        }
        // Verificar se há user_id duplicado
        $userIds = collect($request->members)->pluck('user_id');
        if ($userIds->unique()->count() !== $userIds->count()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'members' => ['Não podem haver usuários duplicados.'],
            ]);
        }
        // Verificar se a versão é de avaliação
        $evaluationPaper = Paper::find($request->paper_id);
        if (!$evaluationPaper || $evaluationPaper->version !== 'evaluation') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'paper_id' => 'Apenas versões de avaliação são permitidas.',
            ]);
        }
        // Verificar se a versão é corrigida
        if($request->corrected_paper_id) {
            $correctedPaper= Paper::find($request->corrected_paper_id);
            if (!$correctedPaper || $correctedPaper->version !== 'corrected') {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'corrected_paper_id' => 'Apenas versões corrigidas são permitidas.',
                ]);
            }
        }
        #endregion

        $committee->fill([
            'name' => $request['name'],
            'paper_id' => $request['paper_id'],
            'corrected_paper_id' => $request['corrected_paper_id'],
        ]);

        $existingMembers = $committee->members
            ->map(fn($m) => ['user_id' => $m->user_id, 'member_type_id' => $m->member_type_id])
            ->values();

        $newMembers = collect($request['members'])
            ->map(fn($m) => ['user_id' => $m['user_id'], 'member_type_id' => $m['member_type']['id']])
            ->values();

        $existingRubrics = $committee->rubrics
            ->map(fn($r) => ['rubric_id' => $r->rubric_id, 'weight' => $r->weight])
            ->values();

        $newRubrics = collect($request['rubrics'])
            ->map(fn($r) => ['rubric_id' => $r['id'], 'weight' => $r['weight']])
            ->values();

        DB::transaction(function () use ($request, &$committee, &$existingMembers, &$newMembers, &$existingRubrics, &$newRubrics) {
            if($committee->isDirty()) {
                $committee->save();
            }

            // Compara os arrays
            if ($existingMembers->toArray() !== $newMembers->toArray()) {
                // Só atualiza se houver mudança
                $committee->members()->delete();

                foreach ($newMembers as $member) {
                    UserCommittee::create([
                        'committee_id' => $committee->id,
                        'user_id' => $member['user_id'],
                        'member_type_id' => $member['member_type_id'],
                    ]);
                }
                $committee->touch();
            }

            if ($existingRubrics->toArray() !== $newRubrics->toArray()) {
                // Só atualiza se houver mudança
                $committee->rubrics()->delete();

                foreach ($request->rubrics as $rubric) {
                    committeeRubric::create([
                        'committee_id' => $committee->id,
                        'rubric_id' => $rubric['id'],
                        'weight' => $rubric['weight'],
                        'state' => 1,
                    ]);
                }
                $committee->touch();
            }
        });

        /*
        $professorsCommittees = UserCommittee::with([
            'user:id,name,state',
            'committee.coordinator.user:id,name',
            'committee.paper.group.students' => function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('state', 1);
                })
                    ->with(['user:id,name,state']);
            },
            'memberType',
        ])->where('committee_id', $committee->id)
            ->get();

        $group = $committee->paper->group;
        */

        $committee->load([
            'coordinator.user:id,name',
            'members.user:id,name,state,access_level',
            'members.memberType',
            'paper.group.students.user:id,name,state',
            'rubrics.rubric:id,name,type,state',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Banca atualizada com sucesso!',
            'data' => $this->mapCommittee($committee),
        ]);
    }

    public function toggleStatus($id,$action): JsonResponse
    {
        $this->authorize('manage-events');

        $committee = Committee::find($id);

        if (!$committee) {
            return response()->json([
                'message' => 'Banca não encontrada!',
            ], 422);
        }

        if ($action === 'inactivate') {
            $committee->update(['state' => 0]);
        } elseif ($action === 'activate') {
            $committee->update(['state' => 1]);
        }  else {
            return response()->json([
                'message' => 'Ação inválida!'
            ], 422);
        }

        $committee->touch();

        return response()->json([
            'success' => true,
            'message' => 'Grupo atualizado com sucesso!',
            'state' => (int) $committee->state,
            'created_at' => $committee->created_at,
            'updated_at' => $committee->updated_at,
        ]);
    }

    private function mapCommittee($committee): array
    {
        $group = $committee->paper?->group;

        return [
            'id' => $committee->id,
            'name' => $committee->name,
            'members' => $committee->members
                ->filter(fn($member) => $member->user)
                ->map(fn($m) => [
                    'user_id' => $m->user_id,
                    'name' => $m->user->name,
                    'user_type' => [
                        'slug' => $m->user->access_level === 3 ? 'coordinator' : 'professor',
                        'name' => $m->user->access_level === 3 ? 'Coordenador' : 'Professor',
                    ],
                    'member_type' => [
                        'id' => $m->memberType?->id,
                        'name' => $m->memberType?->name,
                    ],
                    'state' => (int) $m->user->state,
                ])->values() ?? [],
            'coordinator_name' => $committee->coordinator?->user?->name,
            'group_id' => $group?->id,
            'group_theme' => $group?->theme,
            'group_state' => (int) $group?->state,
            'students' => $group?->students?->map(fn($s) => [
                    'ra' => $s->ra,
                    'name' => $s->user->name,
                    'state' => (int) $s->user->state,
                ])->values() ?? [],
            'paper' => [
                'evaluation' => $committee->paper ? [
                    'id' => $committee->paper->id,
                    'title' => $committee->paper->title,
                    'file_path' => $committee->paper->file_path,
                    'version' => $committee->paper->version,
                    'submitted' => $committee->paper->submitted_at !== null,
                ] : null,

                'corrected' => $committee->correctedPaper ? [
                    'id' => $committee->correctedPaper->id,
                    'title' => $committee->correctedPaper->title,
                    'file_path' => $committee->correctedPaper->file_path,
                    'version' => $committee->correctedPaper->version,
                ] : null,
            ],
            'rubrics' => $committee?->rubrics?->map(fn($r) => [
                'id' => $r->rubric->id,
                'name' => $r->rubric->name,
                'type' => $r->rubric->type,
                'weight' => $r->weight,
                'state' => (int) $r->rubric->state,
                ])->values() ?? [],
            'state' => (int) $committee->state,
            'created_at' => $committee->created_at,
            'updated_at' => $committee->updated_at,
            // Indica se o usuário autenticado pertence à comissão
            'belongsTo' => $committee->members
                ->contains(fn($m) => $m->user_id === auth()->id())
                ||
                $committee->paper?->group?->students->contains(
                    fn($s) => $s->user_id === auth()->id()
                ),

            // Indica se o usuário autenticado já avaliou
            'evaluatedByUser' => UserCommittee::where('user_id', auth()->id())
                ->where('committee_id', $committee->id)
                ->whereNotNull('evaluated_at')
                ->exists(),
        ];
    }

    private function mapAcademicStaff($coordinators, $professors): array
    {
        if(Gate::denies('manage-events')) return [];
        $mapStaff = fn($collection,$slug,$name) => $collection->map(fn($member) => [
            'id' => $member->id,
            'name' => $member->user->name ?? '(sem nome)',
            'user_id' => $member->user_id,
            'user_type' => [
                'slug' => $slug,
                'name' => $name,
            ]
        ]);

        return $mapStaff($coordinators,'coordinator','Coordenador')
            ->concat($mapStaff($professors,'professor','Professor'))
            ->values()
            ->toArray();
    }
}
