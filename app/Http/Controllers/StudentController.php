<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Course;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Random\RandomException;

// Log

class StudentController extends Controller
{
    /**
     * @throws RandomException
     */
    public function index(): View
    {
        //if (!session()->has('custom_token')) {}
        session(['dynamic_token' => bin2hex(random_bytes(16))]);

        $students = Student::with(
            'user:id,name,email,state,updated_at,created_at',
            'group:id,theme,state',
            'course:id,name,state',
        )->orderBy('ra','asc')->paginate(10);

        $groups = Group::select('id', 'theme')->where('state', 1)->orderBy('theme', 'asc')->get();
        $courses = Course::select('id', 'name')->where('state', 1)->orderBy('name', 'asc')->get();

        $studentsData = $students->getCollection()->map(function ($student) {
            $user = $student->user;

            $updated_at = $student->updated_at;

            if ($user && $user->updated_at) {
                $updated_at = $user->updated_at->gt($student->updated_at)
                    ? $user->updated_at
                    : $student->updated_at;
            }

            return [
                'ra' => $student->ra,
                'user_id' => $student->user_id,
                'name' => $student->user->name,
                'email' => $student->user->email,
                //'semester' => $student->semester,
                'group_id' => $student->group->id ?? null,
                'group_name' => $student->group->theme ?? null,
                'group_state' => (int) ($student->group->state ?? 0),
                'course_id' => $student->course->id ?? null,
                'course_name' => $student->course->name ?? null,
                'course_state' => (int) ($student->course->state ?? 0),
                'state' => (int) $student->user->state,
                'created_at' => $student->user->created_at, // data de criação do user
                'updated_at' => $updated_at, // pega o mais recente
            ];
        })->values();

        return view('management.students', [
            'students' => $studentsData,
            'groups' => $groups,
            'courses' => $courses,
            'current_page' => $students->currentPage(),
            'last_page' => $students->lastPage(),
        ]);
    }

    public function show(Request $request): JsonResponse
    {
        //DB::enableQueryLog();
        $query = Student::with(
            'user:id,name,email,state,updated_at,created_at',
            'group:id,theme,state',
            'course:id,name,state',
        )->orderBy('ra', 'asc');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhere('ra', 'like', "%{$search}%");

        }

        if ($request->filled('course')) {
            $course = $request->input('course');
            $query->where('course_id', $course);
        }

        if ($request->filled('group')) {
            $group = $request->input('group');
            $query->where('group_id', $group);
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->whereHas('user', function ($q) use ($status) {
                $q->where('state', $status);
            });
        }

        if ($request->filled('period')) {
            $period = $request->input('period');
            $query->whereHas('user', function ($q) use ($period) {
                $q->when($period === 'today', fn($q) => $q->whereDate('created_at', today()))
                  ->when($period === 'week', fn($q) => $q->whereBetween('created_at', [now()->subDays(7), now()]))
                  ->when($period === 'month', fn($q) => $q->whereBetween('created_at', [now()->subDays(30), now()]));
            });
        }

        $students = $query->paginate(10);
        $groups = Group::select('id', 'theme')->where('state', 1)->orderBy('theme', 'asc')->get();
        $courses = Course::select('id', 'name')->where('state', 1)->orderBy('name', 'asc')->get();
        //Log::info('Queries executadas:', DB::getQueryLog());

        $studentsData = $students->getCollection()->map(function ($student) {
            $user = $student->user;

            $updated_at = $student->updated_at;

            if ($user && $user->updated_at) {
                $updated_at = $user->updated_at->gt($student->updated_at)
                    ? $user->updated_at
                    : $student->updated_at;
            }

            return [
                'ra' => $student->ra,
                'user_id' => $student->user_id,
                'name' => $student->user->name,
                'email' => $student->user->email,
                //'semester' => $student->semester,
                'group_id' => $student->group->id ?? null,
                'group_name' => $student->group->theme ?? null,
                'group_state' => (int) ($student->group->state ?? 0),
                'course_id' => $student->course->id ?? null,
                'course_name' => $student->course->name ?? null,
                'course_state' => (int) ($student->course->state ?? 0),
                'state' => (int) $student->user->state,
                'created_at' => $student->created_at,
                'updated_at' => $updated_at,
            ];
        })->values();

        return response()->json([
            'data' => $studentsData,
            'groups' => $groups,
            'courses' => $courses,
            'current_page' => $students->currentPage(),
            'last_page' => $students->lastPage(),
        ]);
    }

    public function store(Request $request, CreateNewUser $creator): JsonResponse
    {
        Log::info('Dados recebidos no store', $request->all());
        //$start = microtime(true);
        $validated = $request->validate([
            'ra' => 'required|string|digits:13|unique:students,ra',
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
            //'semester' => 'nullable|integer|min:1|max:10',
            'group_id' => 'nullable|exists:groups,id',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $user = $creator->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => 'Aluno@2025',
            'password_confirmation' => 'Aluno@2025',
            'access_level' => 1, // 1 = Student
            'state' => 1,
        ]);

        $student = Student::create([
            'ra' => $validated['ra'],
            //'semester' => $validated['semester'],
            'group_id' => $validated['group_id'],
            'course_id' => $validated['course_id'],
            'user_id' => $user->id,
        ]);
        //$end = microtime(true);
        //Log::info('Tempo criação user direto + professor: ' . ($end - $start) . ' segundos');

        $student->load('group:id,theme', 'course:id,name');

        return response()->json([
            'success' => true,
            'message' => 'Aluno cadastrado com sucesso.',
            'data' => [
                'ra' => $student->ra,
                'user_id' => $student->user_id,
                'name' => $user->name,
                'email' => $user->email,
                //'semester' => $student->semester,
                'group_id' => $student->group->id ?? null,
                'group_name' => $student->group->theme ?? null,
                'course_id' => $student->course->id ?? null,
                'course_name' => $student->course->name ?? null,
                'state' => (int) $user->state,
                'created_at' => $student->created_at,
                'updated_at' => $student->updated_at,
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
            'name' => 'required|string|max:255',
            'email' => "required|email:rfc,dns|unique:users,email,{$id},id",
            //'semester' => 'required|integer|min:1|max:10',
            'group_id' => 'nullable|exists:groups,id',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $student = Student::with('user:id,name,email,state,updated_at,created_at')->where('user_id', $id)->first();

        if (!$student || !$student->user) {
            return response()->json([
                'message' => 'Aluno não encontrado!',
            ], 422);
        }

        $student->user->update([
            'name' => $request['name'],
            'email' => $request['email'],
        ]);

        $student->update([
            //'semester' => $request['semester'],
            'group_id' => $request['group_id'],
            'course_id' => $request['course_id'],
        ]);

        $student->load('group:id,theme', 'course:id,name');

        $user = $student->user;

        $updated_at = $student->updated_at;

        if ($user && $user->updated_at) {
            $updated_at = $user->updated_at->gt($student->updated_at)
                ? $user->updated_at
                : $student->updated_at;
        }

        return response()->json([
            'success' => true,
            'message' => 'Aluno atualizado com sucesso!',
            'data' => [
                'ra' => $student->ra,
                'user_id' => $student->user_id,
                'name' => $student->user->name,
                'email' => $student->user->email,
                //'semester' => $student->semester,
                'group_id' => $student->group->id ?? null,
                'group_name' => $student->group->theme ?? null,
                'course_id' => $student->course->id ?? null,
                'course_name' => $student->course->name ?? null,
                'state' => (int) $student->user->state,
                'created_at' => $student->created_at,
                'updated_at' => $updated_at, // pega o mais recente
            ]
        ]);
    }

    public function toggleStatus($id,$action): JsonResponse
    {
        $student = Student::with('user:id,name,email,state')->where('user_id', $id)->first();

        if (!$student || !$student->user) {
            return response()->json([
                'message' => 'Aluno não encontrado!',
            ], 422);
        }

        if ($action === 'inactivate') {
            $student->user->update(['state' => 0]);
        } elseif ($action === 'activate') {
            $student->user->update(['state' => 1]);
        }  else {
            return response()->json([
                'message' => 'Ação inválida!'
            ], 422);
        }

        $student->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Aluno atualizado com sucesso!',
            'state' => (int) $student->user->state,
            'created_at' => $student->user->created_at,
            'updated_at' => $student->user->updated_at, // pega o mais recente
        ]);
    }
}
