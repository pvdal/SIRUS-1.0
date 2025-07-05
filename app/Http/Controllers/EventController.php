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

    public function events()
    {
        $events = Event::all();

        // Ajustar para formato que o FullCalendar espera
        $formattedEvents = $events->map(function($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
            ];
        });

        return response()->json($formattedEvents);
    }
}
