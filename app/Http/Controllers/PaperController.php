<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Course;
use App\Models\Group;
use App\Models\Paper;
use App\Models\Student;
use App\Services\PaperService;
use App\Utils\StringResolve;
use App\Utils\TokenGenerator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Random\RandomException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaperController extends Controller
{
    public function showPaper($filepath): \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
    {
        $path = "papers/$filepath";
        $paper = Paper::where('file_path', $path)->first();

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
            'committee:id,name',
            'course:id,name',
        ])->orderBy('id')->paginate(30);

        $papersData = $papers->getCollection()->map(function ($papers) {
            $committee = Committee::where('paper_id',$papers->id)
                ->whereNotNull('start')
                ->whereNotNull('end')
                ->first();

            return [
                'id' => $papers->id,
                'title' => $papers->title,
                'group_id' => $papers->group_id,
                'group_theme' => $papers->group->theme,
                'file_path' => $papers->file_path,
                'year' => $papers->year,
                'semester' => $papers->semester,
                'version' => $papers->version,
                'course_id' => $papers->course_id,
                'course_name' => $papers->course->name,
                'project' => $papers->project,
                'submitted_at' => $papers?->submitted_at?->format('d/m/Y \à\s H:i'),
                'state' => $papers->state,
                'created_at' => $papers->created_at,
                'updated_at' => $papers->updated_at,
                'hasSchedule' => $committee !== null,
                'scheduleDate' => $committee ? [
                    'start' => $committee->start?->format('d/m/Y\, H:i'),
                    'end' => $committee->end?->format('d/m/Y\, H:i'),
                ] : null,
            ];
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
            ->orderBy('theme')
            ->get()
            ->map(function ($group) {
                return [
                    'id' => $group->id,
                    'theme' => $group->theme,
                ];
            });

        return view('management.papers',[
            'papers' => $papersData,
            'courses' => $courses,
            'groups' => $groups,
            'page' => $papers->currentPage(),
            'totalPages' => $papers->lastPage(),
            'totalItems' => $papers->total(),
        ]);
    }

    public function show(Request $request)
    {

    }

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
            'year' => "required|integer|digits:4|between:" . ($currentYear - 1) . "," . ($currentYear),
            'semester' => 'required|integer|in:1,2',
            'version' => 'required|string|in:evaluation,corrected',
            'course_id' => 'required|integer|exists:courses,id',
            'group_id' => 'required|integer|exists:groups,id',
            'project' => 'required|integer|between:1,6',
        ]);

        $paper = null;

        DB::transaction(function () use ($request, &$paper, &$paperService) {
            $group = Group::find($request->group_id);

            $folders = $this->prepareFolders($request->all());

            $paper = $paperService->createPaper($request->file('file'), $group->id, $folders, $request->title);
        });

        return response()->json([
            'success' => true,
            'message' => 'Grupo salvo com sucesso!',
            'data' => $this->mapPaper($paper),
        ]);
    }

    private function mapPaper($paper): array
    {
        $committee = Committee::where('paper_id',$paper->id)
            ->whereNotNull('start')
            ->whereNotNull('end')
            ->first();

        return [
            'id' => $paper->id,
            'title' => $paper->title,
            'group_id' => $paper->group_id,
            'group_theme' => $paper->group->theme,
            'file_path' => $paper->file_path,
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
            'hasSchedule' => $committee !== null,
            'scheduleDate' => $committee ? [
                'start' => $committee->start?->format('d/m/Y\, H:i'),
                'end' => $committee->end?->format('d/m/Y\, H:i'),
            ] : null,
        ];
    }

    public function update(Request $request, $id)
    {

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
}
