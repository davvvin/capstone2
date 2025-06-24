<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class GuestEventController extends Controller
{
    public function index()
    {
        $events = Event::where('event_date', '>=', now()) // <-- BAGIAN INI PENTING
                        ->orderBy('event_date', 'asc')
                        ->paginate(9);

        return view('guest.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        return view('guest.events.show', compact('event'));
    }
}
