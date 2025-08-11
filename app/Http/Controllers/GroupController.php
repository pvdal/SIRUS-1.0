<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

use App\Models\Group;
use App\Models\Student;
use Random\RandomException;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Illuminate\Support\Facades\Log;

class GroupController extends Controller
{
    /**
     * @throws RandomException
     */
    public function index(Request $request): View
    {
        //if (!session()->has('custom_token')) {}
        session(['dynamic_token' => bin2hex(random_bytes(24))]);

        $groups = Group::with([
            'papers',
            'students' => function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('state', 1);
                })
                ->with(['user:id,name,state']);
            }
        ])->paginate(12);

        // Mapeia os dados manualmente
        $groupsData = $groups->getCollection()->map(function ($group) {
            return [
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
                    'name' => mb_strtoupper($s->user->name),
                ]),
            ];
        })->values();

        return view('management.groups', [
            'groups' => $groupsData,
            'current_page' => $groups->currentPage(),
            'last_page' => $groups->lastPage(),
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $q = $request->query('q', '');

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
            ->limit(10)
            ->get();

        $students->load('group:id,theme');

        return response()->json(
            $students->map(function ($student) {
                return [
                    'ra' => $student->ra,
                    'name' => $student->user->name ?? '(sem nome)',
                    'group' => $student->group->theme ?? null,
                ];
            })
        );
    }

    public function showPaper($filename): StreamedResponse
    {
        // Evita acesso fora da pasta
        if (str_contains($filename, '..')) {
            abort(403);
        }

        if (!Storage::disk('public')->exists("papers/{$filename}")) {
            abort(404);
        }

        return Storage::disk('public')->response("papers/{$filename}", null, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    public function show(Request $request): JsonResponse
    {
        //DB::enableQueryLog();
        $query = Group::with([
            'papers',
            'students' => function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('state', 1);
                })
                ->with(['user:id,name,state']);
            }
        ]);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('theme', 'like', "%{$search}%")
                    ->orWhereHas('students.user', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
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

        $groups = $query->paginate(12);
        //Log::info('Queries executadas:', DB::getQueryLog());

        // Mapeia para retornar somente os campos necessários
        $groupsData = $groups->getCollection()->map(function ($group) {
            return [
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
                    'name' => mb_strtoupper($s->user->name),
                ]),
            ];
        })->values();

        return response()->json([
            'data' => $groupsData,
            'current_page' => $groups->currentPage(),
            'last_page' => $groups->lastPage(),
        ]);
    }

    public function store(Request $request): JsonResponse
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

        if ($alunosEmOutroGrupo) {
            Log::warning('Aluno(s) já pertence(m) a outro grupo', [
                'members' => $request->members,
            ]);

            return response()->json([
                'success' => false,
                'errors' => [
                    'members' => ['Um ou mais alunos já pertencem a outro grupo.'],
                ],
            ], 422);
        }

        $group = null;

        DB::transaction(function () use ($request, &$group) {
            $group = Group::create([
                'theme' => $request->theme,
                'state' => 1,
            ]);

            Student::whereIn('ra', $request->members)
                ->update(['group_id' => $group->id]);

            if ($request->hasFile('file')) {
                $uploadedFile = $request->file('file');
                Log::debug('Arquivo recebido:', [
                    'originalName' => $uploadedFile->getClientOriginalName(),
                    'size' => $uploadedFile->getSize(),
                    'mimeType' => $uploadedFile->getMimeType(),
                ]);
                $filePath = $uploadedFile->store('papers', 'public');
                $title = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

                Paper::create([
                    'title' => $title,
                    'file_path' => $filePath,
                    'group_id' => $group->id,
                ]);
            }
        });

        $group->load(['papers', 'students']);

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
                    'name' => mb_strtoupper($s->user->name),
                ])
            ]
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        if(!$id) {
            return response()->json([
                'message' => 'Selecione um grupo!',
            ],422);
        }

        $request->validate([
            'theme' => "required|string|max:255|unique:groups,theme,{$id},id",
            'file' => 'nullable|file|mimes:pdf|max:5120',
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

        DB::transaction(function () use ($request, $group) {
            // Atualiza o tema
            $group->theme = $request->theme;
            $group->save();

            // Remove o group_id dos alunos que não estão mais no grupo
            Student::where('group_id', $group->id)
                ->whereNotIn('ra', $request->members)
                ->update(['group_id' => null]);

            // Atualiza o group_id dos alunos selecionados
            Student::whereIn('ra', $request->members)
                ->update(['group_id' => $group->id]);

            // Se tem arquivo novo, salva e cria novo Paper, removendo antigo
            if ($request->hasFile('file')) {
                $uploadedFile = $request->file('file');
                /*Log::debug('Arquivo recebido:', [
                    'originalName' => $uploadedFile->getClientOriginalName(),
                    'size' => $uploadedFile->getSize(),
                    'mimeType' => $uploadedFile->getMimeType(),
                ]);*/
                $filePath = $uploadedFile->store('papers', 'public');
                $title = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

                // Remove papers antigos e apaga o arquivo também)
                $oldPapers =  $group->papers;
                foreach ($oldPapers as $oldPaper) {
                    Storage::disk('public')->delete($oldPaper->file_path);
                }

                $group->papers()->delete();

                Paper::create([
                    'title' => $title,
                    'file_path' => $filePath,
                    'group_id' => $group->id,
                ]);
            }
        });

        $group->load(['papers', 'students.user']);

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
                    'name' => mb_strtoupper($s->user->name),
                ]),
            ]
        ]);
    }

    public function inactivate($id): JsonResponse
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'message' => 'Grupo não encontrado!'
            ], 422);
        }

        $group->update(['state' => 0]);

        $group->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Grupo inativado com sucesso!'
        ]);
    }

    public function activate($id): JsonResponse
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'message' => 'Grupo não encontrado!'
            ], 422);
        }

        $group->update(['state' => 1]);

        $group->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Grupo ativado com sucesso!'
        ]);
    }
}
