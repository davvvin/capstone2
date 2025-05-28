<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyEventController extends Controller
{
    /**
     * Menampilkan daftar event yang telah didaftari oleh member.
     */
    public function index()
    {
        $user = Auth::user();
        // Ambil registrasi event milik user yang login, beserta data event terkait
        $registrations = $user->eventRegistrations()->with('event')->latest()->paginate(10);

        return view('member.my-events.index', compact('registrations'));
    }
}
