<?php

namespace App\Http\Controllers;

use App\Models\Committee;
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

        return view('evaluation.events', [
            'events' => $eventsData ?? [],
        ]);
    }

    public function show(): JsonResponse
    {
        $events = Committee::with([
            'paper.group',
            'members' => function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('state', 1);
                })->with('user:id,name', 'memberType:id,name');
            },
        ])
            ->where('state', 1)
            ->get();

        // Ajustar para formato que o FullCalendar espera
        $data = $events
            ->filter(fn($c) => !empty($c->start) && !empty($c->end))
            ->map(function($event) {
                $start = $event->start;
                $end = $event->end;
                // Verifica se tem hora
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
                        'members' => $event->members
                            ->map(fn($m) => [
                                'user_committee_id' => $m->id,
                                'user_id' => $m->user_id,
                                'name' => $m->user->name,
                                'member_type' => [
                                    'id' => $m->memberType?->id,
                                    'name' => $m->memberType?->name,
                                ],
                                'belongsTo' => $m->user_id === auth()->id(),
                            ])->values(),
                    ]
                ];
            });

        return response()->json($data);
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
        $event = Committee::find($id);

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
                    'members' => $event->members
                        ->map(fn($m) => [
                            'user_id' => $m->user_id,
                            'name' => $m->user->name,
                            'member_type' => [
                                'id' => $m->memberType?->id,
                                'name' => $m->memberType?->name,
                            ],
                        ])->values(),
                ];
            })->values()->toArray();
        }

        return $eventsData;
    }
}
