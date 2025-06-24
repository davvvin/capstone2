@extends('layouts.admin')
@section('title', 'Buat Event Baru')

@push('styles')
{{-- Tambahkan CSS untuk datepicker jika perlu --}}
@endpush

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div><h3 class="fw-bold mb-3">Buat Event Baru</h3></div>
    </div>
    <div class="card">
        <div class="card-header"><h4 class="card-title">Formulir Event</h4></div>
        <div class="card-body">
            <form action="{{ route('committee.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Event <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                         <div class="mb-3">
                            <label for="poster" class="form-label">Poster Event</label>
                            <input type="file" class="form-control @error('poster') is-invalid @enderror" id="poster" name="poster" accept="image/*">
                            <small class="form-text text-muted">Maksimal 2MB. Format: JPG, PNG.</small>
                            @error('poster') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="event_date" class="form-label">Tanggal & Waktu Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('event_date') is-invalid @enderror" id="event_date" name="event_date" value="{{ old('event_date') }}" required>
                        @error('event_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="location" class="form-label">Lokasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required>
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                     <div class="col-md-4 mb-3">
                        <label for="speaker" class="form-label">Narasumber</label>
                        <input type="text" class="form-control @error('speaker') is-invalid @enderror" id="speaker" name="speaker" value="{{ old('speaker') }}">
                         @error('speaker') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="row">
                     <div class="col-md-6 mb-3">
                        <label for="registration_fee" class="form-label">Biaya Registrasi (Rp) <span class="text-danger">*</span></label>
                         <input type="number" class="form-control @error('registration_fee') is-invalid @enderror" id="registration_fee" name="registration_fee" value="{{ old('registration_fee', 0) }}" required min="0" step="1000">
                         <small class="form-text text-muted">Isi 0 jika gratis.</small>
                         @error('registration_fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                     <div class="col-md-6 mb-3">
                        <label for="max_participants" class="form-label">Maksimal Peserta</label>
                         <input type="number" class="form-control @error('max_participants') is-invalid @enderror" id="max_participants" name="max_participants" value="{{ old('max_participants') }}" min="1">
                         <small class="form-text text-muted">Kosongkan jika tidak ada batas.</small>
                         @error('max_participants') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Simpan Event</button>
                <a href="{{ route('committee.events.index') }}" class="btn btn-secondary mt-3">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection