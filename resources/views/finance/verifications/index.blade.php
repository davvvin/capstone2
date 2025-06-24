@extends('layouts.admin')
@section('title', 'Verifikasi Pembayaran')
@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div><h3 class="fw-bold mb-3">Verifikasi Pembayaran</h3></div>
    </div>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <div class="card">
        <div class="card-header"><h4 class="card-title">Daftar Registrasi Menunggu Verifikasi</h4></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Member</th>
                            <th>Nama Event</th>
                            <th>Tanggal Registrasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($registrations as $reg)
                        <tr>
                            <td>{{ $reg->user->name }}</td>
                            <td>{{ $reg->event->name }}</td>
                            <td>{{ $reg->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                <a href="{{ route('finance.verifications.show', $reg->id) }}" class="btn btn-sm btn-info">Lihat & Verifikasi</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">Tidak ada pembayaran yang menunggu verifikasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $registrations->links() }}</div>
        </div>
    </div>
</div>
@endsection