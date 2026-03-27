<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Course;
use App\Models\Paper;
use App\Models\UserCommittee;
use App\Utils\TokenGenerator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Random\RandomException;

class EventController extends Controller
{
    /**
     * @throws RandomException
     */
    /*
     * Essa função inicializa a view blade, injetando os registros das bancas ainda sem datas definidas para os
     * coordenadores realizarem o agendamento. Só recebe esses dados o usuário com nível de acesso 3.
     */
    public function index(): View
    {
        // Inicializa o DynamicToken
        TokenGenerator::initializeTab();

        if(auth()->user()?->can('manage-events')) {
            $eventsData = $this->getEvents();
        }

        $courses = Course::select(['id', 'name'])->where('state', 1)
            ->orderBy('name')->get();

        return view('evaluation.events', [
            'events' => $eventsData ?? [],
            'courses' => $courses ?? [],
        ]);
    }

    public function show(Request $request): JsonResponse
    {
        $query = Committee::with([
            'paper.group.students.user:id,name',
            'members' => function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('state', 1);
                })->with('user:id,name', 'memberType:id,name');
            },
        ])
            ->where('state', 1);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhereHas('paper', function ($sub) use ($search) {
                    $sub->where('title', 'like', "%{$search}%");
                })
                ->orWhereHas('paper.group', function ($sub) use ($search) {
                    $sub->where('theme', 'like', "%{$search}%");
                })
                ->orWhereHas('paper.group.students.user', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                })

                ->orWhereHas('members.user', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                });
            });
        }
        if ($request->filled('course')) {
            $course = $request->input('course');

            $query->whereHas('paper', function ($q) use ($course) {
                $q->where('course_id', $course);
            });
        }
        if ($request->filled('project')) {
            $project = $request->input('project');

            $query->whereHas('paper', function ($q) use ($project) {
                $q->where('project', $project);
            });
        }

        $events = $query->get();

        /*
         * Busca todas as avaliações do usuário de uma vez só
         */
        $userEvaluations = UserCommittee::where('user_id', auth()->id())
            ->whereNotNull('evaluated_at')
            ->pluck('committee_id')
            ->toArray();

        // Ajustar para formato que o FullCalendar espera
        $data = $events
            ->filter(fn($c) => !empty($c->start) && !empty($c->end))
            ->map(function($event) use ($userEvaluations) {
                $start = $event->start;
                $end = $event->end;

                $allDay = (substr($start, 11) === '00:00:00' && substr($end, 11) === '00:00:00');

                $group = $event->paper?->group;

                return [
                    'id' => (int) $event->id,
                    'title' => $event->name,
                    'start' => $start,
                    'end'   => $end,
                    'allDay' => $allDay,
                    'extendedProps' => [
                        'group' => $group->theme,
                        'paper' => $event->paper?->title,

                        'committeeMembers' => $event->members
                            ->map(fn($m) => [
                                'user_committee_id' => $m->id,
                                'user_id' => $m->user_id,
                                'name' => $m->user->name,
                                'member_type' => [
                                    'id' => $m->memberType?->id,
                                    'name' => $m->memberType?->name,
                                ],
                            ])->values(),

                        'groupMembers' => $group->students
                            ->map(fn($m) => [
                                'ra' => $m->ra,
                                'name' => $m->user->name,
                            ])->values(),

                        'belongsTo' => $event->members
                                ->contains(fn($m) => $m->user_id === auth()->id())
                            ||
                            $event->paper?->group?->students->contains(
                                fn($s) => $s->user_id === auth()->id()
                            ),

                        'evaluatedByUser' => in_array($event->id, $userEvaluations),
                    ]
                ];
            });

        return response()->json($data->values()->toArray());
    }

    /*
     * Essa função atualiza um registro de committees com os campos 'start' e 'end'. Apenas coordenadores tem acesso a
     * rota que direciona a essa função, e só possível executá-la com sucesso um usuário administrador. Essa função é
     * usada tanto para agendamento de novas bancas, quando atualização de datas, tanto pelo modal quanto diretamente
     * pelo calendário.
     */
    public function update(Request $request, $id): JsonResponse
    {
        // Se o usuário não for administrador, a função aborta execução (403 -> forbidden)
        $this->authorize('manage-events');

        #region Verificações de integridade
        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Selecione um evento!',
            ], 422);
        }
        // Log::info($request);
        $event = Committee::with('paper')->find($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Evento não encontrado!',
            ], 404);
        }

        if($request->create) {
            if ($event->start !== null || $event->end !== null) {
                return response()->json([
                    'success' => false,
                    'message' => 'A banca já possui data agendada!',
                ], 422);
            }
        }

        // Verifica se já houve avaliação
        $evaluated = $event->paper->submitted_at ?? null;

        // Se não é membro, não pode avaliar
        if ($evaluated) {
            return response()->json([
                'success' => false,
                'message' => 'A banca já possui possui avaliações realizadas, não é possível atualizar seus dados!',
            ], 422);
        }

        if($request->cancel) {
            $event->update([
                'start' => null,
                'end' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Evento $id ($event->name) cancelado com sucesso!",
                'events' => $this->getEvents()
            ]);
        }

        $request->validate([
            'date_start' => 'required|date_format:Y-m-d',
            'date_end'   => 'required|date_format:Y-m-d|after_or_equal:dateStart',
            'time_start' => 'required|date_format:H:i:s',
            'time_end'   => 'required|date_format:H:i:s',
        ]);

        $start = strtotime($request->date_start . ' ' . $request->time_start);
        $end = strtotime($request->date_end . ' ' . $request->time_end);

        if ($end <= $start) {
            return response()->json([
                'success' => false,
                'message' => 'O horário de término deve ser maior que o horário de início.'
            ], 422);
        }
        #endregion

        $event->fill([
            'start' => $start,
            'end'   => $end,
        ]);

        if($event->isDirty()) { // Atualiza apenas em caso de alteração
            $event->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Data atualizada com sucesso!',
            'events' => $this->getEvents()
        ]);
    }

    private function getEvents(): array
    {
        $eventsData = [];

        $events = Committee::with([
            'paper.group',
            'members' => function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('state', 1);
                })->with('user:id,name', 'memberType:id,name');
            },
        ])
            ->where('state', 1)
            ->whereNull('start') // Consulta apenas bancas sem datas definidas
            ->whereNull('end')
            ->get();

        if($events) {
            $eventsData = $events->map(function ($event) {
                $group = $event->paper?->group;
                return [
                    'id' => (int) $event->id,
                    'title' => $event->name,
                    'group' => $group->theme,
                    'paper' => $event->paper?->title,
                    'committeeMembers' => $event->members
                        ->map(fn($m) => [
                            'user_committee_id' => $m->id,
                            'user_id' => $m->user_id,
                            'name' => $m->user->name,
                            'member_type' => [
                                'id' => $m->memberType?->id,
                                'name' => $m->memberType?->name,
                            ],
                        ])->values(),
                    'groupMembers' => $group->students
                        ->map(fn($m) => [
                            'ra' => $m->ra,
                            'name' => $m->user->name,
                        ])->values(),
                ];
            })->values()->toArray();
        }

        return $eventsData;
    }
}
