<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentVerificationController extends Controller
{
    // Menampilkan daftar semua registrasi yang menunggu verifikasi
    public function index()
    {
        $registrations = EventRegistration::with(['user', 'event'])
                            ->where('payment_status', 'awaiting_verification')
                            ->latest()
                            ->paginate(10);

        return view('finance.verifications.index', compact('registrations'));
    }

    // Menampilkan detail satu registrasi untuk diverifikasi
    public function show(EventRegistration $registration)
    {
        // Pastikan statusnya memang sedang menunggu verifikasi
        if ($registration->payment_status !== 'awaiting_verification') {
            return redirect()->route('finance.verifications.index')->with('warning', 'Registrasi ini tidak dalam status menunggu verifikasi.');
        }
        return view('finance.verifications.show', compact('registration'));
    }

    // Menyetujui pembayaran
    public function approve(Request $request, EventRegistration $registration)
    {
        $registration->update([
            'payment_status' => 'verified',
            'payment_verified_by' => Auth::id(),
            'payment_verified_at' => now(),
            'registration_code' => strtoupper(uniqid('EVREG-')), // Generate kode registrasi unik
            'payment_rejection_reason' => null
        ]);

        // Di sini Anda bisa menambahkan notifikasi email ke member
        // Mail::to($registration->user->email)->send(new PaymentVerified($registration));

        return redirect()->route('finance.verifications.index')->with('success', 'Pembayaran untuk pengguna ' . $registration->user->name . ' telah berhasil diverifikasi.');
    }

    // Menolak pembayaran
    public function reject(Request $request, EventRegistration $registration)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $registration->update([
            'payment_status' => 'rejected',
            'payment_verified_by' => Auth::id(), // Catat siapa yang menolak
            'payment_verified_at' => now(),
            'payment_rejection_reason' => $request->rejection_reason
        ]);

        // Di sini Anda bisa menambahkan notifikasi email ke member tentang penolakan
        // Mail::to($registration->user->email)->send(new PaymentRejected($registration));

        return redirect()->route('finance.verifications.index')->with('success', 'Pembayaran untuk pengguna ' . $registration->user->name . ' telah ditolak.');
    }
}
