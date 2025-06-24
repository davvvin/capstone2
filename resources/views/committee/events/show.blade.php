@extends('layouts.admin')
@section('title', 'Detail Event: ' . $event->name)

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Detail Event & Daftar Peserta</h3>
            <h4 class="fw-light">{{ $event->name }}</h4>
        </div>
         <div class="ms-md-auto py-2 py-md-0">
            <a href="{{ route('committee.certificates.indexForEvent', $event->id) }}" class="btn btn-primary btn-round me-2">
                <i class="fa fa-award"></i> Kelola Sertifikat
            </a>
            <a href="{{ route('committee.events.index') }}" class="btn btn-secondary btn-round">
                <i class="fa fa-arrow-left"></i>
                Kembali ke Daftar Event
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Detail Event --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h4 class="card-title">Informasi Event</h4></div>
                <div class="card-body">
                    @if($event->poster_url)
                        <img src="{{ asset('storage/' . $event->poster_url) }}" alt="Poster" class="img-fluid rounded mb-3">
                    @endif
                    <p><strong>Tanggal:</strong><br>{{ $event->event_date->translatedFormat('l, d F Y, H:i') }} WIB</p>
                    <p><strong>Lokasi:</strong><br>{{ $event->location }}</p>
                    <p><strong>Narasumber:</strong><br>{{ $event->speaker ?? '-' }}</p>
                    <p><strong>Biaya:</strong><br>Rp {{ number_format($event->registration_fee, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Daftar Peserta --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h4 class="card-title">Daftar Peserta</h4></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Peserta</th>
                                    <th>Email</th>
                                    <th>Status Pembayaran</th>
                                    <th>Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($registrations as $reg)
                                <tr>
                                    <td>{{ $reg->user->name }}</td>
                                    <td>{{ $reg->user->email }}</td>
                                    <td>
                                        @if ($reg->payment_status == 'verified')
                                            <span class="badge bg-success text-white">Terverifikasi</span>
                                        @elseif ($reg->payment_status == 'awaiting_verification')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif ($reg->payment_status == 'rejected')
                                            <span class="badge bg-danger text-white">Ditolak</span>
                                        @else
                                            <span class="badge bg-secondary text-white">{{ ucfirst($reg->payment_status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                         @if ($reg->is_attended)
                                            <span class="badge bg-primary text-white">Hadir</span>
                                        @else
                                            <span class="badge bg-secondary text-white">Belum Hadir</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center">Belum ada peserta yang mendaftar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-3">{{ $registrations->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
