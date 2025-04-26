{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Bootstrap & Custom Styles -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">

    <style>
        /* Improve Select2 styling to match your theme */
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
            /* Ensures equal height */
            min-height: 120px;
            /* Adjust as needed */
        }

        body {
            overflow-x: hidden;
        }

        .sidebar {
            min-height: 100vh;
        }

        /* @media (max-width: 768px) {
            .main-sidebar {
                width: 70px;
            }

            .main-sidebar .nav-link p {
                display: none;
            }

            .main-sidebar .brand-link span {
                display: none;
            }
        } */

        /* Medium screen (tablets) */
        @media (max-width: 992px) {
            html {
                font-size: 15px;
            }
        }

        /* Small screen (phones) */
        @media (max-width: 768px) {
            html {
                font-size: 14px;
            }
        }

        /* Extra small screen */
        @media (max-width: 576px) {
            html {
                font-size: 13px;
            }
        }
    </style>

    @stack('style')

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="">
    <!-- Page Wrapper -->
    <div class="wrapper">
        @include('partials.topbar')

        @include('partials.sidebar')
        <!-- Content Wrapper -->
        <div class="content-wrapper pt-5 px-4">
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        @include('partials.footer')
    </div>

    <!-- Scripts - Load jQuery first, then other scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    @include('sweetalert::alert')
    @stack('scripts')

    <!-- Global initialization scripts -->
    <script>
        // This ensures jQuery is available globally
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded!');
        } else {
            console.log('jQuery version:', jQuery.fn.jquery);
            // Initialize any global components here
        }
    </script>
</body>

</html> --}}


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

<body data-page="{{ Route::currentRouteName() }}">

    <!-- Top Navbar -->
    @include('partials.topbar')

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    {{-- <div class="content-wrapper pt-5 px-4">
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div> --}}

    <div class="layout-wrapper">
        <main class="p-4" id="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    @include('partials.footer')

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

        const currentPage = document.body.dataset.page;

        const toastRoutes = [
            'karyawans.index',
            'users.index',
            'absens.data',
            'absens.self',
            'lokasikerjas.index',
            'ketidakhadirans.index',
            'lemburs.index',
            'penilaians.index'
        ];

        if (toastRoutes.includes(currentPage) && !sessionStorage.getItem('warn-table-toast')) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: 'Tombol tabel (Copy, CSV, Excel, PDF) akan menggunakan data yang sedang ditampilkan pada tabel',
                showConfirmButton: true,
            });

            sessionStorage.setItem('warn-table-toast', 'true');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
