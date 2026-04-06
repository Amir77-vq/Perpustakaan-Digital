<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LIBRARY</title>

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dashboard.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}?v={{ time() }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @stack('styles')
</head>

<body class="g-sidenav-show bg-gray-100">

    @if(auth()->user()->role == 'anggota')
        @include('components.sidebar-anggota')
    @elseif(auth()->user()->role == 'petugas')
        @include('components.sidebar-petugas')
    @else
        @include('components.sidebar-kepala')
    @endif

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        
        @include('components.navbar')

        <div class="container-fluid py-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show text-white border-0 mb-4" role="alert" style="background-image: linear-gradient(310deg, #17ad37 0%, #98ec2d 100%);">
                    <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
                    <span class="alert-text"><strong>Berhasil!</strong> {{ session('success') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show text-white border-0 mb-4" role="alert" style="background-image: linear-gradient(310deg, #ea0606 0%, #ff667c 100%);">
                    <span class="alert-icon"><i class="fas fa-exclamation-triangle"></i></span>
                    <span class="alert-text"><strong>Ups!</strong> {{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>

    </main>

    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    
    @stack('scripts')
</body>
</html>