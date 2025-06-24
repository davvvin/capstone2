<?php

namespace App\Http\Controllers;

use App\Models\Event; // Pastikan model Event di-import
use Illuminate\Http\Request;

class GuestEventController extends Controller
{
    /**
     * Menampilkan daftar semua event yang akan datang untuk guest.
     */
    public function index()
    {
        $events = Event::where('event_date', '>=', now()) // <-- BAGIAN INI PENTING
                        ->orderBy('event_date', 'asc')
                        ->paginate(9);

        return view('guest.events.index', compact('events'));
    }

    /**
     * Menampilkan detail satu event untuk guest.
     */
    public function show(Event $event) // Menggunakan Route Model Binding
    {
        // Anda mungkin ingin memuat relasi lain jika diperlukan, contoh:
        // $event->load('creator'); // Jika Anda ingin menampilkan info pembuat event (panitia)

        // Asumsikan ada view 'guest.events.show'
        return view('guest.events.show', compact('event'));
    }
}
