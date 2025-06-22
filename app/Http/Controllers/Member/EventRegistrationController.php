<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Untuk upload file
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Jika Anda akan generate QR code di controller

class EventRegistrationController extends Controller
{
    /**
     * Menampilkan form konfirmasi pendaftaran dan upload bukti bayar.
     */
    public function create(Event $event)
    {
        // Cek apakah user sudah terdaftar di event ini
        $isRegistered = Auth::user()->eventRegistrations()->where('event_id', $event->id)->exists();
        if ($isRegistered) {
            return redirect()->route('member.registrations.index')->with('warning', 'Anda sudah terdaftar pada event ini.');
        }

        // Cek apakah kuota masih tersedia (jika ada max_participants)
        if ($event->max_participants) {
            $registeredCount = $event->registrations()->where('payment_status', 'verified')->count(); // Hitung yang sudah verified
            if ($registeredCount >= $event->max_participants) {
                return redirect()->route('guest.events.show', $event)->with('error', 'Maaf, kuota untuk event ini sudah penuh.');
            }
        }

        return view('member.registrations.create', compact('event'));
    }

    /**
     * Menyimpan data pendaftaran event dan bukti pembayaran.
     */
    public function store(Request $request, Event $event)
    {
        $user = Auth::user();

        // Cek lagi apakah user sudah terdaftar
        if ($user->eventRegistrations()->where('event_id', $event->id)->exists()) {
            return redirect()->route('member.registrations.index')->with('warning', 'Anda sudah terdaftar pada event ini.');
        }

        // Cek kuota lagi sebelum menyimpan
        if ($event->max_participants) {
            $registeredCount = $event->registrations()->where('payment_status', 'verified')->count();
            if ($registeredCount >= $event->max_participants && $event->registration_fee > 0) { // Hanya cek kuota jika berbayar, untuk gratis mungkin beda aturan
                return redirect()->route('guest.events.show', $event)->with('error', 'Maaf, kuota untuk event ini sudah penuh saat Anda mencoba mendaftar.');
            }
        }

        $request->validate([
            'proof_of_payment' => $event->registration_fee > 0 ? 'required|image|mimes:jpg,jpeg,png|max:2048' : 'nullable', // Wajib jika event berbayar
        ]);

        $proofPath = null;
        if ($request->hasFile('proof_of_payment') && $event->registration_fee > 0) {
            $proofPath = $request->file('proof_of_payment')->store('payment_proofs', 'public');
        }

        EventRegistration::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'payment_status' => $event->registration_fee > 0 ? 'awaiting_verification' : 'verified', // Langsung verified jika gratis
            'proof_of_payment_url' => $proofPath,
            // registration_code dan qr_code_url akan diisi setelah pembayaran diverifikasi (jika berbayar)
            // atau langsung jika gratis
            'registration_code' => $event->registration_fee == 0 ? strtoupper(uniqid('EVREG-')) : null,
        ]);

        return redirect()->route('member.registrations.index')->with('success', 'Berhasil mendaftar event! Silakan tunggu konfirmasi pembayaran jika event berbayar.');
    }

    /**
     * Menampilkan daftar event yang sudah didaftari member beserta statusnya.
     * Ini bisa digabungkan dengan MyEventController atau dipisah. Untuk contoh ini, kita pisah.
     */
    public function myRegistrations()
    {
        $user = Auth::user();
        $registrations = $user->eventRegistrations()->with('event')->latest()->paginate(10);
        return view('member.registrations.index', compact('registrations'));
    }

    /**
     * Menampilkan form untuk upload ulang bukti bayar jika ditolak.
     */
    public function editPayment(EventRegistration $registration)
    {
        // Pastikan registrasi ini milik user yang login dan statusnya 'rejected'
        if ($registration->user_id !== Auth::id() || $registration->payment_status !== 'rejected') {
            abort(403, 'Aksi tidak diizinkan.');
        }
        $event = $registration->event;
        return view('member.registrations.edit_payment', compact('registration', 'event'));
    }

    /**
     * Mengupdate bukti pembayaran.
     */
    public function updatePayment(Request $request, EventRegistration $registration)
    {
        if ($registration->user_id !== Auth::id() || $registration->payment_status !== 'rejected') {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $request->validate([
            'proof_of_payment' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Hapus bukti lama jika ada
        if ($registration->proof_of_payment_url) {
            Storage::disk('public')->delete($registration->proof_of_payment_url);
        }

        $proofPath = $request->file('proof_of_payment')->store('payment_proofs', 'public');

        $registration->update([
            'proof_of_payment_url' => $proofPath,
            'payment_status' => 'awaiting_verification',
            'payment_rejection_reason' => null, // Hapus alasan penolakan sebelumnya
        ]);

        return redirect()->route('member.registrations.index')->with('success', 'Bukti pembayaran berhasil diupdate. Silakan tunggu verifikasi.');
    }

    public function showUploadCertificate($id)
    {
        $registration = Registration::with('event', 'user')->findOrFail($id);
        return view('admin.registrations.upload_certificate', compact('registration'));
    }

    public function storeCertificate(Request $request, $id)
    {
        $request->validate([
            'certificate_file' => 'required|file|mimes:pdf|max:2048',
        ]);

        $registration = Registration::findOrFail($id);

        // Store the uploaded file
        if ($request->hasFile('certificate_file')) {
            $path = $request->file('certificate_file')->store('certificates', 'public');
            $registration->certificate_url = $path;
            $registration->save();
        }

        return redirect()->back()->with('success', 'Sertifikat berhasil diunggah.');
    }

    public function paymentDetail($id)
    {
        $registration = Registration::with('event', 'user')->findOrFail($id);

        // Optional: check if the authenticated user is allowed to view it
        if (auth()->id() !== $registration->user_id) {
            abort(403, 'Unauthorized');
        }

        return view('member.registration.payment-detail', compact('registration'));
    }
}
