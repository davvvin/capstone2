@extends('layouts.admin')
@section('title', 'Committee Dashboard')
@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div><h3 class="fw-bold mb-3">Dashboard Panitia</h3></div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon"><div class="icon-big text-center icon-primary bubble-shadow-small"><i class="fas fa-calendar-plus"></i></div></div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers"><p class="card-category">Event yang Saya Buat</p><h4 class="card-title">{{ $myEvents }}</h4></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Tambahkan statistik lain yang relevan --}}
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('committee.events.create') }}" class="btn btn-primary btn-lg">Buat Event Baru</a>
        </div>
    </div>
</div>
@endsection