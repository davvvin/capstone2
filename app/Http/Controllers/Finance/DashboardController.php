<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $awaitingVerification = EventRegistration::where('payment_status', 'awaiting_verification')->count();
        $verifiedToday = EventRegistration::where('payment_status', 'verified')->whereDate('payment_verified_at', today())->count();

        return view('finance.dashboard', compact('awaitingVerification', 'verifiedToday'));
    }
}
