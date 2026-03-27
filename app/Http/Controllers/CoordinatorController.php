<?php

namespace App\Http\Controllers;

// Common
use App\Exports\CoordinatorsExport;
use App\Exports\ProfessorsResultExport;
use App\Exports\ProfessorsTemplateExport;
use App\Imports\CoordinatorsImport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// Users/Models
use App\Actions\Fortify\CreateNewUser;
use App\Models\Coordinator;

// Transações no banco
use Illuminate\Support\Facades\DB;

// Log
//use Illuminate\Support\Facades\Log;

// Static Classes and utils
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Random\RandomException;
use App\Utils\TokenGenerator;
use App\Utils\PasswordGenerator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class CoordinatorController extends Controller
{
    /**
     * @throws RandomException
     */
    // Exibição inicial de coordenadores sem aplicação de filtros ou troca de página (‘READ’)
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        // Inicializa o DynamicToken
        TokenGenerator::initializeTab();
        // Faz uma query no banco trazendo 15 registros paginados
        $coordinators = Coordinator::with([
            'user:id,name,email,state,updated_at,created_at',
            'user.education'
        ])->orderBy('id')->paginate(30);

        // Pega a coleção paginada que retornou da query acima e mapeia com chaves amigáveis
        $coordinatorsData = $coordinators->getCollection()->map(function ($coordinator) {
            return $this->mapCoordinator($coordinator);
        })->values();
        // Retorna os dados na view de gerenciamento de coordenadores
        return view('management.coordinators', [
            'coordinators' => $coordinatorsData,
            'page' => $coordinators->currentPage(),
            'totalPages' => $coordinators->lastPage(),
        ]);
    }

    // Exibição de coordenadores com aplicação de filtros ou troca de página (‘READ’)
    public function show (Request $request): jsonResponse
    {
        //DB::enableQueryLog();
        // Consulta no banco, join user com alguns campos ordenados por id
        $query = Coordinator::with([
            'user:id,name,email,state,updated_at,created_at',
            'user.education'
        ])->orderBy('id');

        #region Filtros
        // searchTerm: por nome ou email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
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

        //paginação dos dados que vieram do banco
        $coordinators = $query->paginate(30);
        //Log::info('Queries executadas:', DB::getQueryLog());

        // Mapeia para retornar somente os campos necessários com chaves amigáveis
        $coordinatorsData = $coordinators->getCollection()->map(function ($coordinator) {
            return $this->mapCoordinator($coordinator);
        })->values();

        // Retorna dos dados dos coordenadores + pagina atual e última página
        return response()->json([
            'data' => $coordinatorsData,
            'page' => $coordinators->currentPage(),
            'totalPages' => $coordinators->lastPage(),
        ]);
    }

    // Cadastro de coordenadores (‘CREATE’)

    /**
     * @throws Throwable
     */
    public function store (Request $request, CreateNewUser $creator): jsonResponse
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

        $coordinator = null;

        DB::transaction(function () use ($validated, $creator, &$coordinator) {
            $password = PasswordGenerator::random();

            // Cria o usuário usando o Fortify
            $user = $creator->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $password,
                'password_confirmation' => $password,
                'access_level' => 3, // 3 = Coordinator
                'state' => 1,
            ]);

            // Cria o coordenador vinculado ao usuário
            $coordinator = Coordinator::create([
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
        //Log::info('Tempo criação user direto + coordenador: ' . ($end - $start) . ' segundos');

        return response()->json([
            'success' => true,
            'message' => 'Coordenador cadastrado com sucesso.',
            'data' => $this->mapCoordinator($coordinator)
        ]);
    }

    public function update (Request $request, $id): JsonResponse
    {
        if(!$id) {
            return response()->json([
                'message' => 'Selecione um Coordenador!',
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

        $coordinator = Coordinator::with([
            'user:id,name,email,state,updated_at,created_at',
            'user.education'
        ])->where('user_id', $id)
            ->first();

        if(!$coordinator || !$coordinator->user) {
            return response()->json([
                'message' => 'Coordenador não encontrado!',
            ],422);
        }

        // Atualiza os campos em memória
        $coordinator->user->fill([
            'name' => $request['name'],
            'email' => $request['email'],
        ]);

        // Só salva se houver mudanças
        if($coordinator->user->isDirty()) {
            $coordinator->user->save(); // Salva apenas se houver mudança, isNotDirty
            $coordinator->touch(); // Atualiza timestamps do coordenador
        }

        $currentEducation = $coordinator->user->education
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
            $coordinator->user->education()->delete();
            $coordinator->user->education()->createMany($newEducation);

            $coordinator->touch();
        }

        if($coordinator->isDirty()) {
            $coordinator->save();
        }

        $coordinator->user->load('education');

        return response()->json([
            'success' => true,
            'message' => 'Coordenador atualizado com sucesso.',
            'data' => $this->mapCoordinator($coordinator)
        ]);
    }

    public function toggleStatus($id,$action): JsonResponse
    {
        $coordinator = Coordinator::with(
            'user:id,name,email,state'
        )->where('user_id', $id)->first();

        if (!$coordinator || !$coordinator->user) {
            return response()->json([
                'message' => 'Coordenador não encontrado!',
            ], 422);
        }
        // O utilizador autenticado na sessão atual não pode se inativar
        if(auth()->user()->id === $coordinator->user_id) {
            return response()->json([
                'message' => 'Você não pode inativar a própria conta!'
            ],403);
        }

        if ($action === 'inactivate') {
            $coordinator->user->update(['state' => 0]);
        } elseif ($action === 'activate') {
            $coordinator->user->update(['state' => 1]);
        }  else {
            return response()->json([
                'message' => 'Ação inválida!'
            ], 422);
        }

        $coordinator->touch();

        return response()->json([
            'success' => true,
            'message' => 'Coordenador atualizado com sucesso!',
            'state' => (int) $coordinator->user->state,
            'created_at' => $coordinator->created_at ?? $coordinator->user->created_at,
            'updated_at' => $coordinator->updated_at ?? $coordinator->user->updated_at,
        ]);
    }

    public function generateFile(Request $request): BinaryFileResponse
    {
        $filters = [
            'search'   => $request->query('searchTerm'),
            'status'    => $request->query('status'),
            'period'    => $request->query('period'),
        ];
        return Excel::download(new CoordinatorsExport($filters), 'relatorio-Coordenadores.xlsx');
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function downloadTemplate(): BinaryFileResponse
    {
        return Excel::download(new ProfessorsTemplateExport, 'modelo-importacao.xlsx');
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function import(Request $request): BinaryFileResponse
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        $import = new CoordinatorsImport();
        Excel::import($import, $request->file('file'));

        return Excel::download(
            new ProfessorsResultExport($import->rowsProcessed), 'resultado-importacao.xlsx');
    }

    private function mapCoordinator($coordinator): array
    {
        $user = $coordinator->user;
        return [
            'id' => $coordinator->id,
            'user_id' => $coordinator->user_id,
            'name' => $user->name ?? '-',
            'email' => $user->email ?? '-',
            'education' => $coordinator->user->education->isNotEmpty() ?
                $coordinator->user->education
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
            'created_at' => $coordinator->created_at ?? $user->created_at,
            'updated_at' => $coordinator->updated_at ?? $user->updated_at,
        ];
    }
}
