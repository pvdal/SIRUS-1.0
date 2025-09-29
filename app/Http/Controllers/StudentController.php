<?php

namespace App\Http\Controllers;

// Common
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// Users/Models
use App\Actions\Fortify\CreateNewUser;
use App\Models\Student;
use App\Models\Course;
use App\Models\Group;

// Transações no banco
use Illuminate\Support\Facades\DB;

// Log
//use Illuminate\Support\Facades\Log;

// Static Classes and utils
use Random\RandomException;
use App\Utils\TokenGenerator;
use App\Utils\PasswordGenerator;
use Throwable;

class StudentController extends Controller
{
    /**
     * @throws RandomException
     */
    // Exibição inicial de alunos sem aplicação de filtros ou troca de página (‘READ’)
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        // Inicializa o DynamicToken
        TokenGenerator::initializeTab();

        // Query inicial da tabela 'students' (15 por página). Faz join com as tabelas com as quais se relaciona.
        $students = Student::with(
            'user:id,name,email,state,updated_at,created_at',
            'group:id,theme,state',
            'course:id,name,state',
        )->orderBy('ra')->paginate(15);

        // Dados utilizados para o modal de cadastro e filtros
        $groups = Group::select(['id', 'theme'])->where('state', 1)
            ->orderBy('theme')->get();
        $courses = Course::select(['id', 'name'])->where('state', 1)
            ->orderBy('name')->get();

        // Mapeia a coleção de dados paginados retornando array simples com chaves definidas aqui
        $studentsData = $students->getCollection()->map(function ($student) {
            $user = $student->user;
            return $this->mapStudent($student, $user);
        })->values();

        // Retorna a view de gestão de estudantes com os dados extraídos do banco
        return view('management.students', [
            'students' => $studentsData,
            'groups' => $groups,
            'courses' => $courses,
            'page' => $students->currentPage(),
            'totalPages' => $students->lastPage(),
        ]);
    }

    // Exibição de alunos com aplicação de filtros ou troca de página (‘READ’)
    public function show(Request $request): JsonResponse
    {
        //DB::enableQueryLog();
        $query = Student::with(
            'user:id,name,email,state,updated_at,created_at',
            'group:id,theme,state',
            'course:id,name,state',
        )->orderBy('ra');

        #region Filtros
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                    ->orWhere('ra', 'like', "%{$search}%");
            });
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

        $students = $query->paginate(15);

        $groups = Group::select(['id', 'theme'])->where('state', 1)
            ->orderBy('theme', 'asc')->get();
        $courses = Course::select(['id', 'name'])->where('state', 1)
            ->orderBy('name', 'asc')->get();
        //Log::info('Queries executadas:', DB::getQueryLog());

        $studentsData = $students->getCollection()->map(function ($student) {
            $user = $student->user;
            return $this->mapStudent($student, $user);
        })->values();

        return response()->json([
            'data' => $studentsData,
            'groups' => $groups,
            'courses' => $courses,
            'page' => $students->currentPage(),
            'totalPages' => $students->lastPage(),
        ]);
    }

    // Cadastro de alunos (‘CREATE’)
    /**
     * @throws Throwable
     */
    public function store(Request $request, CreateNewUser $creator): JsonResponse
    {
        //Log::info('Dados recebidos no store', $request->all());
        //$start = microtime(true);
        $validated = $request->validate([
            'ra' => 'required|string|digits:13|unique:students,ra',
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc|unique:users,email',
            'group_id' => 'nullable|exists:groups,id',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $user = null;
        $student = null;

        DB::transaction(function () use ($validated, $creator, &$user, &$student) {
            $password = PasswordGenerator::random();

            $user = $creator->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $password,
                'password_confirmation' => $password,
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

            $user->sendTemporaryPasswordNotification($password); // Envio da senha para o usuário cadastrado pelo e-mail por fila no banco
        });
        //$end = microtime(true);
        //Log::info('Tempo criação user direto + professor: ' . ($end - $start) . ' segundos');

        $student->load('group:id,theme', 'course:id,name');

        return response()->json([
            'success' => true,
            'message' => 'Aluno cadastrado com sucesso.',
            'data' => $this->mapStudent($student, $user),
        ]);
    }

    // Atualização de dados (‘UPDATE’)
    public function update(Request $request, $id): JsonResponse
    {
        if(!$id) {
            return response()->json([
                'message' => 'Selecione um grupo!',
            ],422);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email:rfc|unique:users,email,{$id},id",
            'group_id' => 'nullable|exists:groups,id',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        $student = Student::with('user:id,name,email,state,updated_at,created_at')->where('user_id', $id)->first();

        if (!$student || !$student->user) {
            return response()->json([
                'message' => 'Aluno não encontrado!',
            ], 422);
        }

        $student->user->fill([
            'name' => $request['name'],
            'email' => $request['email'],
        ]);

        if($student->user->isDirty()) {
            $student->user->save();
            $student->touch();
        }

        $student->update([
            //'semester' => $request['semester'],
            'group_id' => $request['group_id'],
            'course_id' => $request['course_id'],
        ]);

        $student->load('group:id,theme', 'course:id,name');

        $user = $student->user;

        return response()->json([
            'success' => true,
            'message' => 'Aluno atualizado com sucesso!',
            'data' => $this->mapStudent($student, $user),
        ]);
    }

    // Atualização do status do registro no banco (ativo/inativo)
    public function toggleStatus($id,$action): JsonResponse
    {
        $student = Student::with('user:id,state,created_at,updated_at')->where('user_id', $id)->first();

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

        $student->touch();

        return response()->json([
            'success' => true,
            'message' => 'Aluno atualizado com sucesso!',
            'state' => (int) $student->user->state,
            'created_at' => $student->created_at ?? $student->user->created_at,
            'updated_at' => $student->updated_at ?? $student->user->updated_at,
        ]);
    }

    // Mapeamento da array de students injetada no front
    private function mapStudent($student, $user): array
    {
        return [
            'ra' => $student->ra,
            'user_id' => $student->user_id,
            'name' => $student->user->name,
            'email' => $student->user->email,
            'group' => [
                'id' => $student->group->id ?? null,
                'name' => $student->group->theme ?? '',
            ],
            'course' => [
                'id' => $student->course->id ?? null,
                'name' => $student->course->name ?? '',
            ],
            'state' => (int) $student->user->state,
            'created_at' => $student->created_at ?? $user->created_at,
            'updated_at' => $student->updated_at ?? $user->updated_at,
        ];
    }
}
