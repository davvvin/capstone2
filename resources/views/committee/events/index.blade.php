@extends('layouts.admin')

@section('title', 'Kelola Event Saya')

@section('content')
<div class="page-inner">
    {{-- Page Header --}}
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Kelola Event Saya</h3>
            <h6 class="op-7 mb-2">Buat, edit, dan kelola semua event yang Anda selenggarakan.</h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="{{ route('committee.events.create') }}" class="btn btn-primary btn-round">
                <i class="fa fa-plus"></i>
                Buat Event Baru
            </a>
        </div>
    </div>

    {{-- Session Flash Messages --}}
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif

    {{-- Events Table Card --}}
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Event yang Saya Buat</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Event</th>
                            <th>Tanggal & Waktu</th>
                            <th>Lokasi</th>
                            <th>Biaya (Rp)</th>
                            <th>Peserta</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $event)
                        <tr>
                            <td>{{ $event->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->event_date)->translatedFormat('d M Y, H:i') }}</td>
                            <td>{{ $event->location }}</td>
                            <td>{{ number_format($event->registration_fee, 0, ',', '.') }}</td>
                            <td>
                                {{-- Hitung peserta yang sudah diverifikasi --}}
                                @php
                                    $verifiedCount = $event->registrations()->where('payment_status', 'verified')->count();
                                @endphp
                                {{ $verifiedCount }}
                                @if($event->max_participants)
                                    / {{ $event->max_participants }}
                                @endif
                            </td>                           
                            <td>
                                <a href="{{ route('committee.events.show', $event->id) }}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-users"></i> Peserta
                                </a>
                                <a href="{{ route('committee.attendance.scan', $event->id) }}" class="btn btn-xs btn-secondary"> {{-- TOMBOL BARU --}}
                                    <i class="fa fa-qrcode"></i> Scan
                                </a>
                                <a href="{{ route('committee.events.edit', $event->id) }}" class="btn btn-xs btn-warning">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('committee.events.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini? Semua data registrasi terkait akan hilang.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Anda belum membuat event apapun. Klik "Buat Event Baru" untuk memulai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination Links --}}
            <div class="mt-4">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
