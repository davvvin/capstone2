<?php

namespace App\Http\Controllers\Committee;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Import Storage facade

class CertificateController extends Controller
{
    public function indexForEvent(Event $event)
    {
        // ... (logika indexForEvent tetap sama)
        if ($event->created_by !== Auth::id()) {
            abort(403);
        }
        $registrations = $event->registrations()
                                ->with(['user', 'certificate'])
                                ->where('is_attended', true)
                                ->paginate(15);
        return view('committee.certificates.index', compact('event', 'registrations'));
    }

    public function store(Request $request)
    {
        $registration = EventRegistration::findOrFail($request->registration_id);

        // Validasi: pastikan panitia berwenang dan peserta hadir
        if ($registration->event->created_by !== Auth::id() || !$registration->is_attended) {
            return back()->with('error', 'Aksi tidak diizinkan.');
        }

        // Validasi input berdasarkan tipe upload
        $request->validate([
            'registration_id' => 'required|exists:event_registrations,id',
            'certificate_upload_type' => 'required|in:url,file',
            'certificate_url' => 'required_if:certificate_upload_type,url|nullable|url|max:255',
            'certificate_file' => 'required_if:certificate_upload_type,file|nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $certificateUrlPath = null;
        $certificateType = $request->certificate_upload_type;

        // Handle jika tipe upload adalah file
        if ($certificateType === 'file' && $request->hasFile('certificate_file')) {
            // Cari sertifikat lama untuk dihapus filenya jika ada
            $existingCertificate = Certificate::where('event_registration_id', $registration->id)->first();
            if ($existingCertificate && $existingCertificate->certificate_type === 'file' && $existingCertificate->certificate_url) {
                Storage::disk('public')->delete($existingCertificate->certificate_url);
            }
            // Simpan file baru dan dapatkan pathnya
            $certificateUrlPath = $request->file('certificate_file')->store('certificates', 'public');
        } 
        // Handle jika tipe upload adalah URL
        elseif ($certificateType === 'url') {
            $certificateUrlPath = $request->certificate_url;
        }

        // Simpan atau update data sertifikat jika ada data baru
        if ($certificateUrlPath) {
            Certificate::updateOrCreate(
                ['event_registration_id' => $registration->id],
                [
                    'certificate_url' => $certificateUrlPath,
                    'certificate_type' => $certificateType,
                    'uploaded_by' => Auth::id(),
                ]
            );
            return back()->with('success', 'Sertifikat untuk ' . $registration->user->name . ' berhasil disimpan/diperbarui.');
        }

        return back()->with('error', 'Tidak ada link atau file yang diberikan.');
    }
}
