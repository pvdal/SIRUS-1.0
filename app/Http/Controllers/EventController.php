<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Utils\TokenGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Random\RandomException;

class EventController extends Controller
{
    /**
     * @throws RandomException
     */
    public function index(): View
    {
        // Inicializa o DynamicToken
        TokenGenerator::initializeTab();

        $committeesData = [];

        if(auth()->user()?->can('manage-events')) {
            $committees = Committee::with([
                'paper.group',
                'members' => function ($query) {
                    $query->whereHas('user', function ($q) {
                        $q->where('state', 1);
                    })->with('user:id,name', 'memberType:id,name');
                },
            ])
                ->where('state', 1)
                ->whereNull('start')
                ->whereNull('end')
                ->get();

            if($committees) {
                $committeesData = $committees->map(function ($committee) {
                    $group = $committee->paper?->group;
                    return [
                        'id' => (int) $committee->id,
                        'title' => $committee->name,
                        'group' => $group->theme,
                        'paper' => $committee->paper?->title,
                        'members' => $committee->members
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
        }

        return view('evaluation.events', [
            'committees' => $committeesData ?? [],
        ]);
    }

    public function show(): JsonResponse
    {
        $committees = Committee::with([
            'paper.group',
            'members' => function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('state', 1);
                })->with('user:id,name', 'memberType:id,name');
            },
        ])->get();
        // Ajustar para formato que o FullCalendar espera
            $data = $committees
                ->filter(fn($c) => !empty($c->start) && !empty($c->end))
                ->map(function($committee) {
                    $start = $committee->start;
                    $end = $committee->end;
                    // Verifica se tem hora
                    $allDay = (substr($start, 11) === '00:00:00' && substr($end, 11) === '00:00:00');

                    $group = $committee->paper?->group;

                    return [
                        'id' => (int) $committee->id,
                        'title' => $committee->name,
                        'start' => $start,
                        'end'   => $end,
                        'allDay' => $allDay,
                        'extendedProps' => [
                            'group' => $group->theme,
                            'paper' => $committee->paper?->title,
                            'members' => $committee->members
                                ->map(fn($m) => [
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

    public function update(Request $request, $id): JsonResponse
    {

        $this->authorize('manage-events');

        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'Selecione um evento!',
            ], 422);
        }

        $committee = Committee::find($id);

        if (!$committee) {
            return response()->json([
                'success' => false,
                'message' => 'Evento não encontrado!',
            ], 404);
        }

        if($request->create) {
            if ($committee->start !== null || $committee->end !== null) {
                return response()->json([
                    'success' => false,
                    'message' => 'A banca já possui data agendada!',
                ], 422);
            }
        }

        $request->validate([
            'dateStart' => 'required|date_format:Y-m-d',
            'dateEnd'   => 'required|date_format:Y-m-d|after_or_equal:dateStart',
            'timeStart' => 'required|date_format:H:i:s',
            'timeEnd'   => 'required|date_format:H:i:s',
        ]);

        $start = strtotime($request->dateStart . ' ' . $request->timeStart);
        $end = strtotime($request->dateEnd . ' ' . $request->timeEnd);

        if ($end <= $start) {
            return response()->json([
                'success' => false,
                'message' => 'O horário de término deve ser maior que o horário de início.'
            ], 422);
        }

        $committee->fill([
            'start' => $start,
            'end'   => $end,
        ]);

        if($committee->isDirty()) {
            $committee->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Data atualizada com sucesso!',
        ]);
    }
}
