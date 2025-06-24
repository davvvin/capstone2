@extends('layouts.admin')
@section('title', 'Manajemen Sertifikat - ' . $event->name)

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Manajemen Sertifikat: {{ $event->name }}</h3>
            <h6 class="op-7 mb-2">Upload atau update link sertifikat untuk peserta yang hadir.</h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="{{ route('committee.events.show', $event->id) }}" class="btn btn-secondary btn-round">
                <i class="fa fa-arrow-left"></i>
                Kembali ke Detail Event
            </a>
        </div>
    </div>

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

    <div class="card">
        <div class="card-header"><h4 class="card-title">Daftar Peserta Hadir</h4></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Peserta</th>
                            <th>Email</th>
                            <th>Sertifikat URL</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($registrations as $reg)
                        <tr>
                            <td>{{ $reg->user->name }}</td>
                            <td>{{ $reg->user->email }}</td>
                            <form action="{{ route('committee.certificates.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="registration_id" value="{{ $reg->id }}">
                                <td>
                                    <input type="url" name="certificate_url" class="form-control form-control-sm"
                                           placeholder="https://example.com/sertifikat.pdf"
                                           value="{{ old('certificate_url', $reg->certificate->certificate_url ?? '') }}" required>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-save"></i> Simpan
                                    </button>
                                </td>
                            </form>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada peserta yang ditandai hadir.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $registrations->links() }}</div>
        </div>
    </div>
</div>
@endsection
