<?php

namespace App\Http\Controllers;

// Common
use App\Exports\ProfessorsExport;
use App\Exports\ProfessorsResultExport;
use App\Exports\ProfessorsTemplateExport;
use App\Imports\ProfessorsImport;
use App\Models\FacultyEducation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// Users/Models
use App\Actions\Fortify\CreateNewUser;
use App\Models\Professor;

// Transações no banco
use Illuminate\Support\Facades\DB;

// Log
//use Illuminate\Support\Facades\Log;

// Static Classes and utils
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Random\RandomException;
use App\Utils\TokenGenerator;
use App\Utils\PasswordGenerator;
use Throwable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProfessorController extends Controller
{
    /**
     * @throws RandomException
     */
    // Exibição inicial de professores sem aplicação de filtros ou troca de página (‘READ’)
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        // Inicializa o DynamicToken
        TokenGenerator::initializeTab();
        // Faz uma query no banco trazendo 15 registros paginados
        $professors = Professor::with([
            'user:id,name,email,state,updated_at,created_at',
            'user.education'
        ])->orderBy('id')->paginate(30);

        // Pega a coleção paginada que retornou da query acima e mapeia com chaves amigáveis
        $professorsData = $professors->getCollection()->map(function ($professor) {
            return $this->mapProfessor($professor);
        })->values(); // Pega apenas a array de valores
        // Retorna os dados na view de gerenciamento de professores
        return view('management.professors', [
            'professors' => $professorsData,
            'page' => $professors->currentPage(),
            'totalPages' => $professors->lastPage(),
        ]);
    }

    // Exibição de professores com aplicação de filtros ou troca de página (‘READ’)
    public function show(Request $request): JsonResponse
    {
        //DB::enableQueryLog();

        $query = Professor::with([
            'user:id,name,email,state,updated_at,created_at',
            'user.education'
        ])->orderBy('id'); // Carrega dados do usuário

        #region Filtros
        // searchTerm: por nome ou email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('education', 'like', "%{$search}%");
            });
        }
        // statusFilter: ativo ou inativo
        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->whereHas('user', function ($q) use ($status) {
                $q->where('state', $status);
            });
        }
        // registerPeriod: período de cadastro
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

        // Transforma a query que recebeu os filtros em objeto paginado
        $professors = $query->paginate(30);
        //Log::info('Queries executadas:', DB::getQueryLog());

        // Mapeia para retornar somente os campos necessários
        $professorsData = $professors->getCollection()->map(function ($professor) {
            return $this->mapProfessor($professor);
        })->values();

        // Retorna json com os registros filtrados
        return response()->json([
            'data' => $professorsData,
            'page' => $professors->currentPage(),
            'totalPages' => $professors->lastPage(),
        ]);
    }

    // Cadastro de professores (‘CREATE’)

    /**
     * @throws Throwable
     */
    public function store(Request $request, CreateNewUser $creator): JsonResponse
    {
        //$start = microtime(true);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc|unique:users,email',
            'education' => 'nullable|array',
            'education.*.level' => 'required|string|in:graduation,specialization,masters,doctorate',
            'education.*.course' => 'required|string|max:255',
            'education.*.institution' => 'nullable|string|max:255',
        ], [
            'education.*.course.required' => 'O curso da formação é obrigatório.',
        ]);

        $professor = null;

        DB::transaction(function () use ($validated, $creator, &$professor) {
            $password = PasswordGenerator::random();

            // Cria o usuário usando o controller nativo do Fortify
            $user = $creator->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $password,
                'password_confirmation' => $password,
                'access_level' => 2, // 2 = Professor
                'state' => 1,
            ]);

            // Cria o professor vinculado ao usuário
            $professor = Professor::create([
                'user_id' => $user->id,
            ]);

            if (!empty($validated['education'])) {
                $user->education()->createMany(
                    collect($validated['education'])->map(function ($education) {
                        return [
                            'level' => $education['level'],
                            'course' => $education['course'],
                            'institution' => $education['institution'],
                        ];
                    })->toArray()
                );
            }

            // Envio da senha para o usuário cadastrado pelo e-mail por fila no banco
            $user->sendTemporaryPasswordNotification($password);
        });
        //$end = microtime(true);
        //Log::info('Tempo criação user direto + professor: ' . ($end - $start) . ' segundos');

        return response()->json([
            'success' => true,
            'message' => 'Professor cadastrado com sucesso.',
            'data' => $this->mapProfessor($professor)
        ]);
    }

    public function update (Request $request, $id): JsonResponse
    {
        if(!$id) {
            return response()->json([
                'message' => 'Selecione um professor!',
            ],422);
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => "required|email:rfc|unique:users,email,{$id},id",
            'education' => 'nullable|array',
            'education.*.level' => 'required|string|in:graduation,specialization,masters,doctorate',
            'education.*.course' => 'required|string|max:255',
            'education.*.institution' => 'nullable|string|max:255',
        ], [
            'education.*.course.required' => 'O curso da formação é obrigatório.',
        ]);

        $professor = Professor::with([
            'user:id,name,email,state,updated_at,created_at',
            'user.education'
        ])->where('user_id', $id)
            ->first();

        if(!$professor || !$professor->user) {
            return response()->json([
                'message' => 'Professor não encontrado!',
            ],422);
        }

        // Adiciona os valores na memória
        $professor->user->fill([
            'name' => $request['name'],
            'email' => $request['email'],
        ]);

        // Se houver alteração comparado aos dados vindos do banco, isDirty retorna true
        if($professor->user->isDirty()) {
            $professor->user->save();
            $professor->touch(); // Atualiza timestamps do professor
        }

        $currentEducation = $professor->user->education
            ->map(fn ($item) => [
                'level' => $item->level,
                'course' => $item->course,
                'institution' => $item->institution,
            ])
            ->sortBy('level')
            ->values()
            ->toArray();

        $newEducation = collect($request->education)
            ->map(fn ($item) => [
                'level' => $item['level'],
                'course' => $item['course'],
                'institution' => $item['institution'] ?? null,
            ])
            ->sortBy('level')
            ->values()
            ->toArray();

        if (json_encode($currentEducation) != json_encode($newEducation)) {
            $professor->user->education()->delete();
            $professor->user->education()->createMany($newEducation);

            $professor->touch();
        }

        if($professor->isDirty()) {
            $professor->save();
        }

        $professor->user->load('education');

        return response()->json([
            'success' => true,
            'message' => 'Professor atualizado com sucesso.',
            'data' => $this->mapProfessor($professor)
        ]);
    }

    public function toggleStatus($id, $action): JsonResponse
    {
        // Busca primeiro professor com o ‘ID’ passado como parâmetro
        $professor = Professor::with(
            'user:id,name,email,state'
        )->where('user_id', $id)->first();

        if (!$professor || !$professor->user) {
            return response()->json([
                'message' => 'Professor não encontrado!',
            ], 422);
        }

        // Inativa ou ativa a depender da $action
        if ($action === 'inactivate') {
            $professor->user->update(['state' => 0]);
        } elseif ($action === 'activate') {
            $professor->user->update(['state' => 1]);
        }  else {
            return response()->json([
                'message' => 'Ação inválida!'
            ], 422);
        }

        $professor->touch();

        return response()->json([
            'success' => true,
            'message' => 'Professor atualizado com sucesso!',
            'state' => (int) $professor->user->state,
            'created_at' => $professor->created_at ?? $professor->user->created_at,
            'updated_at' =>$professor->updated_at ?? $professor->user->updated_at,
        ]);
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function generateFile(Request $request): BinaryFileResponse
    {
        $filters = [
            'search'   => $request->query('searchTerm'),
            'status'    => $request->query('status'),
            'period'    => $request->query('period'),
        ];
        return Excel::download(new ProfessorsExport($filters), 'relatorio-professores.xlsx');
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function downloadTemplate(): BinaryFileResponse
    {
        return Excel::download(new ProfessorsTemplateExport, 'modelo-importacao-professores.xlsx');
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function import(Request $request): BinaryFileResponse
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        $import = new ProfessorsImport;
        Excel::import($import, $request->file('file'));

        return Excel::download(
            new ProfessorsResultExport($import->rowsProcessed), 'resultado-importacao.xlsx');
    }

    private function mapProfessor($professor): array
    {
        $user = $professor->user;
        return [
            'id' => $professor->id,
            'user_id' => $professor->user_id,
            'name' => $user->name ?? '-',
            'email' => $user->email ?? '-',
            'education' => $professor->user->education->isNotEmpty() ?
                $professor->user->education
                    ->groupBy('level')
                    ->map(function ($items) {
                        return $items->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'course' => $item->course,
                                'institution' => $item->institution,
                            ];
                        });
                    }) : [],
            'state' => isset($user->state) ? (int) $user->state : 0,
            'created_at' => $professor->created_at ?? $user->created_at,
            'updated_at' => $professor->updated_at ?? $user->updated_at,
            'expanded' => false,
        ];
    }
}
