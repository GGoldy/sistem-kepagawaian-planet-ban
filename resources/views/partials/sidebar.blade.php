<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Interface
        </div>
        <a class="nav-link" href="{{ route('karyawans.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Karyawan</span>
        </a>
        <a class="nav-link" href="{{ route('absens.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Absen</span>
        </a>
        <a class="nav-link" href="{{ route('ketidakhadirans.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Ketidakhadiran</span>
        </a>
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Lembur</span>
        </a>
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Gaji</span>
        </a>
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Penilaian</span>
        </a>
    </li>
</ul>
