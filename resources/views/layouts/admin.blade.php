<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', config('app.name', 'Laravel') . ' - Admin Panel')</title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport"
    />
    <link
        rel="icon"
        href="{{ asset('admin-template/img/kaiadmin/favicon.ico') }}" {{-- Sesuaikan path jika favicon ada di 'assets/img' atau langsung di 'img' --}}
        type="image/x-icon"
    />

    <script src="{{ asset('admin-template/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('admin-template/css/fonts.min.css') }}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <link rel="stylesheet" href="{{ asset('admin-template/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-template/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-template/css/kaiadmin.min.css') }}" />

    {{-- CSS Demo bisa di-uncomment jika diperlukan untuk styling tertentu, atau dihapus --}}
    {{-- <link rel="stylesheet" href="{{ asset('admin-template/css/demo.css') }}" /> --}}

    @stack('styles') </head>
<body>
    <div class="wrapper">
        {{-- Sidebar akan dimuat dari partials --}}
        @include('layouts.partials.admin-sidebar')

        <div class="main-panel">
            <div class="main-header">
                {{-- Logo di Navbar akan dimuat dari partials --}}
                @include('layouts.partials.admin-navbar-logo')

                {{-- Navbar utama akan dimuat dari partials --}}
                @include('layouts.partials.admin-navbar-main')
            </div>

            <div class="container">
                <div class="page-inner">
                    {{-- Ini adalah tempat konten utama halaman akan dimuat --}}
                    @yield('content')
                </div>
            </div>

            {{-- Footer akan dimuat dari partials --}}
            @include('layouts.partials.admin-footer')
        </div>

        {{-- Bagian Custom Template Settings dari Kaiadmin (opsional, bisa dihapus jika tidak digunakan) --}}
        {{-- Jika Anda ingin menggunakannya, buatkan partial atau biarkan di sini --}}
        {{-- @include('layouts.partials.admin-custom-template-settings') --}}
    </div>

    <script src="{{ asset('admin-template/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin-template/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin-template/js/core/bootstrap.min.js') }}"></script>

    <script src="{{ asset('admin-template/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <script src="{{ asset('admin-template/js/plugin/chart.js/chart.min.js') }}"></script>

    <script src="{{ asset('admin-template/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <script src="{{ asset('admin-template/js/plugin/chart-circle/circles.min.js') }}"></script>

    <script src="{{ asset('admin-template/js/plugin/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('admin-template/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <script src="{{ asset('admin-template/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('admin-template/js/plugin/jsvectormap/world.js') }}"></script>

    <script src="{{ asset('admin-template/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <script src="{{ asset('admin-template/js/kaiadmin.min.js') }}"></script>

    {{-- File JS Demo bisa di-uncomment jika diperlukan atau dihapus --}}
    {{-- <script src="{{ asset('admin-template/js/setting-demo.js') }}"></script> --}}
    {{-- <script src="{{ asset('admin-template/js/demo.js') }}"></script> --}}

    @stack('scripts') </body>
</html>
