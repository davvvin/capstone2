@extends('layouts.admin')
@section('title', 'Scan Kehadiran - ' . $event->name)

@push('styles')
<style>
    #qr-reader {
        width: 100%;
        max-width: 500px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
    }
    #qr-reader__scan_region {
        background: #f1f5f9;
    }
    #scan-result {
        font-size: 1.1rem;
        font-weight: 500;
    }
    .result-success { color: #16a34a; }
    .result-error { color: #dc2626; }
</style>
@endpush

@section('content')
<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Scan Kehadiran: {{ $event->name }}</h3>
            <h6 class="op-7 mb-2">Arahkan kamera ke QR Code peserta untuk mencatat kehadiran.</h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            <a href="{{ route('committee.events.show', $event->id) }}" class="btn btn-secondary btn-round">
                <i class="fa fa-users"></i>
                Lihat Daftar Peserta
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <div id="qr-reader" class="mx-auto"></div>
                    <div id="scan-result" class="mt-4 p-3 rounded-3" style="min-height: 50px;">
                        Menunggu QR Code...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Library untuk QR Code Scanner --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const resultElement = document.getElementById('scan-result');
        let lastScannedCode = null;
        let canScan = true;

        function onScanSuccess(decodedText, decodedResult) {
            if (!canScan || decodedText === lastScannedCode) {
                // Mencegah scan berulang kali dalam waktu singkat
                return;
            }

            canScan = false; // Nonaktifkan scan sementara
            lastScannedCode = decodedText; // Simpan kode yang baru di-scan

            resultElement.textContent = `Processing: ${decodedText}...`;
            resultElement.className = 'mt-4 p-3 rounded-3';

            // Kirim data ke backend
            fetch("{{ route('committee.attendance.mark') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    registration_code: decodedText,
                    event_id: {{ $event->id }}
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resultElement.textContent = data.message;
                    resultElement.classList.add('result-success', 'bg-success-light');
                } else {
                    resultElement.textContent = `Error: ${data.message}`;
                    resultElement.classList.add('result-error', 'bg-danger-light');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultElement.textContent = 'Terjadi error saat menghubungi server.';
                resultElement.classList.add('result-error', 'bg-danger-light');
            })
            .finally(() => {
                // Aktifkan kembali scan setelah beberapa saat
                setTimeout(() => {
                    canScan = true;
                    lastScannedCode = null; // Reset kode terakhir
                    resultElement.textContent = 'Siap untuk scan berikutnya...';
                    resultElement.className = 'mt-4 p-3 rounded-3';
                }, 3000); // Jeda 3 detik
            });
        }

        function onScanFailure(error) {
            // Biarkan saja, tidak perlu menampilkan error "QR code not found" terus-menerus
        }

        // Inisialisasi scanner
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader",
            { fps: 10, qrbox: { width: 250, height: 250 } },
            /* verbose= */ false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    });
</script>
@endpush
