<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return view('calendar');
    }

    public function events(Request $request)
    {
        // Verifica se a requisição vem da página do calendário
        $referer = $request->header('referer');
        $allowedReferer = url('/calendar');

        $isValidReferer = false;
        if (str_starts_with($referer, $allowedReferer)) {
            $isValidReferer = true;
        }

        if (!$isValidReferer) {
            return redirect('/calendar');
        }
        $events = Event::all();

        // Ajustar para formato que o FullCalendar espera
        $formattedEvents = $events->map(function($event) {
            return [
                'event_id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'color' => $event->color,
            ];
        });

        return response()->json($formattedEvents);
    }
}
