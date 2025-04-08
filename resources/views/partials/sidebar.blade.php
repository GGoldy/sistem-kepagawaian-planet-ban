{{-- <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <i class="nav-icon fas fa-home"></i>
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="info">
                <a href="{{ route('karyawans.profile', [Auth::user()->karyawan->id]) }}" class="d-block">
                    <i class="nav-icon fas fa-user-circle"></i>
                    {{ Auth::user()->karyawan->nama ?? 'Guest' }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Karyawan -->
                @if (Auth::user()->hasRole('admin'))
                    <li class="nav-item">
                        <a href="{{ route('karyawans.index') }}"
                            class="nav-link {{ request()->is('karyawans*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Karyawan</p>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('karyawans.profile', ['id' => Auth::user()->karyawan->id]) }}"
                            class="nav-link {{ request()->is('karyawans*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Profil</p>
                        </a>
                    </li>
                @endif

                <!-- Absen -->
                <li class="nav-item">
                    <a href="{{ route('absens.index') }}"
                        class="nav-link {{ request()->is('absens*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Absen</p>
                    </a>
                </li>

                <!-- Ketidakhadiran -->
                <li class="nav-item">
                    <a href="{{ route('ketidakhadirans.index') }}"
                        class="nav-link {{ request()->is('ketidakhadirans*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-times"></i>
                        <p>Ketidakhadiran</p>
                    </a>
                </li>

                <!-- Lembur -->
                <li class="nav-item">
                    <a href="{{ route('lemburs.index') }}"
                        class="nav-link {{ request()->is('lemburs*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>Lembur</p>
                    </a>
                </li>
                @if (Auth::user()->hasRole('admin'))
                    <li class="nav-item">
                        <a href="{{ route('laporans.index') }}" class="nav-link {{ request()->is('laporans*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book-open"></i>
                            <p>Laporan</p>
                        </a>
                    </li>
                    <!-- Penilaian -->
                    <li class="nav-item">
                        <a href="{{ route('penilaians.index') }}" class="nav-link {{ request()->is('penilaians*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Penilaian</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside> --}}

<nav id="sidebar" class="sidebar bg-dark text-white">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <i class="nav-icon fas fa-home"></i>
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>
    <hr class="dropdown-divider">
    <div class="user-panel mt-3 mb-3 d-flex align-items-center">
        <div class="info">
            <a href="{{ route('karyawans.profile', [Auth::user()->karyawan->id]) }}" class="d-block">
                <i class="nav-icon fas fa-user-circle"></i>
                {{ Auth::user()->karyawan->nama ?? 'Guest' }}
            </a>
        </div>
    </div>
    <hr class="dropdown-divider">
    <ul class="nav flex-column pt-3">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a>
        </li>
        @if (Auth::user()->hasRole('admin'))
            <li class="nav-item">
                <a class="nav-link {{ request()->is('karyawans*') ? 'active' : '' }}" href="{{ route('karyawans.index') }}"><i class="nav-icon fas fa-users"></i> Karyawan</a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link {{ request()->is('karyawans*') ? 'active' : '' }}" href="{{ route('karyawans.profile', ['id' => Auth::user()->karyawan->id]) }}"><i class="nav-icon fas fa-users"></i> Profil</a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link {{ request()->is('absens*') ? 'active' : '' }}" href="{{ route('absens.index') }}"><i class="nav-icon fas fa-clipboard-list"></i> Absen</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('ketidakhadirans*') ? 'active' : '' }}" href="{{ route('ketidakhadirans.index') }}"><i class="nav-icon fas fa-user-times"></i> Ketidakhadiran</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('lemburs*') ? 'active' : '' }}" href="{{ route('lemburs.index') }}"><i class="nav-icon fas fa-clock"></i> Lembur</a>
        </li>
        @if (Auth::user()->hasRole('admin'))
        <li class="nav-item">
            <a class="nav-link {{ request()->is('laporans*') ? 'active' : '' }}" href="{{ route('laporans.index') }}"><i class="nav-icon fas fa-book-open"></i> Laporan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('penilaians*') ? 'active' : '' }}" href="{{ route('penilaians.index') }}"><i class="nav-icon fas fa-chart-line"></i> Penilaian</a>
        </li>
        @endif
    </ul>
</nav>
