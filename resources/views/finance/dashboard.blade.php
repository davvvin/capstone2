@extends('layouts.admin')
@section('title', 'Finance Dashboard')
@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div><h3 class="fw-bold mb-3">Finance Dashboard</h3></div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon"><div class="icon-big text-center icon-warning bubble-shadow-small"><i class="fas fa-hourglass-half"></i></div></div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers"><p class="card-category">Menunggu Verifikasi</p><h4 class="card-title">{{ $awaitingVerification }}</h4></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon"><div class="icon-big text-center icon-success bubble-shadow-small"><i class="fas fa-check-double"></i></div></div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers"><p class="card-category">Diverifikasi Hari Ini</p><h4 class="card-title">{{ $verifiedToday }}</h4></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('finance.verifications.index') }}" class="btn btn-primary btn-lg">Lihat Semua Pembayaran yang Menunggu Verifikasi</a>
        </div>
    </div>
</div>
@endsection
