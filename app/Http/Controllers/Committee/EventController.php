<?php

namespace App\Http\Controllers\Committee;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        // Panitia hanya melihat event yang mereka buat
        $events = Auth::user()->createdEvents()->latest()->paginate(10);
        return view('committee.events.index', compact('events'));
    }

    public function create()
    {
        return view('committee.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'registration_fee' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('event-posters', 'public');
        }

        Auth::user()->createdEvents()->create([
            'name' => $request->name,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'speaker' => $request->speaker,
            'poster_url' => $posterPath,
            'registration_fee' => $request->registration_fee,
            'max_participants' => $request->max_participants,
        ]);

        return redirect()->route('committee.events.index')->with('success', 'Event berhasil dibuat.');
    }

    public function show(Event $event)
    {
        // Tampilkan detail event dan daftar peserta
        // Pastikan panitia hanya bisa melihat event yang mereka buat
        if ($event->created_by !== Auth::id()) {
            abort(403);
        }
        $registrations = $event->registrations()->with('user')->paginate(15);
        return view('committee.events.show', compact('event', 'registrations'));
    }

    public function edit(Event $event)
    {
        if ($event->created_by !== Auth::id()) {
            abort(403);
        }
        return view('committee.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        if ($event->created_by !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'speaker' => 'nullable|string|max:255',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'registration_fee' => 'required|numeric|min:0',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        $eventData = $request->except('poster');

        if ($request->hasFile('poster')) {
            // Hapus poster lama jika ada
            if ($event->poster_url) {
                Storage::disk('public')->delete($event->poster_url);
            }
            $eventData['poster_url'] = $request->file('poster')->store('event-posters', 'public');
        }

        $event->update($eventData);

        return redirect()->route('committee.events.index')->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->created_by !== Auth::id()) {
            abort(403);
        }

        // Hapus poster dari storage
        if ($event->poster_url) {
            Storage::disk('public')->delete($event->poster_url);
        }

        // Relasi event_registrations akan terhapus otomatis karena 'onDelete(cascade)' di migrasi
        $event->delete();

        return redirect()->route('committee.events.index')->with('success', 'Event berhasil dihapus.');
    }
}
