@extends('layouts.admin')
@section('title', 'Manajemen Sertifikat - ' . $event->name)

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Manajemen Sertifikat: {{ $event->name }}</h3>
            <h6 class="op-7 mb-2">Pilih metode upload (Link atau File) untuk setiap peserta yang hadir.</h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="{{ route('committee.events.show', $event->id) }}" class="btn btn-secondary btn-round">
                <i class="fa fa-arrow-left"></i>
                Kembali ke Detail Event
            </a>
        </div>
    </div>

    @if(session('success')) <div class="alert alert-success" role="alert">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger" role="alert">{{ session('error') }}</div> @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
                            <th style="width: 50%;">Input Sertifikat</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($registrations as $reg)
                        <tr>
                            <form action="{{ route('committee.certificates.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="registration_id" value="{{ $reg->id }}">
                                <td>{{ $reg->user->name }}</td>
                                <td>{{ $reg->user->email }}</td>
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input certificate-type-toggle" type="radio" name="certificate_upload_type" id="type_url_{{ $reg->id }}" value="url" data-reg-id="{{ $reg->id }}" {{ old('certificate_upload_type', $reg->certificate->certificate_type ?? 'url') == 'url' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_url_{{ $reg->id }}">Link</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input certificate-type-toggle" type="radio" name="certificate_upload_type" id="type_file_{{ $reg->id }}" value="file" data-reg-id="{{ $reg->id }}" {{ old('certificate_upload_type', $reg->certificate->certificate_type ?? 'url') == 'file' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="type_file_{{ $reg->id }}">Upload File</label>
                                    </div>

                                    <div class="mt-2 input-url-{{ $reg->id }}" @if(old('certificate_upload_type', $reg->certificate->certificate_type ?? 'url') != 'url') style="display:none;" @endif>
                                        <input type="url" name="certificate_url" class="form-control form-control-sm" placeholder="https://example.com/sertifikat.pdf" value="{{ $reg->certificate && $reg->certificate->certificate_type == 'url' ? $reg->certificate->certificate_url : '' }}">
                                    </div>

                                    <div class="mt-2 input-file-{{ $reg->id }}" @if(old('certificate_upload_type', $reg->certificate->certificate_type ?? 'url') != 'file') style="display:none;" @endif>
                                        <input type="file" name="certificate_file" class="form-control form-control-sm">
                                        @if($reg->certificate && $reg->certificate->certificate_type == 'file')
                                            <small class="form-text text-muted">File saat ini: <a href="{{ asset('storage/' . $reg->certificate->certificate_url) }}" target="_blank">Lihat File</a></small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
                                </td>
                            </form>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">Belum ada peserta yang ditandai hadir.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $registrations->links() }}</div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Event listener untuk semua radio button dengan class 'certificate-type-toggle'
        document.querySelectorAll('.certificate-type-toggle').forEach(function (radio) {
            radio.addEventListener('change', function () {
                const regId = this.dataset.regId;
                const urlInput = document.querySelector('.input-url-' + regId);
                const fileInput = document.querySelector('.input-file-' + regId);

                if (this.value === 'url') {
                    urlInput.style.display = 'block';
                    fileInput.style.display = 'none';
                } else {
                    urlInput.style.display = 'none';
                    fileInput.style.display = 'block';
                }
            });
        });
    });
</script>
@endpush