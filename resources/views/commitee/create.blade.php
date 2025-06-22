@extends('layouts.admin')

@section('title', 'New Event')

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Add New Event</h3>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Event <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="event_date" class="form-label">Tanggal & Waktu Event <span class="text-danger">*</span></label>
            <input type="datetime-local" class="form-control" id="event_date" name="event_date" value="{{ old('event_date') }}" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Lokasi <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}" required>
        </div>

        <div class="mb-3">
            <label for="registration_fee" class="form-label">Biaya Registrasi (Rp) <span class="text-muted">(Isi 0 jika gratis)</span></label>
            <input type="number" class="form-control" id="registration_fee" name="registration_fee" value="{{ old('registration_fee', 0) }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="poster" class="form-label">Poster Event</label>
            <input type="file" class="form-control" id="poster" name="poster" accept="image/*">
            <small class="form-text text-muted">Format: JPG, JPEG, PNG. Maks: 2MB.</small>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi Event</label>
            <textarea class="form-control" id="description" name="description" rows="5">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan Event</button>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
@endsection
