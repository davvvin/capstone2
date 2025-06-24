<?php

namespace App\Http\Controllers\Committee;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class CommitteeEventController extends Controller
{
    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'required|string|max:255',
            'speaker' => 'required|string|max:255',
            'poster_url' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'registration_fee' => 'required|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster_url'] = $request->file('poster')->store('posters', 'public');
        }

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil ditambahkan.');
    }
}