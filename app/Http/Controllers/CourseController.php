<?php

namespace App\Http\Controllers;

// Common
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// Models
use App\Models\User;
use App\Models\Course;
use App\Models\Coordinator;

// Transações no banco
use Illuminate\Support\Facades\DB;

// Log
//use Illuminate\Support\Facades\Log;

// Static Classes and utils
use Random\RandomException;
use App\Utils\TokenGenerator;

class CourseController extends Controller
{
    /**
     * @throws RandomException
     */
    // Exibição inicial de cursos sem aplicação de filtros ou troca de página (‘READ’)
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        // Inicializa o DynamicToken
        TokenGenerator::initializeTab();
        // Faz uma query no banco trazendo 15 registros paginados
        $courses = Course::with(
            'coordinator.user:id,name,state'
        )->orderBy('id')->paginate(30);
        // Pega a coleção paginada que retornou da query acima e mapeia com chaves amigáveis
        $coursesData = $courses->getCollection()->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'shift' => $course->shift,
                'coordinator_id' => $course->coordinator_id ?? null,
                'coordinator_name' => $course->coordinator->user->name ?? null,
                'coordinator_state' => (int) ($course->coordinator->user->state ?? 0),
                'state' => (int) $course->state,
                'created_at' => $course->created_at,
                'updated_at' => $course->updated_at,
            ];
        })->values();

        #region Dados auxiliares
        $coordinators = Coordinator::query()
            ->join('users', 'users.id', '=', 'coordinators.user_id')
            ->where('users.state', 1)
            ->select('coordinators.id', 'coordinators.user_id', 'users.name')
            ->orderBy('users.name')
            ->limit(50)
            ->get();
        #endregion

        // Retorna os dados na view de gerenciamento de cursos
        return view('management.courses', [
            'courses' => $coursesData,
            'coordinators' => $coordinators->map(function ($coordinator) {
                return [
                    'id' => $coordinator->id,
                    'name' => $coordinator->user->name,
                ];
            }),
            'page' => $courses->currentPage(),
            'totalPages' => $courses->lastPage(),
        ]);
    }

    // Exibição de cursos com aplicação de filtros ou troca de página (‘READ’)
    public function show (Request $request): jsonResponse
    {
        //DB::enableQueryLog();
        $query = Course::with('coordinator.user:id,name,state')->orderBy('id');

        #region Filtros
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('coordinator.user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if($request->filled('status')) {
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

        $courses = $query->paginate(30);

        $coordinators = Coordinator::query()
            ->join('users', 'users.id', '=', 'coordinators.user_id')
            ->where('users.state', 1)
            ->select('coordinators.id', 'coordinators.user_id', 'users.name')
            ->orderBy('users.name')
            ->limit(50)
            ->get();

        $data = $coordinators->map(function ($coordinator) {
            return [
                'id' => $coordinator->id,
                'name' => $coordinator->user->name,
            ];
        });
        //Log::info('Queries executadas:', DB::getQueryLog());
        //$queries = DB::getQueryLog();

        // Mapeia para retornar somente os campos necessários
        $coursesData = $courses->getCollection()->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'shift' => $course->shift,
                'coordinator_id' => $course->coordinator_id ?? null,
                'coordinator_name' => $course->coordinator->user->name ?? null,
                'coordinator_state' => ($course->coordinator->user->state ?? 0),
                'state' => ($course->state ?? 0),
                'created_at' => $course->created_at,
                'updated_at' => $course->updated_at,
            ];
        })->values();

        return response()->json([
            'data' => $coursesData,
            'coordinators' => $data,
            'page' => $courses->currentPage(),
            'totalPages' => $courses->lastPage(),
        ]);
    }

    // Cadastro de cursos (‘CREATE’)
    public function store(Request $request): JsonResponse
    {
        //$start = microtime(true);
        $request->validate([
            'name' => 'required|string|max:255|unique:courses',
            'shift' => 'required|in:morning,afternoon,night',
            'coordinator_id' => 'nullable|integer|unique:courses|exists:coordinators,id',
        ]);

        $course = Course::create([
            'name' => $request['name'],
            'shift' => $request['shift'],
            'coordinator_id' => $request['coordinator_id'],
            'state' => 1,
        ]);
        //$end = microtime(true);
        //Log::info('Tempo criação user direto + professor: ' . ($end - $start) . ' segundos');
        $course->load('coordinator.user:id,name,state');

        return response()->json([
            'success' => true,
            'message' => 'Curso salvo com sucesso!',
            'data' => [
                'id' => $course->id,
                'name' => $course->name,
                'shift' => $course->shift,
                'coordinator_id' => $course->coordinator_id ?? null,
                'coordinator_name' => $course->coordinator->user->name ?? null,
                'state' => ($course->state ?? 0),
                'created_at' => $course->created_at,
                'updated_at' => $course->updated_at,
            ],
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        if(!$id) {
            return response()->json([
                'message' => 'Selecione um Curso!',
            ],422);
        }

        $request->validate([
            'name' => "required|string|max:255|unique:courses,name,{$id},id",
            'shift' => 'required|in:morning,afternoon,night',
            'coordinator_id' => "nullable|integer|unique:courses,coordinator_id,{$id},id|exists:coordinators,id",
        ]);

        $course = Course::with('coordinator.user:id,name')->find($id);

        if(!$course) {
            return response()->json([
                'message' => 'Curso não encontrado!',
            ],422);
        }

        $course->fill([
            'name' => $request['name'],
            'shift' => $request['shift'],
            'coordinator_id' => $request['coordinator_id'],
        ]);

        if($course->isDirty()) {
            $course->save();
        }

        $course->load('coordinator.user:id,name,state');

        return response()->json([
            'success' => true,
            'message' => 'Curso atualizado com sucesso!',
            'data' => [
                'id' => $course->id,
                'name' => $course->name,
                'shift' => $course->shift,
                'coordinator_id' => $course->coordinator_id ?? null,
                'coordinator_name' => $course->coordinator->user->name ?? null,
                'state' => (int) $course->state,
                'created_at' => $course->created_at,
                'updated_at' => $course->updated_at,
            ]
        ]);
    }

    public function toggleStatus($id,$action): JsonResponse
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
                'message' => 'Curso não encontrado!',
            ],422);
        }

        if ($action === 'inactivate') {
            $course->update(['state' => 0]);
        } elseif ($action === 'activate') {
            $course->update(['state' => 1]);
        }  else {
            return response()->json([
                'message' => 'Ação inválida!'
            ], 422);
        }

        $course->touch();

        return response()->json([
            'success' => true,
            'message' => 'Curso atualizado com sucesso!',
            'state' => (int) $course->state,
            'created_at' => $course->created_at,
            'updated_at' => $course->updated_at,
        ]);
    }
}
