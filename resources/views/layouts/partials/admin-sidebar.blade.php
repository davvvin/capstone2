<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ url('/') }}" class="logo"> {{-- Consider using named route like route('dashboard') or route('home') --}}
                <img
                    src="{{ asset('admin-template/img/kaiadmin/logo_light.svg') }}"
                    alt="navbar brand"
                    class="navbar-brand"
                    height="20"
                />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item @if(request()->routeIs('dashboard')) active @endif"> {{-- Example active state based on route name --}}
                    <a href="{{ route('dashboard') }}"> {{-- Assuming you have a route named 'dashboard' --}}
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                {{-- <li class="nav-item active"> --}}
                {{--    <a
                        data-bs-toggle="collapse"
                        href="#dashboard"
                        class="collapsed"
                        aria-expanded="false"
                    > --}}
                {{--        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        <span class="caret"></span> --}}
                {{--    </a> --}}
                {{--    <div class="collapse" id="dashboard">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="../demo1/index.html"> {{-- Update this link --}}
                                    <span class="sub-item">Dashboard 1</span>
                                </a>
                            </li>
                        </ul>
                    </div> --}}
                {{-- </li> --}}

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Manajemen Event</h4>
                </li>

                @if(Auth::check() && (Auth::user()->hasRole('administrator') || Auth::user()->hasRole('panitia')))
                <li class="nav-item @if(request()->is('committee/events*') || request()->is('admin/events*')) active @endif">
                    <a href="{{ Auth::user()->hasRole('administrator') ? route('admin.events.index') : route('committee.events.index') }}"> {{-- Adjust route names as needed --}}
                        <i class="fas fa-calendar-alt"></i>
                        <p>Kelola Event</p>
                    </a>
                </li>
                @endif

                @if(Auth::check() && Auth::user()->hasRole('member'))
                <li class="nav-item @if(request()->is('member/events*') || request()->is('my-registrations*')) active @endif">
                    <a data-bs-toggle="collapse" href="#memberEvents" class="@if(request()->is('member/events*') || request()->is('my-registrations*')) '' @else collapsed @endif" aria-expanded="@if(request()->is('member/events*') || request()->is('my-registrations*')) true @else false @endif">
                        <i class="fas fa-calendar-check"></i>
                        <p>Event Saya</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if(request()->is('member/events*') || request()->is('my-registrations*')) show @endif" id="memberEvents">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('guest.events.index') }}"> {{-- Route to browse events --}}
                                    <span class="sub-item">Cari Event</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('member.registrations.index') }}"> {{-- Route to member's registered events --}}
                                    <span class="sub-item">Registrasi Saya</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif


                @if(Auth::check() && Auth::user()->hasRole('tim-keuangan'))
                <li class="nav-item @if(request()->is('finance/verifications*')) active @endif">
                    <a href="{{ route('finance.verifications.index') }}"> {{-- Adjust route name --}}
                        <i class="fas fa-money-check-alt"></i>
                        <p>Verifikasi Pembayaran</p>
                    </a>
                </li>
                @endif

                @if(Auth::check() && Auth::user()->hasRole('panitia'))
                 <li class="nav-item @if(request()->is('committee/attendance*')) active @endif">
                    <a href="#"> {{-- Add route for attendance scan page, e.g. for a specific event or a general scan page --}}
                        <i class="fas fa-qrcode"></i>
                        <p>Scan Kehadiran</p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('committee/certificates*')) active @endif">
                    <a href="#"> {{-- Add route for certificate management --}}
                        <i class="fas fa-award"></i>
                        <p>Upload Sertifikat</p>
                    </a>
                </li>
                @endif


                @if(Auth::check() && Auth::user()->hasRole('administrator'))
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Administrasi</h4>
                </li>
                <li class="nav-item @if(request()->is('admin/users*')) active @endif">
                    <a href="{{ route('admin.users.index') }}"> {{-- Adjust route name --}}
                        <i class="fas fa-users-cog"></i>
                        <p>Manajemen Pengguna</p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('admin/roles*')) active @endif">
                     <a href="#"> {{-- Add route for role management if needed --}}
                        <i class="fas fa-user-tag"></i>
                        <p>Manajemen Peran</p>
                    </a>
                </li>
                @endif

                {{-- Example of original menu items (remove or adapt as needed) --}}
                {{-- <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#base">
                        <i class="fas fa-layer-group"></i>
                        <p>Base</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li><a href="#"><span class="sub-item">Avatars</span></a></li>
                            <li><a href="#"><span class="sub-item">Buttons</span></a></li>
                        </ul>
                    </div>
                </li> --}}
                {{-- Add more application-specific menu items here based on roles --}}
            </ul>
        </div>
    </div>
</div>
