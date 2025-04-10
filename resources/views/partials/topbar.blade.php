@auth
{{-- <nav class="main-header navbar navbar-expand navbar-dark bg-primary">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <!-- Sidebar Toggle Button -->
        <li class="nav-item">
            <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right Navbar Links -->
    <ul class="navbar-nav ml-auto">
        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle mr-1"></i> {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <!-- Profile Option -->
                @if (Auth::user()->hasRole('admin'))
                <a class="dropdown-item" href="{{ route('users.index') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-600"></i>
                    Mengelola Pengguna
                </a>
                @endif
                <a class="dropdown-item" href="{{ route('karyawans.profile', ['id' => Auth::user()->karyawan->id]) }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-600"></i>
                    Profil
                </a>

                <!-- Logout Option -->
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-600"></i>
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav> --}}
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
@else
    <script>window.location.href = "{{ route('login') }}";</script>
@endauth
