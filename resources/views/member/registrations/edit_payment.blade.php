@extends('layouts.admin')

@section('title', 'Upload Ulang Bukti Pembayaran: ' . $registration->event->name)

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Upload Ulang Bukti Pembayaran</h3>
            <h4 class="fw-light">{{ $registration->event->name }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Formulir Upload Ulang</h4>
                </div>
                <div class="card-body">
                    @if($registration->payment_rejection_reason)
                    <div class="alert alert-danger">
                        <strong>Pembayaran Ditolak!</strong><br>
                        Alasan: {{ $registration->payment_rejection_reason }}
                    </div>
                    @endif

                    <p><strong>Nama Event:</strong> {{ $registration->event->name }}</p>
                    <p><strong>Biaya Registrasi:</strong> Rp {{ number_format($registration->event->registration_fee, 0, ',', '.') }}</p>
                    <hr class="my-3">

                    <form action="{{ route('member.registrations.payment.update', $registration->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="proof_of_payment" class="form-label">Upload Bukti Pembayaran Baru <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('proof_of_payment') is-invalid @enderror" id="proof_of_payment" name="proof_of_payment" required>
                            @error('proof_of_payment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maks: 2MB.</small>
                             <p class="mt-2">Silakan lakukan pembayaran ke: <br>
                                <strong>Nomor Rekening:</strong> [NOMOR_REKENING_ANDA] (Bank XYZ)<br>
                                <strong>Atas Nama:</strong> [NAMA_PEMILIK_REKENING]
                            </p>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Bukti Pembayaran</button>
                            <a href="{{ route('member.registrations.index') }}" class="btn btn-secondary ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
