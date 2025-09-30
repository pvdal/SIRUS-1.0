<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Utils\TokenGenerator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
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

        return view('evaluation.events');
    }
    /*
    public function events(Request $request): jsonResponse
    {
        $events = Event::all();
        // Ajustar para formato que o FullCalendar espera
        $data = $events->map(function($event) {
            return [
                'event_id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'color' => $event->color,
            ];
        });

        return response()->json($data);
    }
    */

    public function show(): JsonResponse
    {
        $committees = Committee::all();
        // Ajustar para formato que o FullCalendar espera
        $data = $committees
            ->filter(fn($c) => !empty($c->start) && !empty($c->end))
            ->map(function($committee) {
                $start = $committee->start;
                $end = $committee->end;

                // Verifica se tem hora
                $allDay = (substr($start, 11) === '00:00:00' && substr($end, 11) === '00:00:00');

                return [
                    'id' => $committee->id,
                    'title' => $committee->name,
                    'start' => $start,
                    'end'   => $end,
                    'allDay' => $allDay,
                ];
            });


        return response()->json($data);
    }
}
