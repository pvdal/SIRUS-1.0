<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        session(['custom_token' => bin2hex(random_bytes(16))]);

        return view('calendar');
    }

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
}
