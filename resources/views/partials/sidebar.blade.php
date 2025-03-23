<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link px-3">
        <span class="brand-text font-weight-light">Panel Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Employee Name -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="{{ route('karyawans.show', [Auth::user()->karyawan->id]) }}" class="d-block">
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

                <!-- Tab 1 -->
                <li class="nav-item">
                    <a href="{{ route('karyawans.index') }}" class="nav-link {{ request()->is('karyawans*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>Karyawan</p>
                    </a>
                </li>

                <!-- Tab 2 -->
                <li class="nav-item">
                    <a href="{{ route('absens.index') }}" class="nav-link {{ request()->is('absens*') || request()->is('lokasikerjas*') ? 'active' : '' }}
">
                        <i class="nav-icon fas fa-clipboard"></i>
                        <p>Absen</p>
                    </a>
                </li>

                <!-- Tab 3 -->
                <li class="nav-item">
                    <a href="{{ route('ketidakhadirans.index') }}" class="nav-link {{ request()->is('ketidakhadirans*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Ketidakhadiran</p>
                    </a>
                </li>

                <!-- Tab 4 -->
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>Lembur</p>
                    </a>
                </li>

                <!-- Tab 5 -->
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Gaji</p>
                    </a>
                </li>

                <!-- Tab 6 -->
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>Penilaian</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
