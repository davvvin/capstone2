@extends('layouts.admin')

@section('title', 'Daftar Event: ' . $event->name)

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Registrasi Event: {{ $event->name }}</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Formulir Pendaftaran</h4>
                </div>
                <div class="card-body">
                    <p><strong>Nama Event:</strong> {{ $event->name }}</p>
                    <p><strong>Tanggal:</strong> {{ $event->event_date->translatedFormat('l, d F Y, H:i') }} WIB</p>
                    <p><strong>Lokasi:</strong> {{ $event->location }}</p>
                    <p><strong>Biaya Registrasi:</strong>
                        @if($event->registration_fee > 0)
                            Rp {{ number_format($event->registration_fee, 0, ',', '.') }}
                        @else
                            Gratis
                        @endif
                    </p>
                    <hr class="my-3">

                    <form action="{{ route('member.events.register.store', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if($event->registration_fee > 0)
                            <div class="mb-3">
                                <label for="proof_of_payment" class="form-label">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
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
                        @else
                            <p class="text-success">Event ini gratis. Anda akan langsung terdaftar.</p>
                        @endif

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                @if($event->registration_fee > 0)
                                    Daftar dan Upload Bukti
                                @else
                                    Daftar Event Gratis
                                @endif
                            </button>
                            <a href="{{ route('guest.events.show', $event->id) }}" class="btn btn-secondary ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                 <div class="card-header"><h4 class="card-title">Poster Event</h4></div>
                <div class="card-body">
                     @if($event->poster_url)
                        <img src="{{ asset('storage/' . $event->poster_url) }}" alt="Poster {{ $event->name }}" class="img-fluid rounded">
                    @else
                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center rounded">
                            <i class="fas fa-image fa-3x text-gray-500"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
