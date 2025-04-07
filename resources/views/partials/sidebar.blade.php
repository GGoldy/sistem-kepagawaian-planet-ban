<aside class="main-sidebar sidebar-dark-primary elevation-4">
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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Karyawan -->
		@if (Auth::user()->hasRole('admin'))
                <li class="nav-item">
                    <a href="{{ route('karyawans.index') }}" class="nav-link {{ request()->is('karyawans*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Karyawan</p>
                    </a>
                </li>
		@else
		<li class="nav-item">
                    <a href="{{ route('karyawans.profile', ['id' => Auth::user()->karyawan->id]) }}" class="nav-link {{ request()->is('karyawans*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Profil</p>
                    </a>
                </li>
		@endif

                <!-- Absen -->
                <li class="nav-item">
                    <a href="{{ route('absens.index') }}" class="nav-link {{ request()->is('absens*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Absen</p>
                    </a>
                </li>

                <!-- Ketidakhadiran -->
                <li class="nav-item">
                    <a href="{{ route('ketidakhadirans.index') }}" class="nav-link {{ request()->is('ketidakhadirans*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-times"></i>
                        <p>Ketidakhadiran</p>
                    </a>
                </li>

                <!-- Lembur -->
                <li class="nav-item">
                    <a href="{{ route('lemburs.index') }}" class="nav-link {{ request()->is('lemburs*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>Lembur</p>
                    </a>
                </li>

                <!-- Gaji -->
                {{-- <li class="nav-item">
                    <a href="{{ route('gajis.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>Gaji</p>
                    </a>
                </li> --}}
                @if (Auth::user()->hasRole('admin'))
                <li class="nav-item">
                    <a href="{{ route('laporans.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-book-open"></i>
                        <p>Laporan</p>
                    </a>
                </li>
                <!-- Penilaian -->
                <li class="nav-item">
                    <a href="{{ route('penilaians.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Penilaian</p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
