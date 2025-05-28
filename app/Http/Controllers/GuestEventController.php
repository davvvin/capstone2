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
        $events = Event::where('event_date', '>=', now()) // Hanya event yang belum lewat tanggalnya
                        ->orderBy('event_date', 'asc')
                        ->paginate(9); // Menampilkan 9 event per halaman, sesuaikan jika perlu

        // Untuk halaman guest, kita mungkin tidak menggunakan layout admin.
        // Jika Anda memiliki layout publik terpisah (misalnya, layouts.public), gunakan itu.
        // Jika tidak, Anda bisa membuat view sederhana tanpa layout admin yang kompleks.
        // Untuk contoh ini, kita asumsikan ada view 'guest.events.index'
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
