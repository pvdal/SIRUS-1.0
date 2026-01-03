<?php

namespace App\Http\Controllers;

// Common
use App\Models\Course;
use App\Services\PaperService;
use App\Utils\StringResolve;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// Models
use App\Models\Paper;
use App\Models\Group;
use App\Models\Student;

// Transações no banco
use Illuminate\Support\Facades\DB;

// Log
//use Illuminate\Support\Facades\Log;

// Static Classes and utils
use Illuminate\Support\Facades\Log;
use Random\RandomException;
use App\Utils\TokenGenerator;

use Throwable;

class GroupController extends Controller
{
    /**
     * @throws RandomException
     */
    // Exibição inicial de grupos sem aplicação de filtros ou troca de página (‘READ’)
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        TokenGenerator::initializeTab();// Inicializa o DynamicToken

        $groups = Group::with([ // Faz uma query no banco trazendo 15 registros paginados
            'papers',
            'students.user:id,name,state,updated_at,created_at'
        ])->orderBy('id')->paginate(16);

        $groupsData = $groups->getCollection()->map(function ($group) { // Mapeia os dados manualmente
            return $this->mapGroup($group);
        })->values();

        $courses = Course::select(['id', 'name'])
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                ];
            })->values();

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

        $students = Student::with(['user:id,name']) // Traz alunos ativos com name ou RA pesquisados
            ->whereHas('user', function ($sub) {
                $sub->where('state', 1);
            })
            ->where(function ($query) use ($q) {
                $query->whereHas('user', function ($sub) use ($q) {
                    $sub->where('name', 'like', '%' . $q . '%');
                })
                    ->orWhere('ra', 'like', '%' . $q . '%');
            })
            ->select(['ra', 'user_id', 'group_id'])
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
            'papers',
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

        $groups = $query->paginate(16);

        //Log::info('Queries executadas:', DB::getQueryLog());

        $groupsData = $groups->getCollection()->map(function ($group) { // Mapeia para retornar somente os campos necessários
            return $this->mapGroup($group);
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
        //$this->extractPapersTitle($request);

        if ($request->papers) {
            foreach ($request->papers as $i => $paper) {
                if ($request->hasFile("papers.$i.file")) {
                    $clearTitle = preg_replace('/\.pdf$/i', '', ($paper['title'] ?? ''));

                    $request->merge([
                        "papers.$i.title" => $clearTitle,
                    ]);
                }
            }
        }

        $currentYear = date('Y');

        //Log::info($request->all());
        $request->validate([
            'theme' => 'required|string|max:255|unique:groups,theme',
            'members' => 'required|array|min:1',
            'members.*' => 'required|string|exists:students,ra',
            'papers' => 'nullable|array|min:1|max:12',
            'papers.*.title' => [
                'required_with:papers',
                'string',
                'max:255',
                'unique:papers,title',
                function ($attribute, $value, $fail) use ($request) {
                    $titles = array_map(fn($p) => $p['title'], $request->papers);
                    if (count(array_filter($titles, fn($t) => $t === $value)) > 1) {
                        $fail("O arquivo com título '{$value}' está duplicado");
                    }
                }
            ],
            'papers.*.file' => 'required_with:papers|file|mimes:pdf|max:5120',
            'papers.*.year' => "required_with:papers|integer|digits:4|between:" . 2024 . "," . ($currentYear),
            'papers.*.semester' => 'required_with:papers|integer|in:1,2',
            'papers.*.version' => 'required_with:papers|string|in:evaluation,corrected',
            'papers.*.course' => 'required_with:papers|integer|exists:courses,id',
            'papers.*.project' => 'required_with:papers|integer|between:1,6',
        ]);

        // Verifica se algum aluno já está em outro grupo
        $alunosEmOutroGrupo = Student::whereIn('ra', $request->members)
            ->whereNotNull('group_id')
            ->exists();
        // Se já está em outro grupo, retorna mensagem de erro e encerra a função
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
            if($request->papers) {
                foreach ($request->papers as $i => $paper) {
                    if ($request->hasFile("papers.$i.file")) {

                        $folders = $this->prepareFolders($paper);

                        $paperService->createPaper($request->file("papers.$i.file"), $group->id, $folders, $paper['title']);
                    }
                }
            }

        });

        $group->load(['papers', 'students.user']);

        return response()->json([
            'success' => true,
            'message' => 'Grupo salvo com sucesso!',
            'data' => $this->mapGroup($group),
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

        if ($request->papers) {
            foreach ($request->papers as $i => $paper) {
                if ($request->hasFile("papers.$i.file")) {
                    $clearTitle = preg_replace('/\.pdf$/i', '', ($paper['title'] ?? ''));

                    $request->merge([
                        "papers.$i.title" => $clearTitle,
                    ]);
                }
            }
        }

        $currentYear = date('Y');
        //Log::info($request->all());
        $request->validate([
            'theme' => "required|string|max:255|unique:groups,theme,{$id},id",
            'members' => 'required|array|min:1',
            'members.*' => 'required|string|exists:students,ra',
            'papers' => 'nullable|array|min:1|max:12',
            'papers.*.title' => [
                'required_with:papers',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $id) {
                    // Extrai índice do array
                    preg_match('/papers\.(\d+)\.title/', $attribute, $matches);
                    $index = $matches[1] ?? null;
                    if ($index === null) return;

                    $paper = $request->papers[$index] ?? null;
                    $paperId = $paper['id'] ?? null;

                    // Verifica se já existe um paper com o mesmo título em qualquer grupo
                    $exists = Paper::where('title', $value)
                        ->when($paperId, fn($q) => $q->where('id', '!=', $paperId))
                        ->exists();

                    if ($exists) {
                        $fail("Já existe um trabalho com este título cadastrado no sistema.");
                    }

                    // Garante que não hajam trabalhos com títulos duplicados na array
                    $titles = array_map(fn($p) => $p['title'], $request->papers);
                    if (count(array_filter($titles, fn($t) => $t === $value)) > 1) {
                        $fail("Este arquivo está com título duplicado neste envio.");
                    }
                }
            ],
            'papers.*.file' => [
                // Obrigatório só se NÃO existir no banco
                function($attribute, $value, $fail) use ($request, $id) {
                    // pega o índice do paper atual
                    preg_match('/papers\.(\d+)\.file/', $attribute, $matches);
                    $index = $matches[1];

                    $paper = $request->papers[$index] ?? null;

                    if(!$paper) return;

                    // obrigatório só se não existe no banco
                    if(empty($paper['id']) || !Paper::where('id', $paper['id'])->where('group_id', $id)->exists()) {
                        if(!$value) {
                            $fail("O PDF é obrigatório para o trabalho '{$paper['title']}'");
                        }
                    }
                },
                'file',
                'mimes:pdf',
                'max:5120'
            ],
            'papers.*.year' => "required_with:papers|integer|digits:4|between:" . 2024 . "," . ($currentYear),
            'papers.*.semester' => 'required_with:papers|integer|in:1,2',
            'papers.*.version' => 'required_with:papers|string|in:evaluation,corrected',
            'papers.*.course' => 'required_with:papers|integer|exists:courses,id',
            'papers.*.project' => 'required_with:papers|integer|between:1,6',
        ]);

        // Busca o grupo existente
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'message' => 'Grupo não encontrado!'
            ], 403);
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

        DB::transaction(function () use ($request, $group, $paperService) {
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

            // Atualiza o group_id dos alunos selecionados
            $added = Student::whereIn('ra', $request->members)
                ->where(function ($q) use ($group) {
                    $q->whereNull('group_id')
                        ->orWhere('group_id', '<>', $group->id);
                })
                ->update(['group_id' => $group->id]);

            if($request->papers) {
                // Identifica papers enviados no request (IDs existentes ou titles novos)
                $sentPapers = array_filter(array_map(fn($p) => $p['id'] ?? null, $request->papers));

                $papersToInactivate = Paper::where('group_id', $group->id)
                    ->where('state', 1)
                    ->whereNotIn('id', $sentPapers)
                    ->get();

                foreach ($papersToInactivate as $paper) {
                    $paper->update([
                        'state' => 0
                    ]);
                }

                if($papersToInactivate->count() > 0 || $added > 0 || $removed > 0) {
                    $group->touch();
                }

                // Se tem arquivo novo, salva
                foreach ($request->papers as $i => $paper) {
                    if ($request->hasFile("papers.$i.file")) {
                        $folders = $this->prepareFolders($paper);

                        $paperService->createPaper($request->file("papers.$i.file"), $group->id, $folders, $paper['title']);

                        $group->touch();
                    } else {
                        $paperToUpdate = Paper::find($paper['id']);
                        // Validações extras
                        if($paperToUpdate->version != $paper['version']) {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                "papers.$i.version" => ['Não é permitido alterar a versão de um trabalho por este formulário. Use a aba "Trabalhos".']
                            ]);
                        }
                        $paperToUpdate->fill([
                            'title' => $paper['title'],
                            'year' => $paper['year'],
                            'semester' => $paper['semester'],
                            'project' => $paper['project'],
                            'version' => $paper['version'],
                            'course_id' => $paper['course'],
                        ]);
                        if($paperToUpdate->submitted_at && $paperToUpdate->isDirty()) {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                "papers.$i.file" => ['Este trabalho já foi submetido à banca.
                Apenas a associação com a versão corrigida pode ser modificada.']
                            ]);
                        }

                        if (!$paperToUpdate || $paperToUpdate->group_id != $group->id || $paperToUpdate->group_id == null) {
                            // Paper não existe ou está inativo
                            Log::warning("Paper ID {$paper['id']} inválido ou removido");
                            continue;
                        }
                        // Só processa de ativo
                        if($paperToUpdate->state === 1) {
                            $paperTitle = $paperToUpdate->title;

                            if($paperTitle !== $paper['title']) {
                                $paperTitle = $paper['title'];
                                $group->touch();
                            }

                            $folders = $this->prepareFolders($paper);
                            $paperService->updatePaper($paperToUpdate, $group, $folders, $paperTitle);
                        }
                    }
                }
            } else if (empty($request->papers)) {
                Paper::where('group_id', $group->id)
                    ->where('state', 1)
                    ->update(['state' => 0]);

                $group->touch();
            }
        });

        // Recarrega completamente grupo + alunos + papers
        $group = Group::with(['papers', 'students.user'])->find($id);

        return response()->json([
            'success' => true,
            'message' => 'Grupo atualizado com sucesso!',
            'data' => $this->mapGroup($group),
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

    /**
     * @param Request $request
     * @return void
     */
    private function extractPapersTitle(Request $request): void
    {
        if ($request->papers) {
            foreach ($request->papers as $i => $paper) {
                if ($request->hasFile("papers.$i.file")) {
                    $originalName = pathinfo(
                        $request->file("papers.$i.file")->getClientOriginalName(),
                        PATHINFO_FILENAME
                    );

                    $request->merge([
                        "papers.$i.title" => $originalName,
                    ]);
                }
            }
        }
    }

    /**
     * @throws Exception
     */
    private function prepareFolders(array $paper): array
    {
        $course = Course::find($paper['course']);
        if(!$course) {
            throw new Exception("Curso não encontrado para o ID $paper[course]");
        }
        $folders = [
            'year' => $paper['year'],
            'semester' => $paper['semester'],
            'version' => $paper['version'],
            'course_id' => $course->id,
            'course_name' => $course->name,
            'project' => $paper['project'],
        ];

        return array_map(fn($q) => StringResolve::normalizeFolderName($q), $folders);
    }

    private function mapGroup($group): array
    {
        return [
            'id' => $group->id,
            'theme' => $group->theme,
            'state' => (int) $group->state,
            'papers' => $group->papers->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->title ?? 'Sem título',
                'file_path' => $p->state ? $p->file_path : null,
                'year' => $p->year ?? null,
                'semester' => $p->semester ?? null,
                'version' => $p->version ?? null,
                'course' => $p->course_id ?? null,
                'project' => $p->project ?? null,
                'state' => (int) $p->state,
            ]),
            'students' => $group->students->map(fn($s) => [
                'ra' => $s->ra,
                'name' => $s->user->name,
            ]),
            'created_at' => $group->created_at,
            'updated_at' =>  $group->updated_at,
        ];
    }
}
