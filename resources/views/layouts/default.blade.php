<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }

        #main-content {
            transition: margin-left 0.3s ease;
        }

        @media (min-width: 768px) {
            .sidebar {
                display: block;
                width: 250px;
                position: fixed;
                left: 0;
                top: 56px;
                /* height of navbar */
                bottom: 0;
                z-index: 100;
                overflow-y: auto;
            }

            #main-content {
                margin-left: 250px;
            }

            .sidebar.hidden {
                display: block;
                margin-left: -250px;
            }

            #main-content.sidebar-hidden {
                margin-left: 0;
            }
        }

        .select2-container--default .select2-selection--single {
            height: 38px !important;
            padding: 0.375rem 0.75rem !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5 !important;
            padding-left: 0 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }

        .select2-dropdown {
            z-index: 9999;
        }

        #roles.select2-hidden-accessible+.select2-container--default .select2-selection--multiple {
            min-height: 38px;
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
        }

        #roles.select2-hidden-accessible+.select2-container--default .select2-selection--multiple .select2-selection__rendered {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        #roles.select2-hidden-accessible+.select2-container--default .select2-selection--multiple .select2-search__field {
            margin-top: 4px;
            margin-bottom: 4px;
        }

        .small-box {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            min-height: 120px;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .sidebar.hidden {
            display: none;
        }

        .sidebar a {
            color: white !important;
        }

        .sidebar a:hover {
            color: #ccc !important;
        }

        .sidebar .nav-link.active {
            background-color: #ffffff;
            /* Bootstrap's primary color */
            color: rgb(0, 0, 0) !important;
            font-weight: bold;
            border-radius: 4px;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.75rem 1rem;
            color: white !important;
            margin-bottom: 8px;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }

        .sidebar .nav-link i {
            min-width: 20px;
            text-align: center;
        }
    </style>
    @stack('style')

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
            <!-- Sidebar Toggle -->
            <button class="btn btn-outline-light" id="toggleSidebarBtn">☰</button>

            <!-- Right Side -->
            <div class="dropdown ms-auto">
                <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#"
                    id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle me-2"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <!-- Profile -->
                    <!-- Uncomment/modify if using Blade and roles -->

                    @if (Auth::user()?->hasRole('admin'))
                        <li>
                            <a class="dropdown-item" href="{{ route('users.index') }}">
                                <i class="fas fa-user fa-sm me-2 text-gray-600"></i>Mengelola Pengguna
                            </a>
                        </li>
                    @endif

                    @php
                        $karyawan = Auth::user()?->karyawan;
                    @endphp

                    @if ($karyawan)
                        <li>
                            <a class="dropdown-item" href="{{ route('karyawans.profile', ['id' => $karyawan->id]) }}">
                                <i class="fas fa-user fa-sm me-2 text-gray-600"></i>Profil
                            </a>
                        </li>
                    @endif
                    <!-- Divider -->
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <!-- Logout -->
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt fa-sm me-2 text-gray-600"></i>Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Sidebar -->
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

    <!-- Main Content -->
    <div class="layout-wrapper">
        <main class="p-4" id="main-content">
            CONTENT
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer bg-dark text-end py-2 px-4 fixed-bottom w-100 shadow-sm" style="z-index: 1050;">
        {{-- <small>&copy; {{ date('Y') }} Your Company Name</small> --}}

        <strong>Copyright © 2025 Your Company.</strong> | All rights reserved.
        {{-- <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0.0
        </div> --}}
    </footer>


    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    @include('sweetalert::alert')
    @stack('scripts')
    <script>
        const toggleBtn = document.getElementById('toggleSidebarBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            mainContent.classList.toggle('sidebar-hidden');
        });
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded!');
        } else {
            console.log('jQuery version:', jQuery.fn.jquery);
            // Initialize any global components here
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
