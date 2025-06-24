<!-- Sidebar -->
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
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
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item @if(request()->routeIs('dashboard')) active @endif">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(Auth::user()->hasRole('member'))
                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">Event Saya</h4>
                </li>
                <li class="nav-item @if(request()->is('member/*')) active @endif">
                    <a data-bs-toggle="collapse" href="#memberMenu">
                        <i class="fas fa-calendar-check"></i>
                        <p>Navigasi Member</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse @if(request()->is('member/*')) show @endif" id="memberMenu">
                        <ul class="nav nav-collapse">
                            <li><a href="{{ route('guest.events.index') }}"><span class="sub-item">Cari Event</span></a></li>
                            <li><a href="{{ route('member.registrations.index') }}"><span class="sub-item">Registrasi Saya</span></a></li>
                        </ul>
                    </div>
                </li>
                @endif


                @if(Auth::user()->hasRole('panitia'))
                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">Panitia</h4>
                </li>
                <li class="nav-item @if(request()->is('committee/events*')) active @endif">
                    <a href="{{ route('committee.events.index') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <p>Kelola Event</p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('committee/attendance*')) active @endif">
                    <a href="#"> 
                        <i class="fas fa-qrcode"></i>
                        <p>Scan Kehadiran</p>
                    </a>
                </li>
                @endif


                @if(Auth::user()->hasRole('tim-keuangan'))
                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">Keuangan</h4>
                </li>
                <li class="nav-item @if(request()->is('finance/verifications*')) active @endif">
                    <a href="{{ route('finance.verifications.index') }}">
                        <i class="fas fa-money-check-alt"></i>
                        <p>Verifikasi Pembayaran</p>
                    </a>
                </li>
                @endif


                @if(Auth::user()->hasRole('administrator'))
                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                    <h4 class="text-section">Administrasi</h4>
                </li>
                <li class="nav-item @if(request()->is('admin/users*')) active @endif">
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users-cog"></i>
                        <p>Manajemen Pengguna</p>
                    </a>
                </li>
                <li class="nav-item @if(request()->is('admin/events*')) active @endif">
                    <a href="{{ route('admin.events.index') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <p>Kelola Semua Event</p>
                    </a>
                </li>
                {{-- <li class="nav-item @if(request()->is('admin/roles*')) active @endif">
                     <a href="#">
                        <i class="fas fa-user-tag"></i>
                        <p>Manajemen Peran</p>
                    </a>
                </li> --}}
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
