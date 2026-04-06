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
                    Daftar Denda Perpustakaan
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
            <div class="d-flex flex-column align-items-end me-2">
                <span class="text-sm font-weight-bold text-dark">{{ Auth::user()->name }}</span>
                <span class="text-xs text-secondary">{{ ucfirst(Auth::user()->role) }}</span>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger mb-0 px-3 py-1">
                    Logout
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