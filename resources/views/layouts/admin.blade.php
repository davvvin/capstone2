<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', 'Event Management App') - Kaiadmin</title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport"
    />
    <link
        rel="icon"
        href="{{ asset('admin-template/assets/img/kaiadmin/favicon.ico') }}"
        type="image/x-icon"
    />

    <script src="{{ asset('admin-template/assets/js/plugin/webfont/webfont.min.js') }}"></script>
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
                urls: ["{{ asset('admin-template/assets/css/fonts.min.css') }}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <link rel="stylesheet" href="{{ asset('admin-template/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-template/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin-template/assets/css/kaiadmin.min.css') }}" />

    {{-- <link rel="stylesheet" href="{{ asset('admin-template/assets/css/demo.css') }}" /> --}}

    @stack('styles') </head>
<body>
    <div class="wrapper">
        @include('layouts.partials.admin-sidebar')
        <div class="main-panel">
            <div class="main-header">
                @include('layouts.partials.admin-navbar-logo')
                @include('layouts.partials.admin-navbar-main')
                </div>

            <div class="container">
                <div class="page-inner">
                    @yield('content')
                </div>
            </div>

            @include('layouts.partials.admin-footer')
        </div>

        {{-- @include('layouts.partials.admin-custom-template-settings') --}}
        </div>
    <script src="{{ asset('admin-template/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin-template/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin-template/assets/js/core/bootstrap.min.js') }}"></script>

    <script src="{{ asset('admin-template/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <script src="{{ asset('admin-template/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    <script src="{{ asset('admin-template/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    <script src="{{ asset('admin-template/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    <script src="{{ asset('admin-template/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    <script src="{{ asset('admin-template/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <script src="{{ asset('admin-template/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('admin-template/assets/js/plugin/jsvectormap/world.js') }}"></script>

    <script src="{{ asset('admin-template/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <script src="{{ asset('admin-template/assets/js/kaiadmin.min.js') }}"></script>

    {{-- <script src="{{ asset('admin-template/assets/js/setting-demo.js') }}"></script> --}}
    {{-- <script src="{{ asset('admin-template/assets/js/demo.js') }}"></script> --}}

    {{-- Example Sparkline (remove or move to specific pages if not needed globally) --}}
    {{-- <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });
    </script> --}}
    @stack('scripts') </body>
</html>
