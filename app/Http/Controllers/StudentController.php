<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Student;
use App\Models\Group;
use App\Models\Course;

// Log
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Random\RandomException;

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
            'user:id,name,email,state',
            'group:id,theme',
            'course:id,name',
        )->paginate(10);
        $groups = Group::select('id', 'theme')->where('state', 1)->get();
        $courses = Course::select('id', 'name')->where('state', 1)->get();

        $data = $students->getCollection()->map(function ($student) {
            return [
                'ra' => $student->ra,
                'user_id' => $student->user_id,
                'name' => $student->user->name,
                'email' => $student->user->email,
                'semester' => $student->semester,
                'group_id' => $student->group->id ?? null,
                'group_name' => $student->group->theme ?? null,
                'course_id' => $student->course->id ?? null,
                'course_name' => $student->course->name ?? null,
                'state' => (int) $student->user->state,
            ];
        });

        return view('management.students', [
            'students' => $data,
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
            'user:id,name,email,state',
            'group:id,theme',
            'course:id,name',
        );

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
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
        $groups = Group::select('id', 'theme')->where('state', 1)->get();
        $courses = Course::select('id', 'name')->where('state', 1)->get();
        //Log::info('Queries executadas:', DB::getQueryLog());

        $data = $students->getCollection()->map(function ($student) {
            return [
                'ra' => $student->ra,
                'user_id' => $student->user_id,
                'name' => $student->user->name,
                'email' => $student->user->email,
                'semester' => $student->semester,
                'group_id' => $student->group->id ?? null,
                'group_name' => $student->group->theme ?? null,
                'course_id' => $student->course->id ?? null,
                'course_name' => $student->course->name ?? null,
                'state' => (int) $student->user->state,
            ];
        });

        return response()->json([
            'data' => $data,
            'groups' => $groups,
            'courses' => $courses,
            'current_page' => $students->currentPage(),
            'last_page' => $students->lastPage(),
        ]);
    }

    public function store(Request $request, CreateNewUser $creator): JsonResponse
    {
        //$start = microtime(true);
        $validated = $request->validate([
            'ra' => 'required|string|max:13|unique:students,ra',
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'semester' => 'required|integer|min:1|max:10',
            'group_id' => 'nullable|exists:groups,id',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $user = $creator->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'access_level' => 1, // 1 = Student
            'state' => 1,
        ]);

        $student = Student::create([
            'ra' => $validated['ra'],
            'semester' => $validated['semester'],
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
                'semester' => $student->semester,
                'group_id' => $student->group->id ?? null,
                'group_name' => $student->group->theme ?? null,
                'course_id' => $student->course->id ?? null,
                'course_name' => $student->course->name ?? null,
                'state' => (int) $user->state,
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
            'semester' => 'required|integer|min:1|max:10',
            'group_id' => 'nullable|exists:groups,id',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $student = Student::with('user:id,name,email,state')->where('user_id', $id)->first();

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
            'semester' => $request['semester'],
            'group_id' => $request['group_id'],
            'course_id' => $request['course_id'],
        ]);

        $student->load('group:id,theme', 'course:id,name');

        return response()->json([
            'success' => true,
            'message' => 'Aluno atualizado com sucesso!',
            'data' => [
                'ra' => $student->ra,
                'user_id' => $student->user_id,
                'name' => $student->user->name,
                'email' => $student->user->email,
                'semester' => $student->semester,
                'group_id' => $student->group->id ?? null,
                'group_name' => $student->group->theme ?? null,
                'course_id' => $student->course->id ?? null,
                'course_name' => $student->course->name ?? null,
                'state' => (int) $student->user->state,
            ]
        ]);
    }

    public function inactivate($id): JsonResponse
    {
        $student = Student::with('user:id,name,email,state')->where('user_id', $id)->first();

        if (!$student || !$student->user) {
            return response()->json([
                'message' => 'Aluno não encontrado!',
            ], 422);
        }

        $student->user->update(['state' => 0]);

        $student->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Aluno inativado com sucesso.'
        ]);
    }

    public function activate($id): JsonResponse
    {
        $student = Student::with('user:id,name,email,state')->where('user_id', $id)->first();

        if (!$student || !$student->user) {
            return response()->json([
                'message' => 'Aluno não encontrado!',
            ], 422);
        }

        $student->user->update(['state' => 1]);

        $student->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Aluno ativado com sucesso.'
        ]);
    }
}
