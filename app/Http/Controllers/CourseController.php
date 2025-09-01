<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

use App\Models\Course;
use App\Models\Coordinator;

// Log
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Random\RandomException;

class CourseController extends Controller
{
    /**
     * @throws RandomException
     */
    public function index(): View
    {
        //if (!session()->has('custom_token')) {}
        session(['dynamic_token' => bin2hex(random_bytes(16))]);

        $coordinators = Coordinator::with('user:id,name')
            ->whereHas('user', function ($q) {
                $q->where('state', 1);
            })
            ->orderBy(
                User::select('name')
                    ->whereColumn('users.id', 'coordinators.user_id')
            )
            ->get();

        $data = $coordinators->map(function ($coordinator) {
            return [
                'id' => $coordinator->id,
                'name' => $coordinator->user->name,
            ];
        });

        $courses = Course::with('coordinator.user:id,name,state')->orderBy('id')->paginate(10);

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

        return view('management.courses', [
            'courses' => $coursesData,
            'coordinators' => $data,
            'current_page' => $courses->currentPage(),
            'last_page' => $courses->lastPage(),
        ]);
    }

    public function show (Request $request): jsonResponse
    {
        //DB::enableQueryLog();
        $coordinators = Coordinator::with('user:id,name')
            ->whereHas('user', function ($q) {
                $q->where('state', 1);
            })
            ->orderBy(
                User::select('name')
                    ->whereColumn('users.id', 'coordinators.user_id')
            )
            ->get();

        $data = $coordinators->map(function ($coordinator) {
            return [
                'id' => $coordinator->id,
                'name' => $coordinator->user->name,
            ];
        });

        $query = Course::with('coordinator.user:id,name,state')->orderBy('id');

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('coordinator.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
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

        $courses = $query->paginate(10);
        //Log::info('Queries executadas:', DB::getQueryLog());
        //$queries = DB::getQueryLog();
        //dd($queries);

        // Mapeia para retornar somente os campos necessários
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

        return response()->json([
            'data' => $coursesData,
            'coordinators' => $data,
            'current_page' => $courses->currentPage(),
            'last_page' => $courses->lastPage(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        //$start = microtime(true);
        $request->validate([
            'name' => 'required|string|max:255|unique:courses',
            'shift' => 'required|in:morning,afternoon,night',
            'coordinator_id' => 'nullable|integer|unique:courses|exists:coordinators,id',
        ]);

        $request['state'] = 1;

        $course = Course::create([
            'name' => $request['name'],
            'shift' => $request['shift'],
            'coordinator_id' => $request['coordinator_id'],
            'state' => $request['state'],
        ]);
        //$end = microtime(true);
        //Log::info('Tempo criação user direto + professor: ' . ($end - $start) . ' segundos');
        $course->load('coordinator.user:id,name');

        return response()->json([
            'success' => true,
            'message' => 'Curso salvo com sucesso!',
            'data' => [
                'id' => $course->id,
                'name' => $course->name,
                'shift' => $course->shift,
                'coordinator_id' => $course->coordinator_id ?? null,
                'coordinator_name' => $course->coordinator->user->name ?? null,
                'state' => (int) $course->state,
                'created_at' => $course->created_at,
                'updated_at' => $course->updated_at,
            ],
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => "required|string|max:255|unique:courses,name,{$id},id",
            'shift' => 'required|in:morning,afternoon,night',
            'coordinator_id' => "nullable|integer|unique:courses,coordinator_id,{$id},id|exists:coordinators,id",
        ]);

        $course = Course::with('coordinator.user')->find($id);

        if(!$course) {
            return response()->json([
                'message' => 'Curso não encontrado!',
            ],422);
        }

        $course->update([
            'name' => $request['name'],
            'shift' => $request['shift'],
            'coordinator_id' => $request['coordinator_id'],
        ]);

        $course->load('coordinator.user:id,name');

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

        $course->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Curso atualizado com sucesso!',
            'state' => (int) $course->state,
            'created_at' => $course->created_at,
            'updated_at' => $course->updated_at,
        ]);
    }
}
