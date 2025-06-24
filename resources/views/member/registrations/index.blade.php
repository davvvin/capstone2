@extends('layouts.admin') {{-- Menggunakan layout admin Kaiadmin --}}

@section('title', 'Registrasi Event Saya')

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Registrasi Event Saya</h3>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Event Terdaftar</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Event</th>
                                    <th>Tanggal Event</th>
                                    <th>Status Pembayaran</th>
                                    <th>Kehadiran</th>
                                    <th>QR Code</th>
                                    <th>Sertifikat</th> {{-- KOLOM BARU --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($registrations as $registration)
                                    <tr>
                                        <td>{{ $registration->event->name }}</td>
                                        <td>{{ $registration->event->event_date->translatedFormat('d M Y, H:i') }} WIB</td>
                                        <td>
                                            @if ($registration->payment_status == 'verified')
                                                <span class="badge bg-success text-white">Terverifikasi</span>
                                            @elseif ($registration->payment_status == 'awaiting_verification')
                                                <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                            @elseif ($registration->payment_status == 'pending' && $registration->event->registration_fee > 0)
                                                <span class="badge bg-info text-white">Menunggu Pembayaran</span>
                                            @elseif ($registration->payment_status == 'pending' && $registration->event->registration_fee == 0)
                                                <span class="badge bg-success text-white">Gratis (Terdaftar)</span>
                                            @elseif ($registration->payment_status == 'rejected')
                                                <span class="badge bg-danger text-white">Ditolak</span>
                                                @if($registration->payment_rejection_reason)
                                                <small class="d-block text-muted">Alasan: {{ $registration->payment_rejection_reason }}</small>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($registration->is_attended)
                                                <span class="badge bg-primary text-white">Hadir</span>
                                            @else
                                                <span class="badge bg-secondary text-white">Belum Hadir</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($registration->payment_status == 'verified' && $registration->registration_code)
                                                {!! QrCode::size(80)->generate($registration->registration_code) !!}
                                                <p class="mt-1"><small>Kode: {{ $registration->registration_code }}</small></p>
                                            @elseif ($registration->event->registration_fee == 0 && $registration->registration_code)
                                                {!! QrCode::size(80)->generate($registration->registration_code) !!}
                                                <p class="mt-1"><small>Kode: {{ $registration->registration_code }}</small></p>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        {{-- BAGIAN BARU UNTUK SERTIFIKAT --}}
                                        <td>
                                            @if ($registration->certificate && $registration->certificate->certificate_url)
                                                <a href="{{ $registration->certificate->certificate_url }}" target="_blank" class="btn btn-sm btn-success">
                                                    <i class="fa fa-download"></i> Unduh
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('guest.events.show', $registration->event_id) }}" class="btn btn-sm btn-info">Detail Event</a>
                                            @if ($registration->payment_status == 'rejected')
                                            <a href="{{ route('member.registrations.payment.edit', $registration->id) }}" class="btn btn-sm btn-warning mt-1">Upload Ulang Bukti</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Anda belum mendaftar event apapun.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $registrations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
