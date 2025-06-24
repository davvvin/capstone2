@extends('layouts.admin')
@section('title', 'Detail Verifikasi Pembayaran')
@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div><h3 class="fw-bold mb-3">Detail Verifikasi</h3></div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header"><h4 class="card-title">Informasi Registrasi</h4></div>
                <div class="card-body">
                    <p><strong>Nama Member:</strong> {{ $registration->user->name }}</p>
                    <p><strong>Email Member:</strong> {{ $registration->user->email }}</p>
                    <hr>
                    <p><strong>Nama Event:</strong> {{ $registration->event->name }}</p>
                    <p><strong>Biaya Event:</strong> Rp {{ number_format($registration->event->registration_fee, 0, ',', '.') }}</p>
                    <p><strong>Tanggal Registrasi:</strong> {{ $registration->created_at->translatedFormat('l, d F Y, H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header"><h4 class="card-title">Bukti Pembayaran</h4></div>
                <div class="card-body">
                    @if($registration->proof_of_payment_url)
                        <a href="{{ asset('storage/' . $registration->proof_of_payment_url) }}" target="_blank">
                            <img src="{{ asset('storage/' . $registration->proof_of_payment_url) }}" alt="Bukti Pembayaran" class="img-fluid rounded">
                        </a>
                        <a href="{{ asset('storage/' . $registration->proof_of_payment_url) }}" target="_blank" class="btn btn-secondary btn-sm mt-2">Lihat Ukuran Penuh</a>
                    @else
                        <p class="text-danger">Bukti pembayaran tidak ditemukan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h4 class="card-title">Aksi Verifikasi</h4></div>
                <div class="card-body">
                    <div class="d-flex justify-content-start">
                        {{-- Tombol Approve --}}
                        <form action="{{ route('finance.verifications.approve', $registration->id) }}" method="POST" class="me-2" onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI pembayaran ini?');">
                            @csrf
                            <button type="submit" class="btn btn-success">Setujui Pembayaran</button>
                        </form>

                        {{-- Tombol dan Modal Tolak --}}
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            Tolak Pembayaran
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tolak Pembayaran -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('finance.verifications.reject', $registration->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Tolak Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda akan menolak pembayaran dari <strong>{{ $registration->user->name }}</strong> untuk event <strong>{{ $registration->event->name }}</strong>.</p>
                        <div class="mb-3">
                            <label for="rejection_reason" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required>{{ old('rejection_reason') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Tolak Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
