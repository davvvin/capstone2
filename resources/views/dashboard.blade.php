@extends('layouts.admin') {{-- Menggunakan master layout Kaiadmin --}}

@section('title', 'Dashboard Aplikasi Event') {{-- Judul spesifik untuk halaman ini --}}

@section('content')
<div class="page-inner">
    {{-- Bagian Header Halaman (Breadcrumbs, Judul Halaman) --}}
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Dashboard</h3>
            {{-- <h6 class="op-7 mb-2">Ringkasan Aplikasi Anda</h6> --}}
        </div>
        <div class="ms-md-auto py-2 py-md-0">
            {{-- Tombol aksi opsional --}}
            {{-- <a href="#" class="btn btn-label-info btn-round me-2">Manage</a> --}}
            {{-- <a href="#" class="btn btn-primary btn-round">Add Customer</a> --}}
        </div>
    </div>

    {{-- Baris untuk Kartu Statistik (Contoh dari template Kaiadmin) --}}
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Pengguna</p>
                                {{-- Ganti dengan data dinamis --}}
                                <h4 class="card-title">{{\App\Models\User::count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Total Event</p>
                                {{-- Ganti dengan data dinamis --}}
                                <h4 class="card-title">{{\App\Models\Event::count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Registrasi Aktif</p>
                                {{-- Ganti dengan data dinamis, misal yang statusnya 'verified' --}}
                                <h4 class="card-title">{{\App\Models\EventRegistration::where('payment_status', 'verified')->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="far fa-money-bill-alt"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Menunggu Verifikasi</p>
                                {{-- Ganti dengan data dinamis --}}
                                <h4 class="card-title">{{\App\Models\EventRegistration::where('payment_status', 'awaiting_verification')->count()}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Konten Dashboard Tambahan --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Selamat Datang di Aplikasi Manajemen Event!</div>
                </div>
                <div class="card-body">
                    <p>Anda telah berhasil login sebagai <strong>{{ Auth::user()->name }}</strong>.</p>
                    <p>Peran Anda saat ini:</p>
                    <ul>
                        @forelse (Auth::user()->roles as $role)
                            <li>{{ $role->name }}</li>
                        @empty
                            <li>Tidak ada peran yang ditetapkan.</li>
                        @endforelse
                    </ul>
                    <p>Gunakan menu navigasi di sebelah kiri untuk mengakses berbagai fitur sesuai dengan peran Anda.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Contoh Chart (jika diperlukan di dashboard) --}}
    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Statistik Pengguna</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 375px">
                        <canvas id="statisticsChart"></canvas>
                    </div>
                    <div id="myChartLegend"></div>
                </div>
            </div>
        </div>
    </div> --}}

</div>
@endsection

@push('scripts')
{{-- Jika ada skrip khusus untuk halaman dashboard --}}
{{-- <script>
    // Contoh inisialisasi chart jika Anda menggunakannya di sini
    // Pastikan jQuery dan Chart.js sudah dimuat di layout utama
    // var statisticsChart = document.getElementById("statisticsChart").getContext("2d");
    // new Chart(statisticsChart, { /* ... konfigurasi chart ... */ });
    console.log('Dashboard page specific script loaded.');
</script> --}}
@endpush
