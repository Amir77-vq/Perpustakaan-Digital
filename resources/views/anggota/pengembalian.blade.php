@extends('layouts.app')

@push('styles')
    <link href="{{ asset('assets/css/style-anggota-pengembalian.css') }}?v={{ time() }}" rel="stylesheet">
    <style>
        /* Tambahan Style untuk Status Jatuh Tempo */
        .text-jatuh-tempo-lewat { color: #f5365c !important; font-weight: 800; } /* Merah */
        .text-jatuh-tempo-warning { color: #fbcf33 !important; font-weight: 800; } /* Kuning */
        
        .btn-ajukan {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            transition: all 0.3s ease;
            display: inline-block;
            border: none;
        }

        .btn-merah { background: linear-gradient(310deg, #ea0606 0%, #ff667c 100%); color: white; }
        .btn-oren  { background: linear-gradient(310deg, #f53939 0%, #fbcf33 100%); color: white; }
        .btn-biru  { background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%); color: white; }

        .btn-ajukan:hover { transform: translateY(-2px); color: white; opacity: 0.9; }
        
        .alert-denda-final {
            background: linear-gradient(310deg, #f5365c 0%, #f56036 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin: 15px;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/search-pengembalian.js') }}"></script>
@endpush

@section('content')
    <div class="container-fluid py-4">
        <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">Pengembalian Buku</h3>
        <p class="text-muted mb-4" style="font-size: 0.8rem;">Segera kembalikan buku sebelum jatuh tempo untuk menghindari denda.</p>

        <div class="card card-peminjaman border-0 shadow-lg" style="border-radius: 1rem;">
            <div class="card-header header-peminjaman d-flex justify-content-between align-items-center p-3"
                style="background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%); border-radius: 1rem 1rem 0 0;">
                <h5 class="text-white mb-0" style="font-weight: 600; font-size: 0.9rem;">Buku yang Masih Dipinjam</h5>
                <div class="ms-auto">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <input type="text" class="form-control search-peminjaman" placeholder="Cari buku..">
                    </div>
                </div>
            </div>

            {{-- Alert Akumulasi Denda (Jika Ada) --}}
            @if(isset($totalDenda) && $totalDenda > 0)
                <div class="alert-denda-final d-flex align-items-center shadow-sm">
                    <i class="fas fa-exclamation-circle me-3 fa-lg"></i>
                    <div>
                        <span class="d-block text-xs opacity-8">Total Denda Berjalan :</span>
                        <span class="font-weight-bold" style="font-size: 1.1rem;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endif

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-align-items-center mb-0">
                        <thead>
                            <tr class="text-muted" style="background-color: #f8f9fa;">
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-4">NO</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">JUDUL BUKU</th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">TGL PINJAM</th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">JATUH TEMPO</th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">AKSI</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.85rem;">
                            @forelse($peminjamans as $key => $item)
                                @php
                                    $today = \Carbon\Carbon::now()->startOfDay();
                                    $dueDate = \Carbon\Carbon::parse($item->jatuh_tempo)->startOfDay();

                                    if ($today->gt($dueDate)) {
                                        $colorClass = 'text-jatuh-tempo-lewat';
                                        $btnClass = 'btn-merah';
                                        $statusLabel = 'TERLAMBAT';
                                    } elseif ($today->eq($dueDate)) {
                                        $colorClass = 'text-jatuh-tempo-warning';
                                        $btnClass = 'btn-oren';
                                        $statusLabel = 'HARI INI';
                                    } else {
                                        $colorClass = 'text-secondary';
                                        $btnClass = 'btn-biru';
                                        $statusLabel = 'AMAN';
                                    }
                                @endphp
                                <tr class="border-bottom">
                                    <td class="ps-4 align-middle text-secondary">{{ $key + 1 }}</td>
                                    <td class="align-middle">
                                        <span class="text-dark font-weight-bold">{{ $item->judul_buku }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}
                                    </td>
                                    <td class="align-middle text-center {{ $colorClass }}">
                                        {{ $dueDate->format('d/m/Y') }} 
                                        <small class="d-block text-xxs" style="font-weight: 600;">({{ $statusLabel }})</small>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('pengembalian.ajukan', $item->id) }}"
                                            class="btn-ajukan {{ $btnClass }} text-decoration-none shadow-sm">
                                            KEMBALIKAN
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted opacity-5 mb-2">
                                            <i class="fas fa-book-open fa-3x"></i>
                                        </div>
                                        <p class="text-muted">Wah, sepertinya Anda tidak punya pinjaman aktif.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection