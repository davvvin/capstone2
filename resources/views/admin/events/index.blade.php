@extends('layouts.admin')
@section('title', 'Kelola Semua Event')

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Kelola Semua Event</h3>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Semua Event</h4>
        </div>
        <div class="card-body">
            <p>Halaman untuk mengelola semua event akan ditampilkan di sini.</p>
            {{-- Tabel event akan ditambahkan nanti --}}
        </div>
    </div>
</div>
@endsection