<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentication')</title>

    <!-- Custom fonts for this template -->

    {{-- <link href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('node_modules/admin-lte/dist/css/adminlte.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
</head>
<body class="hold-transition login-page">

    @yield('content')

    <!-- Bootstrap & JS -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('node_modules/admin-lte/dist/js/adminlte.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('vendor/adminlte/js/adminlte.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/sb-admin-2.min.js') }}"></script> --}}
    @stack('scripts')

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
</html>
