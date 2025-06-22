@extends('layouts.app')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-center">
        <div class="card p-4 shadow-sm" style="max-width: 600px; background-color: #fef1f1; border: 2px solid #dcbdbd;">
            <div class="mb-3"><h4 class="fw-bold">Detail Pembayaran</h4></div>

            <div class="row">
                <div class="col-6"><strong>Username</strong></div>
                <div class="col-6">{{ $registration->user->name }}</div>

                <div class="col-6"><strong>Event Name</strong></div>
                <div class="col-6">{{ $registration->event->name }}</div>

                <div class="col-6"><strong>Registration ID</strong></div>
                <div class="col-6">{{ $registration->id }}</div>

                <div class="col-6"><strong>Payment ID</strong></div>
                <div class="col-6">{{ $registration->payment_id ?? '-' }}</div>

                <div class="col-6"><strong>Payment Status</strong></div>
                <div class="col-6">
                    @if ($registration->payment_status == 'verified')
                        <span class="text-success">Successful</span>
                    @elseif ($registration->payment_status == 'pending')
                        <span class="text-warning">Pending</span>
                    @elseif ($registration->payment_status == 'rejected')
                        <span class="text-danger">Rejected</span>
                    @else
                        -
                    @endif
                </div>

                <div class="col-6 mt-3"><strong>QR Absensi</strong></div>
                <div class="col-6 mt-3">
                    @if($registration->registration_code)
                        {!! QrCode::size(100)->generate($registration->registration_code) !!}
                        <p class="mt-2"><small>{{ $registration->registration_code }}</small></p>
                    @else
                        <span>-</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
