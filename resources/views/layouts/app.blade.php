<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LIBRARY</title>

    <!-- CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet">

    <!-- TAMBAHAN CSS LU (WAJIB DI PALING BAWAH) -->
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
</head>

<body class="g-sidenav-show bg-gray-200">

    <!-- SIDEBAR -->
    @if(auth()->user()->role == 'anggota')
    @include('components.sidebar-anggota')
    @elseif(auth()->user()->role == 'petugas')
    @include('components.sidebar-petugas')
    @elseif(auth()->user()->role == 'kepala')
    @include('components.sidebar-kepala')
    @endif

    <!-- MAIN -->
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

        <!-- NAVBAR -->
        @include('components.navbar')

        <!-- CONTENT -->
        <div class="container-fluid py-4">
            @yield('content')
        </div>

    </main>

    <!-- JS -->
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
</body>

</html>