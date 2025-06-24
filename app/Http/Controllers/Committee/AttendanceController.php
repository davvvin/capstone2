<?php

namespace App\Http\Controllers\Committee;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Menampilkan halaman untuk scan QR code.
     */
    public function scanPage(Event $event)
    {
        // Pastikan panitia hanya bisa mengakses halaman scan untuk event yang mereka buat
        if ($event->created_by !== Auth::id()) {
            abort(403, 'Anda tidak berwenang mengakses halaman ini.');
        }
        return view('committee.attendance.scan', compact('event'));
    }

    /**
     * Menandai kehadiran peserta berdasarkan registration_code yang diterima.
     * Ini akan dipanggil oleh JavaScript dari halaman scan.
     */
    public function markAttendance(Request $request)
    {
        $request->validate([
            'registration_code' => 'required|string',
            'event_id' => 'required|exists:events,id',
        ]);

        // Cek apakah panitia berwenang untuk event ini
        $event = Event::findOrFail($request->event_id);
        if ($event->created_by !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Tidak berwenang.'], 403);
        }

        $registration = EventRegistration::with('user')
                            ->where('registration_code', $request->registration_code)
                            ->where('event_id', $request->event_id)
                            ->first();

        if (!$registration) {
            return response()->json(['success' => false, 'message' => 'QR Code tidak valid atau bukan untuk event ini.'], 404);
        }

        if ($registration->is_attended) {
            return response()->json(['success' => false, 'message' => 'Peserta ' . $registration->user->name . ' sudah ditandai hadir sebelumnya.'], 409); // 409 Conflict
        }

        if ($registration->payment_status !== 'verified') {
             return response()->json(['success' => false, 'message' => 'Pembayaran peserta ' . $registration->user->name . ' belum terverifikasi.'], 402);
        }

        $registration->update([
            'is_attended' => true,
            'scanned_at' => now(),
            'scanned_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Berhasil! ' . $registration->user->name . ' ditandai hadir.'
        ]);
    }
}
