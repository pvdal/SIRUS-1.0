<?php

namespace App\Http\Controllers;

// Common
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Models
use App\Models\Course;
use App\Models\Group;
use App\Models\Paper;

// Transações no banco
use Illuminate\Support\Facades\DB;

// Log
use Illuminate\Support\Facades\Log;

// Static Classes and utils
use Illuminate\View\View;
use Exception;
use Random\RandomException;
use App\Utils\TokenGenerator;
use App\Services\PaperService;
use App\Utils\StringResolve;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Carbon\Carbon;

use Symfony\Component\HttpFoundation\StreamedResponse;


class PaperController extends Controller
{
    public function showPaper($filepath): Response
    {
        $path = "papers/$filepath";
        $paper = Paper::where('file_path', $path)->first();

        // Caso o paper esteja inativo e o usuário não seja um coordenador, não é possível ver o arquivo
        if (!auth()->user()->isAdmin() && $paper->state === 0) {
            abort(403);
        }

        $this->authorize('view-paper', $paper);

        if(!auth()->check()) {
            abort(403,"Acesso negado.");
        }
        // Evita acesso fora da pasta
        if (str_contains($filepath, '..')) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $filename = basename($filepath); // pega só o arquivo, sem pastas
        $displayName = preg_replace('/_[a-f0-9]{10}(\.pdf)$/', '$1', $filename);

        /*
        Log::info('Ambiente da aplicação', [
            'environment()' => app()->environment(),
            'config_env' => config('app.env'),
        ]);
        */
        if (app()->environment('local')) {
            return Storage::disk('public')->response("papers/{$filepath}", null, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $displayName . '"',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            ]);
        }

        // Retorna resposta com X-Accel-Redirect para Nginx
        return response('', 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $displayName . '"',
            'X-Accel-Redirect' => "/internal_papers/$filepath",
        ]);
    }

    /**
     * @throws RandomException
     */
    public function index(): View
    {
        // Inicializa o DynamicToken
        TokenGenerator::initializeTab();

        $papers = Paper::with([
            'group:id,theme',
            'committee',
            'committeeAsCorrected',
            'course:id,name',
        ])->orderBy('id')->paginate(30);

        $papersData = $papers->getCollection()->map(function ($paper) {
            return $this->mapPaper($paper);
        });

        $courses = Course::select(['id', 'name'])
            ->orderBy('name')
            ->get()
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                ];
            })->values();

        $groups = Group::select(['id', 'theme'])
            ->where('state', 1)
            ->orderByDesc('created_at') // ou orderBy('id', 'desc')
            ->limit(10)
            ->get();

        return view('management.papers',[
            'papers' => $papersData,
            'courses' => $courses,
            'groups' => $groups,
            'page' => $papers->currentPage(),
            'totalPages' => $papers->lastPage(),
            'totalItems' => $papers->total(),
        ]);
    }

    public function filter(Request $request): JsonResponse
    {
        //DB::enableQueryLog();
        $query = Paper::with([
            'group:id,theme',
            'committee',
            'committeeAsCorrected',
            'course:id,name',
        ])->orderBy('id');

        #region Filtros
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        if ($request->filled('group')) {
            $group = $request->input('group');
            $query->where('group_id', $group);
        }

        if ($request->filled('version')) {
            $version = $request->input('version');
            $query->where('version', $version);
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('state', $status);
        }

        if ($request->filled('period')) {
            $period = $request->input('period');
            $personalized_start_period = $request->input('personalized_start_period');
            $personalized_end_period = $request->input('personalized_end_period');

            $query->when($period === 'today', function ($q) {
                $q->whereDate('created_at', today());
            });
            $query->when($period === 'week', function ($q) {
                $q->whereBetween('created_at', [now()->subDays(7), now()]);
            });
            $query->when($period === 'month', function ($q) {
                $q->whereBetween('created_at', [now()->subDays(30), now()]);
            });

            if ($personalized_start_period && $personalized_end_period) {
                $query->when($period === 'personalized', function ($q) use ($personalized_start_period, $personalized_end_period) {
                    $q->whereBetween('created_at', [
                        Carbon::parse($personalized_start_period)->startOfDay(),
                        Carbon::parse($personalized_end_period)->endOfDay(),
                    ]);
                });
            }
        }

        if($request->filled('year')) {
            $year = $request->input('year');
            $query->where('year', $year);
        }
        #endregion

        $canPaginate = !$request->filled('year');

        if($canPaginate) {
            $papers = $query->paginate(30);

            $papersData = $papers->getCollection()->map(function ($paper) {
                return $this->mapPaper($paper);
            });

            return response()->json([
                'data' => $papersData,
                'page' => $papers->currentPage(),
                'totalPages' => $papers->lastPage(),
            ]);
        }

        $papers = $query->get();

        return response()->json([
            'data' => $papers->map(fn ($paper) => $this->mapPaper($paper)),
        ]);
    }

    public function years():JsonResponse
    {
        $years = Paper::query()
            ->select('year', DB::raw('SUM(file_size) as total_size'))
            ->groupBy('year')
            ->orderByDesc('year')
            ->get(['year', DB::raw('SUM(file_size) as total_size')]);

        return response()->json($years);
    }

    /**
     * @throws Throwable
     */
    public function store(Request $request, PaperService $paperService): JsonResponse
    {
        $currentYear = date('Y');

        $clearTitle = preg_replace('/\.pdf$/i', '', $request->title);

        $request->merge([
            'title' => $clearTitle,
        ]);

        //Log::info($request->all());
        $request->validate([
            'title' => 'required|string|max:255|unique:papers,title',
            'file' => 'required|file|mimes:pdf|max:5120',
            'year' => "required|integer|digits:4|between:" . 2024 . "," . ($currentYear),
            'semester' => 'required|integer|in:1,2',
            'version' => 'required|string|in:evaluation,corrected',
            'course_id' => 'required|integer|exists:courses,id',
            'group_id' => 'required|integer|exists:groups,id',
            'project' => 'required|integer|between:1,6',
            'evaluation_paper_id' => [
                'nullable',
                'prohibited_unless:version,corrected',
                'integer',
                Rule::exists('papers', 'id')
                    ->where('version', 'evaluation')
                    ->where('group_id', $request->group_id),
            ]
        ]);

        $evaluationPaper = null;

        if ($request->version === 'corrected') {
            $evaluationPaper = Paper::with(['committee','committeeAsCorrected'])
                ->where('id', $request->evaluation_paper_id)
                ->where('version', 'evaluation')
                ->first();

            // Já existe versão corrigida
            if ($evaluationPaper->committee?->corrected_paper_id) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'evaluation_paper_id' => ['A versão corrigida para este trabalho já foi cadastrada.'],
                ]);
            }

            // Ainda não foi avaliado
            if ($evaluationPaper->submitted_at === null) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'evaluation_paper_id' => [
                        'Este trabalho ainda não foi avaliado, não é possível salvar a versão corrigida.'
                    ],
                ]);
            }
        }

        $paper = null;

        DB::transaction(function () use ($request, &$paper, &$paperService) {
            $group = Group::find($request->group_id);

            $folders = $this->prepareFolders($request->all());

            $paper = $paperService->createPaper($request->file('file'), $group->id, $folders, $request->title);
        });

        if ($request->version === 'corrected') {
            $evaluationPaper->committee->update([
                'corrected_paper_id' => $paper->id,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Grupo salvo com sucesso!',
            'data' => $this->mapPaper($paper),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function update(Request $request, $id, PaperService $paperService): JsonResponse
    {
        if(!$id) {
            return response()->json([
                'message' => 'Selecione um trabalho!',
            ],422);
        }

        $currentYear = date('Y');

        $clearTitle = preg_replace('/\.pdf$/i', '', $request->title);
        $request->merge([
            'title' => $clearTitle,
        ]);

        //Log::info($request->all());
        $request->validate([
            'title' => "required|string|max:255|unique:papers,title,{$id},id",
            'file' => 'nullable|file|mimes:pdf|max:5120',
            'year' => "required|integer|digits:4|between:" . 2024 . "," . ($currentYear),
            'semester' => 'required|integer|in:1,2',
            'version' => 'required|string|in:evaluation,corrected',
            'course_id' => 'required|integer|exists:courses,id',
            'group_id' => 'required|integer|exists:groups,id',
            'project' => 'required|integer|between:1,6',
            'evaluation_paper_id' => [
                'nullable',
                'prohibited_unless:version,corrected',
                'integer',
                Rule::exists('papers', 'id')
                    ->where('id','!=', $id)
                    ->where('version', 'evaluation')
                    ->where('group_id', $request->group_id),
            ],
            'corrected_paper_id' => [
                'nullable',
                'prohibited_unless:version,evaluation',
                'integer',
                Rule::exists('papers', 'id')
                    ->where('id','!=', $id)
                    ->where('version', 'corrected')
                    ->where('group_id', $request->group_id),
            ]
        ]);
        // Trabalho enviado para atualizar
        $paperToUpdate = Paper::with([
            'committee',
            'committeeAsCorrected',
            ])->find($id);

        if (!$paperToUpdate) {
            return response()->json([
                'success' => false,
                'message' => 'Trabalho não encontrado!',
            ],422);
        }

        $evaluationPaper = null;
        $correctedPaper = null;

        #region Validações extras
        if ($paperToUpdate->version !== $request->version && $paperToUpdate->committee) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'version' => ['Não é possível alterar a versão de um trabalho associado a uma banca.'],
            ]);
        }

        $paperToUpdate->fill([
            'title' => $request->title,
            'year' => $request->year,
            'semester' => $request->semester,
            'project' => $request->project,
            'version' => $request->version,
            'course_id' => $request->course_id,
        ]);
        if($paperToUpdate->submitted_at && $paperToUpdate->isDirty()) {
            return response()->json([
                'success' => false,
                'message' => 'Este trabalho já foi submetido à banca.
                Apenas a associação com a versão corrigida pode ser modificada.',
            ],422);
        }

        // Validações adicionais na versão de avaliação enviada
        if ($request->version === 'corrected' && $request->evaluation_paper_id) {
            $evaluationPaper = Paper::with(['committee','committeeAsCorrected'])
                ->where('id', $request->evaluation_paper_id)
                ->where('version', 'evaluation')
                ->first();

            // Já existe versão corrigida
            if ($evaluationPaper->committee?->corrected_paper_id && $evaluationPaper->committee?->corrected_paper_id !== intval($id)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'evaluation_paper_id' => ['A versão corrigida para este trabalho já foi cadastrada.'],
                ]);
            }

            // Ainda não foi avaliado
            if ($evaluationPaper->submitted_at === null) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'evaluation_paper_id' => [
                        'Este trabalho ainda não foi avaliado, não é possível salvar a versão corrigida.'
                    ],
                ]);
            }
        }
        // Validações adicionais na versão corrigida enviada
        if ($request->version === 'evaluation' && $request->corrected_paper_id) {
            $correctedPaper = Paper::with(['committee','committeeAsCorrected'])
                ->where('id', $request->corrected_paper_id)
                ->where('version', 'corrected')
                ->first();

            if ($paperToUpdate->submitted_at === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Não é possível associar uma versão corrigida a um trabalho ainda não avaliado.',
                ],422);
            }

            // Já existe versão de avaliação
            if ($correctedPaper->committeeAsCorrected?->paper_id && $correctedPaper->committeeAsCorrected?->paper_id !== intval($id)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'corrected_paper_id' => ['A versão de avaliação para este trabalho já foi cadastrada.'],
                ]);
            }
        }
        #endregion

        $paper = null;
        $touchedPapers = collect();

        DB::transaction(function () use ($request, &$paper, $paperToUpdate, $paperService, $evaluationPaper, $correctedPaper, &$touchedPapers) {
            #region Relações entre versões
            if ($paperToUpdate->version === 'corrected') {
                $currentEvaluationId = $paperToUpdate->committeeAsCorrected?->paper_id;
                $newEvaluationId = $request->evaluation_paper_id;
                //Entra caso a versão da request seja evaluation ou a request tenha uma versão de avaliação atualizada
                if ($request->version !== 'corrected' || $currentEvaluationId !== $newEvaluationId) {
                    // Limpeza inicial caso o paper agora seja de avaliação ou haja alteração de dados.
                    // Como aqui o paper é corrected, o método committee não pode ser acessado, apenas 'committeeAsCorrected'
                    if ($paperToUpdate->committeeAsCorrected) {
                        $paperToUpdate->committeeAsCorrected->update([
                            'corrected_paper_id' => null,
                        ]);

                        $touchedPapers->push(
                            $this->mapPaper(
                                $paperToUpdate->committeeAsCorrected->paper()->first()
                            )
                        );
                    }
                    // O paper atual é corrigido e a versão da request também. Veio versão de avaliação atualizada
                    // O id do trabalho atual 'corrected', é atribuído ao paper versão avaliação que veio na request
                    if ($request->version === 'corrected' && $newEvaluationId) {
                        $evaluationPaper->committee->update([
                            'corrected_paper_id' => $paperToUpdate->id,
                        ]);

                        $touchedPapers->push(
                            $this->mapPaper($evaluationPaper)
                        );
                    }
                }
            }

            // O trabalho atual está associado a uma banca e a request veio de avaliação também
            if ($paperToUpdate->committee && $request->version === 'evaluation') {
                // Pega o paper antigo, se houver
                $oldCorrectedPaper = $paperToUpdate->committee->correctedPaper ?? null;

                // Apenas atualiza a versão corrigida do trabalho atual
                $paperToUpdate->committee->update([
                    'corrected_paper_id' => $request->corrected_paper_id
                        ? $correctedPaper->id
                        : null,
                ]);

                $paperToUpdate->refresh();

                $newCorrectedPaper = $paperToUpdate->committee->correctedPaper;

                if ($oldCorrectedPaper &&
                    (
                        ! $newCorrectedPaper ||
                        $oldCorrectedPaper->id !== $newCorrectedPaper->id
                    )
                ) {
                    $touchedPapers->push(
                        $this->mapPaper($oldCorrectedPaper)
                    );
                }


                if ($newCorrectedPaper) {
                    $touchedPapers->push(
                        $this->mapPaper($newCorrectedPaper)
                    );
                }
            }

            // O paper atual é avaliação e a request veio corrigido. Só chega aqui se não há banca associada
            if ($paperToUpdate->version === 'evaluation' && $request->version === 'corrected') {
                if ($request->evaluation_paper_id) {
                    // Acessa evalationPaper caso tenha vindo id na request. O paper atual agora é corrigido, então
                    // seu próprio id deve ir no corrected_paper_id
                    $evaluationPaper->committee->update([
                        'corrected_paper_id' => $paperToUpdate->id
                    ]);
                    $touchedPapers->push(
                        $this->mapPaper($evaluationPaper)
                    );
                }
            }
            #endregion

            // Atualiza os campos do Paper
            $group = Group::find($request->group_id);

            $folders = $this->prepareFolders($request->all());

            $paper = $paperService->updatePaper($paperToUpdate, $group, $folders, $request->title,$request->hasFile('file') ? $request->file('file') : null);
            $paper->fill([
                'group_id' => $group->id,
            ]);
            if ($paper->isDirty()) {
                $paper->save();
                $group->touch();
            }
        });
        $paper->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Grupo salvo com sucesso!',
            'updated' => $this->mapPaper($paper),
            'touched' => $touchedPapers->unique('id')->values(),

        ]);
    }

    public function toggleStatus($id,$action)
    {
        $paper = Paper::find($id);

        if (!$paper) {
            return response()->json([
                'message' => 'Trabalho não encontrado!',
            ],422);
        }

        if ($action === 'inactivate') {
            $paper->update(['state' => 0]);
        } elseif ($action === 'activate') {
            $paper->update(['state' => 1]);
        }  else {
            return response()->json([
                'message' => 'Ação inválida!'
            ], 422);
        }

        $paper->touch();

        return response()->json([
            'success' => true,
            'message' => 'Trabalho atualizado com sucesso!',
            'state' => (int) $paper->state,
            'created_at' => $paper->created_at,
            'updated_at' => $paper->updated_at,
        ]);
    }

    /**
     * @throws Exception
     */
    private function prepareFolders(array $paper): array
    {
        $course = Course::find($paper['course_id']);
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

    private function mapPaper($paper): array
    {
        $committee = $paper->committee ?? $paper->committeeAsCorrected;

        return [
            'id' => $paper->id,
            'title' => $paper->title,
            'group_id' => $paper->group_id,
            'group_theme' => $paper->group->theme,
            'file_path' => $paper->file_path,
            'file_size' => $paper->file_size,
            'year' => $paper->year,
            'semester' => $paper->semester,
            'version' => $paper->version,
            'course_id' => $paper->course_id,
            'course_name' => $paper->course->name,
            'project' => $paper->project,
            'submitted_at' => $paper?->submitted_at?->format('d/m/Y \à\s H:i'),
            'state' => $paper->state,
            'created_at' => $paper->created_at,
            'updated_at' => $paper->updated_at,
            'hasSchedule' => $paper->committee !== null && $paper->version === 'evaluation',
            'scheduleDate' => $paper->committee ? [
                'start' => $paper->committee->start?->format('d/m/Y\, H:i'),
                'end' => $paper->committee->end?->format('d/m/Y\, H:i'),
            ] : null,
            'evaluation_paper_id' => $committee->paper_id ?? null,
            'corrected_paper_id' => $committee->corrected_paper_id ?? null,
        ];
    }

    public function download(int $year, int $semester, PaperService $service)
    {
        return response()->streamDownload(
            fn () => $service->streamYearZip($year,$semester),
            "trabalhos_{$year}_0{$semester}.zip"
        );
    }
}
