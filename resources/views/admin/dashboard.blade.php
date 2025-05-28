@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Admin Dashboard</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon"><div class="icon-big text-center icon-primary bubble-shadow-small"><i class="fas fa-users"></i></div></div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers"><p class="card-category">Total Pengguna</p><h4 class="card-title">{{ $totalUsers }}</h4></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon"><div class="icon-big text-center icon-info bubble-shadow-small"><i class="fas fa-calendar-alt"></i></div></div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers"><p class="card-category">Total Event</p><h4 class="card-title">{{ $totalEvents }}</h4></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon"><div class="icon-big text-center icon-success bubble-shadow-small"><i class="fas fa-user-check"></i></div></div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers"><p class="card-category">Total Registrasi</p><h4 class="card-title">{{ $totalRegistrations }}</h4></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Tambahkan grafik atau ringkasan lain yang relevan --}}
</div>
@endsection
