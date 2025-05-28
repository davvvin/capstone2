<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalRegistrations = EventRegistration::count();
        // Tambahkan data lain yang relevan untuk dashboard admin

        return view('admin.dashboard', compact('totalUsers', 'totalEvents', 'totalRegistrations'));
    }
}
