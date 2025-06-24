<?php

namespace App\Http\Controllers\Committee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil event yang dibuat oleh panitia yang sedang login
        $myEvents = Auth::user()->createdEvents()->count();
        // Anda bisa menambahkan data lain seperti total peserta di semua eventnya, dll.
        return view('committee.dashboard', compact('myEvents'));
    }
}