@extends('layouts.admin')

@section('title', 'Upload Sertifikat')

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Upload Sertifikat untuk: {{ $registration->user->name }}</h3>
            <p><strong>Event:</strong> {{ $registration->event->name }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('certificate.store', $registration->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="certificate_file" class="form-label">Upload File Sertifikat (PDF)</label>
            <input type="file" class="form-control @error('certificate_file') is-invalid @enderror" id="certificate_file" name="certificate_file" accept="application/pdf" required>
            @error('certificate_file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Upload Sertifikat</button>
        <a href="{{ route('admin.registrations.index') }}" class="btn btn-secondary ms-2">Kembali</a>
    </form>
</div>
@endsection
