<?php

namespace App\Http\Controllers;

// Common
use App\Models\Course;
use App\Services\PaperService;
use App\Utils\StringResolve;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// Models
use App\Models\Paper;
use App\Models\User;
use App\Models\Group;
use App\Models\Student;

// Transações no banco
use Illuminate\Support\Facades\DB;

// Log
//use Illuminate\Support\Facades\Log;

// Static Classes and utils
use Random\RandomException;
use App\Utils\TokenGenerator;

use Illuminate\Support\Facades\Storage;
use Throwable;

class GroupController extends Controller
{
    /**
     * @throws RandomException
     */
    // Exibição inicial de grupos sem aplicação de filtros ou troca de página (‘READ’)
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        // Inicializa o DynamicToken
        TokenGenerator::initializeTab();
        // Faz uma query no banco trazendo 15 registros paginados
        $groups = Group::with([
            'papers',
            'students.user:id,name,state,updated_at,created_at'
        ])->orderBy('id')->paginate(15);
        // Mapeia os dados manualmente
        $groupsData = $groups->getCollection()->map(function ($group) {
            return [
                'id' => $group->id,
                'theme' => mb_strtoupper($group->theme),
                'state' => ($group->state ?? 0),
                'papers' => $group->papers->map(fn($p) => [
                    'id' => $p->id,
                    'title' => $p->title,
                    'file_path' => $p->file_path,
                ]),
                'students' => $group->students->map(fn($s) => [
                    'ra' => $s->ra,
                    'name' => $s->user->name,
                    'state' => ($s->user->state ?? 0),
                ]),
                'created_at' => $group->created_at,
                'updated_at' => $group->updated_at,
            ];
        })->values();

        $courses = Course::select(['id', 'name'])
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                ];
            })->values();

        //dd($groupsData->toArray());
        return view('management.groups', [
            'groups' => $groupsData,
            'courses' => $courses,
            'page' => $groups->currentPage(),
            'totalPages' => $groups->lastPage(),
        ]);
    }

    // Buscar alunos ativos por nome ou RA
    public function search(Request $request): JsonResponse
    {
        $q = $request->query('q', '');
        // Traz alunos ativos com name ou RA pesquisados
        $students = Student::with(['user:id,name'])
            ->whereHas('user', function ($sub) {
                $sub->where('state', 1);
            })
            ->where(function ($query) use ($q) {
                $query->whereHas('user', function ($sub) use ($q) {
                    $sub->where('name', 'like', '%' . $q . '%');
                })
                    ->orWhere('ra', 'like', '%' . $q . '%');
            })
            ->select('ra', 'user_id', 'group_id')
            ->limit(20)
            ->get();

        $students->load('group:id,theme');

        return response()->json(
            $students->map(fn($student) => [
                'ra' => $student->ra,
                'name' => $student->user->name ?? '(sem nome)',
                'group' => $student->group->theme ?? null,
            ])->values()->all() // <-- converte Collection para array
        );
    }

    // Exibição de grupos com aplicação de filtros ou troca de página (‘READ’)
    public function show(Request $request): JsonResponse
    {
        //DB::enableQueryLog();
        $query = Group::with([
            'papers:id,title,file_path,group_id',
            'students.user:id,name,state,updated_at,created_at',
        ])->orderBy('id');

        #region Filtros
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('theme', 'like', "%{$search}%")
                    ->orWhereHas('students.user', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('students', function ($sub) use ($search) {
                        $sub->where('ra', 'like', "%{$search}%");
                    })
                    ->orWhereHas('papers', function ($sub) use ($search) {
                        $sub->where('title', 'like', "%{$search}%");
                    });
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

        $groups = $query->paginate(15);

        #region Dados auxiliares
        #endregion

        //Log::info('Queries executadas:', DB::getQueryLog());

        // Mapeia para retornar somente os campos necessários
        $groupsData = $groups->getCollection()->map(function ($group) {
            return [
                'id' => $group->id,
                'theme' => mb_strtoupper($group->theme),
                'state' => ($group->state ?? 0),
                'papers' => $group->papers->map(fn($p) => [
                    'id' => $p->id,
                    'title' => $p->title,
                    'file_path' => $p->file_path,
                ]),
                'students' => $group->students->map(fn($s) => [
                    'ra' => $s->ra,
                    'name' => $s->user->name,
                    'state' => ($s->user->state ?? 0),
                ]),
                'created_at' => $group->created_at,
                'updated_at' => $group->updated_at,
            ];
        })->values();

        return response()->json([
            'data' => $groupsData,
            'page' => $groups->currentPage(),
            'totalPages' => $groups->lastPage(),
        ]);
    }

    /**
     * @throws Throwable
     */
    // Cadastro de grupos (‘CREATE’)
    public function store(Request $request, PaperService $paperService): JsonResponse
    {
        $request->validate([
            'theme' => 'required|string|max:255|unique:groups,theme',
            'file' => 'nullable|file|mimes:pdf|max:10240',
            'members' => 'required|array|min:1',
            'members.*' => 'required|string|exists:students,ra',
        ]);

        // Verifica se algum aluno já está em outro grupo
        $alunosEmOutroGrupo = Student::whereIn('ra', $request->members)
            ->whereNotNull('group_id')
            ->exists();
        // Se ja está em outro grupo, retorna mensagem de erro e encerra o método
        if ($alunosEmOutroGrupo) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'members' => ['Um ou mais alunos já pertencem a outro grupo.'],
                ],
            ], 422);
        }

        $group = null; // Inicia a variável

        DB::transaction(function () use ($request, &$group, &$paperService) {
            $group = Group::create([
                'theme' => $request->theme,
                'state' => 1,
            ]);

            Student::whereIn('ra', $request->members)
                ->update(['group_id' => $group->id]);

            if ($request->hasFile('file')) {
                $request['year'] = 2025;
                $request['semester'] = 2;
                $request['version'] = 'avaliacao';
                $request['course'] = 'Gestão de Tecnologia da Informação';
                $request['project'] = 1;

                $sanitize = fn($v) => preg_replace('/[^a-zA-Z0-9_áàâãéèêíïóôõöúç-]/u', '_', $v);
                $folders = array_map($sanitize, [
                    $request->year,
                    'semestre_' . $request->semester,
                    $request->version,
                    $request->course,
                    'projeto_integrador_' . $request->project,
                ]);

                $folders = array_map(fn ($v) => StringResolve::normalizeFolderName($v), $folders);

                $paperService->createPaper($request->file('file'), $group->id, $folders);
            }
        });

        $group->load(['papers', 'students.user']);

        return response()->json([
            'success' => true,
            'message' => 'Grupo salvo com sucesso!',
            'data' => [
                'id' => $group->id,
                'theme' => mb_strtoupper($group->theme),
                'state' => $group->state,
                'papers' => $group->papers->map(fn($p) => [
                    'id' => $p->id,
                    'title' => $p->title,
                    'file_path' => $p->file_path,
                ]),
                'students' => $group->students->map(fn($s) => [
                    'ra' => $s->ra,
                    'name' => $s->user->name,
                ]),
                'created_at' => $group->created_at,
                'updated_at' =>  $group->updated_at,
            ]
        ]);
    }

    /**
     * @throws Throwable
     */
    public function update(Request $request, $id, PaperService $paperService): JsonResponse
    {
        if(!$id) {
            return response()->json([
                'message' => 'Selecione um grupo!',
            ],422);
        }

        $request->validate([
            'theme' => "required|string|max:255|unique:groups,theme,{$id},id",
            'file' => 'nullable|file|mimes:pdf|max:10240',
            'members' => 'required|array|min:1',
            'members.*' => 'required|string|exists:students,ra',
        ]);

        // Busca o grupo existente
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'message' => 'Grupo não encontrado!'
            ], 422);
        }

        // Verifica se algum aluno está em outro grupo diferente do atual. O front já oferece uma proteção inicial
        $alunosEmOutroGrupo = Student::whereIn('ra', $request->members)
            ->where(function ($query) use ($group) {
                $query->whereNotNull('group_id')->where('group_id', '<>', $group->id);
            })
            ->exists();

        if ($alunosEmOutroGrupo) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'members' => ['Um ou mais alunos já pertencem a outro grupo.'],
                ],
            ], 422);
        }

        DB::transaction(function () use ($request, $group, &$paperService) {
            // Atualiza o tema
            if($group->theme != $request->theme) {
                $group->update([
                    'theme' => $request->theme,
                ]);
            }

            // Remove o group_id dos alunos que não estão mais no grupo
            $removed = Student::where('group_id', $group->id)
                ->whereNotIn('ra', $request->members)
                ->update(['group_id' => null]);

            if($removed > 0) $group->touch();

            // Atualiza o group_id dos alunos selecionados
            $added = Student::whereIn('ra', $request->members)
                ->where(function ($q) use ($group) {
                    $q->whereNull('group_id')
                        ->orWhere('group_id', '<>', $group->id);
                })
                ->update(['group_id' => $group->id]);

            if($added > 0) $group->touch();

            // Se tem arquivo novo, salva e cria novo Paper, removendo antigo
            if ($request->hasFile('file')) {
                $request['year'] = 2025;
                $request['semester'] = 2;
                $request['version'] = 'avaliacao';
                $request['course'] = 'Gestão de Tecnologia da Informação';
                $request['project'] = 1;

                $sanitize = fn($v) => preg_replace('/[^a-zA-Z0-9_áàâãéèêíïóôõöúç-]/u', '_', $v);
                $folders = array_map($sanitize, [
                    $request->year,
                    'semestre_' . $request->semester,
                    $request->version,
                    $request->course,
                    'projeto_integrador_' . $request->project,
                ]);

                $folders = array_map(fn ($v) => StringResolve::normalizeFolderName($v), $folders);

                $paperService->updatePaper($request->file('file'), $group, $folders);
            }
        });

        // Recarrega completamente grupo + alunos + papers
        $group = Group::with(['papers', 'students.user'])->find($id);

        return response()->json([
            'success' => true,
            'message' => 'Grupo atualizado com sucesso!',
            'data' => [
                'id' => $group->id,
                'theme' => mb_strtoupper($group->theme),
                'state' => (int) $group->state,
                'papers' => $group->papers->map(fn($p) => [
                    'id' => $p->id,
                    'title' => $p->title,
                    'file_path' => $p->file_path,
                ]),
                'students' => $group->students->map(fn($s) => [
                    'ra' => $s->ra,
                    'name' => $s->user->name,
                ]),
                'created_at' => $group->created_at,
                'updated_at' => $group->updated_at,
            ]
        ]);
    }

    public function toggleStatus($id,$action): JsonResponse
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'message' => 'Grupo não encontrado!'
            ], 422);
        }

        if ($action === 'inactivate') {
            $group->update(['state' => 0]);
        } elseif ($action === 'activate') {
            $group->update(['state' => 1]);
        }  else {
            return response()->json([
                'message' => 'Ação inválida!'
            ], 422);
        }

        $group->touch();

        return response()->json([
            'success' => true,
            'message' => 'Grupo atualizado com sucesso!',
            'state' => (int) $group->state,
            'created_at' => $group->created_at,
            'updated_at' => $group->updated_at,
        ]);
    }
}
