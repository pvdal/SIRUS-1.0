<?php

namespace App\Http\Controllers;

// Common
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
        ])->orderBy('id')->paginate(15);

        // Mapeamento dos dados paginados
        $committeesData = $committees->getCollection()->map(function ($committee) {
            $group = $committee->paper?->group;

            return [
                'id' => $committee->id,
                'name' => mb_strtoupper($committee->name),
                'members' => $committee->members
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
                        'state' => ($m->user->state ?? 0),
                    ])->values(),
                'coordinator_name' => mb_strtoupper($committee->coordinator?->user?->name),
                'group_id' => $group?->id,
                'group_theme' => mb_strtoupper($group?->theme),
                'group_state' => ($group?->state ?? 0),
                'students' => $group?->students?->map(fn($s) => [
                        'ra' => $s->ra,
                        'name' => $s->user->name,
                        'state' => $s->user->state,
                    ])->values() ?? [],
                'paper' => $committee->paper ? [
                    'id' => $committee->paper->id,
                    'title' => $committee->paper->title,
                    'file_path' => $committee->paper->file_path,
                ] : null,
                'state' => ($committee->state ?? 0),
                'created_at' => $committee->created_at,
                'updated_at' => $committee->updated_at,
            ];
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
            ->orderBy('theme')
            ->get()
            ->map(fn($g) => [
                'id' => $g->id,
                'theme' => $g->theme,
                'papers' => $g->papers->map(fn($p) => [
                    'id' => $p->id,
                    'title' => $p->title,
                    'file_path' => $p->file_path,
                ])->values()->all(),
                'state' => ($g->state ?? 0),
            ])->values()->all();
        #endregion

        return view('evaluation.committees', [
            'committees' => $committeesData,
            'member_types' => $member_types,
            'groups' => $groups,
            'academicStaff' => $coordinators->map(function ($coordinator) {
                return [
                    'id' => $coordinator->id,
                    'name' => $coordinator->user->name ?? '(sem nome)',
                    'user_id' => $coordinator->user_id,
                    'user_type' => [
                        'slug' => 'coordinator',
                        'name' => 'Coordenador',
                    ]
                ];
            })->concat(
                $professors->map(function ($professor) {
                    return [
                        'id' => $professor->id,
                        'name' => $professor->user->name ?? '(sem nome)',
                        'user_id' => $professor->user_id,
                        'user_type' => [
                            'slug' => 'professor',
                            'name' => 'Professor',
                        ]
                    ];
                })
            )->values()
                ->toArray(),
            'page' => $committees->currentPage(),
            'totalPages' => $committees->lastPage(),
        ]);
    }

    // Buscar professores / coordenadores ativos por nome ou ‘id’ ordenados por nome
    public function search(Request $request): JsonResponse
    {
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
            $coordinators->map(function ($coordinator) {
                return [
                    'id' => $coordinator->id,
                    'name' => $coordinator->user->name ?? '(sem nome)',
                    'user_id' => $coordinator->user_id,
                    'user_type' => [
                        'slug' => 'coordinator',
                        'name' => 'Coordenador',
                    ]
                ];
            })->concat(
                $professors->map(function ($professor) {
                    return [
                        'id' => $professor->id,
                        'name' => $professor->user->name ?? '(sem nome)',
                        'user_id' => $professor->user_id,
                        'user_type' => [
                            'slug' => 'professor',
                            'name' => 'Professor',
                        ]
                    ];
                })
            )->values()->all()
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
        ])->orderBy('id');

        #region Filtros
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('paper', function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%");
                })
                    ->orWhereHas('members.user', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('group', function ($sub) use ($search) {
                        $sub->where('theme', 'like', "%{$search}%");
                    })
                    ->orWhereHas('group.students.user', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
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

        $committees = $query->paginate(15);
        //Log::info('Queries executadas:', DB::getQueryLog());

        // Mapeia para retornar somente os campos necessários
        $committeesData = $committees->getCollection()->map(function ($committee) {
            $group = $committee->paper->group;

            return [
                'id' => $committee->id,
                'name' => mb_strtoupper($committee->name),
                'members' => $committee->members
                    ->map(fn($m) => [
                        'user_id' => $m->user_id,
                        'name' => $m->user->name,
                        'user_type' => [
                            'slug' => $m->coordinator_id ? 'coordinator' : 'professor',
                            'name' => $m->coordinator_id ? 'Coordenador' : 'Professor',
                        ],
                        'member_type' => [
                            'id' => $m->memberType?->id,
                            'name' => $m->memberType?->name,
                        ],
                        'state' => $m->user->state,
                    ])->values(),
                'coordinator_name' => mb_strtoupper($committee->coordinator?->user?->name),
                'group_id' => $group?->id,
                'group_theme' => mb_strtoupper($group?->theme),
                'group_state' => $group?->state,
                'students' => $group?->students?->map(fn($s) => [
                        'ra' => $s->ra,
                        'name' => $s->user->name,
                        'state' => $s->user->state,
                    ])->values() ?? [],
                'paper' => $committee->paper ? [
                    'id' => $committee->paper->id,
                    'title' => $committee->paper->title,
                    'file_path' => $committee->paper->file_path,
                ] : null,
                'state' => ($committee->state ?? 0),
                'created_at' => $committee->created_at,
                'updated_at' => $committee->updated_at,
            ];
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
            'academicStaff' => $coordinators->map(function ($coordinator) {
                return [
                    'id' => $coordinator->id,
                    'name' => $coordinator->user->name ?? '(sem nome)',
                    'user_id' => $coordinator->user_id,
                    'user_type' => [
                        'slug' => 'coordinator',
                        'name' => 'Coordenador',
                    ]
                ];
            })->concat(
                $professors->map(function ($professor) {
                    return [
                        'id' => $professor->id,
                        'name' => $professor->user->name ?? '(sem nome)',
                        'user_id' => $professor->user_id,
                        'user_type' => [
                            'slug' => 'professor',
                            'name' => 'Professor',
                        ]
                    ];
                })
            )->values()
                ->toArray(),
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
        $request->validate([
            'name' => 'required|string|max:255|unique:committees,name',
            'paper_id' => [
                'required',
                // Garante que o paper existe
                Rule::exists('papers', 'id'),
                // Garante que o paper ainda não possui uma banca
                Rule::unique('committees', 'paper_id'),
            ],
            'rubric_id' => 'nullable|exists:rubrics,id',
            'members' => 'required|array|min:3',
            'members.*.user_id' => 'required|exists:users,id',
            'members.*.member_type.id' => 'required|exists:member_types,id',
        ]);

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
        });

        $paper = $committee->paper;
        $group = $paper->group;

        $committeeData = [
            'id' => $committee->id,
            'name' => mb_strtoupper($committee->name),
            'members' => $committee->members
                ->filter(fn($item) => $item->user)
                ->map(fn($item) => [
                    'user_id' => $item->user_id,
                    'name' => $item->user->name,
                    'user_type' => [
                        'slug' => $item->committee?->coordinator_id == $item->user_id ? 'coordinator' : 'professor',
                        'name' => $item->committee?->coordinator_id == $item->user_id ? 'Coordenador' : 'Professor',
                    ],
                    'member_type' => [
                        'id' => $item->memberType?->id,
                        'name' => $item->memberType?->name,
                    ]
                ])->values(),
            'coordinator_name' => mb_strtoupper($committee->coordinator?->user?->name),
            'group_id' => $group?->id,
            'group_theme' => mb_strtoupper($group?->theme),
            'group_state' => $group?->state,
            'students' => $group?->students?->map(fn($s) => [
                    'ra' => $s->ra,
                    'name' => $s->user->name,
                ])->values() ?? [],
            'paper' => [
                'id' => $paper->id,
                'title' => $paper->title,
                'file_path' => $paper->file_path,
            ],
            'state' => (int) $committee->state,
            'created_at' => $committee->created_at,
            'updated_at' => $committee->updated_at,
        ];

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
        if(!$id) {
            return response()->json([
                'message' => 'Selecione uma banca!',
            ],422);
        }

        // o nullable de rubric é temporario
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
            'rubric_id' => 'nullable|exists:rubrics,id',
            'members' => 'required|array|min:3',
            'members.*.user_id' => 'required|exists:users,id',
            'members.*.member_type.id' => 'required|exists:member_types,id',
        ]);

        // Busca a banca existente
        $committee = Committee::find($id);

        if(!$committee) {
            return response()->json([
                'message' => 'Banca não encontrada!',
            ], 422);
        }


        $committee->fill([
            'name' => $request['name'],
            //'group_id' => $request['group_id'],
            'paper_id' => $request['paper_id'],
        ]);

        $existingMembers = $committee->members
            ->map(fn($m) => ['user_id' => $m->user_id, 'member_type_id' => $m->member_type_id])
            ->values();

        $newMembers = collect($request['members'])
            ->map(fn($m) => ['user_id' => $m['user_id'], 'member_type_id' => $m['member_type']['id']])
            ->values();

        DB::transaction(function () use ($request, &$committee, &$existingMembers, &$newMembers) {
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
        });

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

        return response()->json([
            'success' => true,
            'message' => 'Banca atualizada com sucesso!',
            'data' => [
                'id' => $committee->id,
                'name' => mb_strtoupper($committee->name),
                'members' => $professorsCommittees
                    ->map(fn($m) => [
                        'user_id' => $m->user_id,
                        'name' => $m->user->name,
                        'user_type' => [
                            'slug' => $m->committee?->coordinator_id == $m->user_id ? 'coordinator' : 'professor',
                            'name' => $m->committee?->coordinator_id == $m->user_id ? 'Coordenador' : 'Professor',
                        ],
                        'member_type' => [
                            'id' => $m->memberType?->id,
                            'name' => $m->memberType?->name,
                        ],
                        'state' => $m->user->state,
                    ])->values(),
                'coordinator_name' => mb_strtoupper($committee->coordinator?->user?->name),
                'group_id' => $group?->id,
                'group_theme' => mb_strtoupper($group?->theme),
                'group_state' => $group?->state,
                'students' => $group?->students?->map(fn($s) => [
                        'ra' => $s->ra,
                        'name' => $s->user->name,
                    ])->values() ?? [],
                'paper' => $committee->paper ? [
                    'id' => $committee->paper->id,
                    'title' => $committee->paper->title,
                    'file_path' => $committee->paper->file_path,
                ] : null,
                'state' => (int) $committee->state,
                'created_at' => $committee->created_at,
                'updated_at' => $committee->updated_at,
            ],
        ]);
    }

    public function toggleStatus($id,$action): JsonResponse
    {
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
}
