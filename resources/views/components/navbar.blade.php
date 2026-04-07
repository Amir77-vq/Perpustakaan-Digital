<nav class="navbar navbar-main navbar-expand-lg px-3 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3 d-flex justify-content-between align-items-center">

        <div aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                </li>

                @php 
                    $allSegments = Request::segments();

                    if(request('from') == 'dashboard') {
                        $allSegments = array_values(array_filter($allSegments, function($value) {
                            return $value !== 'buku';
                        }));
                    }

                    $segments = collect($allSegments)->filter(function ($value) {
                        return !is_numeric($value) && strtolower($value) !== 'petugas'; 
                    })->values()->all(); 
                @endphp

                @foreach($segments as $index => $segment)
                    @if($index + 1 < count($segments))
                        <li class="breadcrumb-item text-sm text-dark opacity-5 text-capitalize">
                            {{ str_replace(['-', '_'], ' ', $segment) }}
                        </li>
                    @else
                        <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">
                            {{ str_replace(['-', '_'], ' ', $segment) }}
                        </li>
                    @endif
                @endforeach
            </ol>

            <h6 class="font-weight-bolder mb-0 text-capitalize">
                @if(Request::is('dashboard')) 
                    Dashboard 
                @elseif(Request::is('petugas/buku*')) 
                    Manajemen Buku
                @elseif(Request::is('petugas/anggota*')) 
                    Manajemen Anggota
                @elseif(Request::is('peminjaman-petugas*')) 
                    Konfirmasi Peminjaman
                @elseif(Request::is('pengembalian-petugas*')) 
                    Konfirmasi Pengembalian
                @elseif(Request::is('denda*')) 
                    Denda Perpustakaan
                @elseif(Request::is('peminjaman*')) 
                    Peminjaman Saya
                @elseif(Request::is('history*')) 
                    Riwayat Peminjaman
                @else 
                    @php 
                        $lastSegment = end($segments);
                        if(request('from') == 'dashboard' && $lastSegment == 'detail') {
                            $displayTitle = "Detail Buku";
                        } else {
                            $displayTitle = str_replace(['-', '_'], ' ', $lastSegment);
                        }
                    @endphp
                    {{ $displayTitle }} 
                @endif
            </h6>
        </div>

        <div class="d-flex align-items-center gap-3">
            {{-- Info User (Gue balikin ke .name biar muncul bang) --}}
            <div class="d-flex flex-column align-items-end me-1">
                <span class="text-sm font-weight-bold text-dark">{{ Auth::user()->name }}</span>
                <span class="text-xs text-secondary">{{ ucfirst(Auth::user()->role) }}</span>
            </div>

            {{-- Icon Profil --}}
            <a href="{{ route('profile') }}" class="nav-link text-body p-0">
                <div class="avatar avatar-sm bg-gradient-info d-flex align-items-center justify-content-center shadow-sm" 
                    style="width: 35px; height: 35px; border-radius: 50%;">
                    <i class="fas fa-user text-white text-xs"></i>
                </div>
            </a>

            {{-- Tombol Logout (Hanya Logo) --}}
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-link text-danger p-0 m-0 shadow-none" title="Logout">
                    <i class="fas fa-sign-out-alt" style="font-size: 18px;"></i>
                </button>
            </form>

            <div class="nav-item d-xl-none d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
            </div>
        </div>

    </div>
</nav>