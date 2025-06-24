<?php

namespace App\Http\Controllers\Committee;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Menampilkan daftar peserta yang hadir dari sebuah event untuk manajemen sertifikat.
     */
    public function indexForEvent(Event $event)
    {
        // Pastikan panitia hanya bisa mengakses event yang mereka buat
        if ($event->created_by !== Auth::id()) {
            abort(403);
        }

        // Ambil registrasi yang sudah hadir dan muat relasi sertifikatnya
        $registrations = $event->registrations()
                                ->with(['user', 'certificate'])
                                ->where('is_attended', true)
                                ->paginate(15);

        return view('committee.certificates.index', compact('event', 'registrations'));
    }

    /**
     * Menyimpan data sertifikat untuk sebuah registrasi.
     */
    public function store(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:event_registrations,id',
            'certificate_url' => 'required|url|max:255',
        ]);

        $registration = EventRegistration::findOrFail($request->registration_id);

        // Validasi: Pastikan panitia berwenang untuk event ini & peserta sudah hadir
        if ($registration->event->created_by !== Auth::id() || !$registration->is_attended) {
            return back()->with('error', 'Aksi tidak diizinkan.');
        }

        // Gunakan updateOrCreate untuk membuat atau memperbarui sertifikat berdasarkan registration_id
        Certificate::updateOrCreate(
            ['event_registration_id' => $registration->id],
            [
                'certificate_url' => $request->certificate_url,
                'uploaded_by' => Auth::id(),
            ]
        );

        return back()->with('success', 'Sertifikat untuk ' . $registration->user->name . ' berhasil disimpan/diperbarui.');
    }
}
