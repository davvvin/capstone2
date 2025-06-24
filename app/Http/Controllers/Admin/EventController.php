<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event; // Import model Event
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Untuk saat ini, kita hanya akan mengambil semua event
        // Nanti bisa ditambahkan paginasi dan pencarian
        $events = Event::with('creator')->latest()->paginate(10);

        // Kita perlu membuat view untuk ini nanti
        return view('admin.events.index', compact('events'));
    }

    // Metode lain (create, store, edit, dll.) akan kita isi nanti
    // ...
}