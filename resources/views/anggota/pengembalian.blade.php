@extends('layouts.app')

@push('styles')
    <link href="{{ asset('assets/css/style-anggota-pengembalian.css') }}?v={{ time() }}" rel="stylesheet">
    <style>
        .btn-ajukan-aman {
            background: linear-gradient(310deg, #2152ff, #21d4fd) !important;
            border: none;
            color: #fff !important;
        }
        
        .btn-ajukan-terlambat {
            background: linear-gradient(310deg, #ea0606, #ff667c) !important;
            border: none;
            color: #fff !important;
        }
        
        .btn-ajukan-hari-h {
            background: linear-gradient(310deg, #f7d02c, #fbb144) !important;
            border: none;
            color: #fff !important;
        }

        .btn-ajukan-aman:hover, 
        .btn-ajukan-terlambat:hover, 
        .btn-ajukan-hari-h:hover { 
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, .1), 0 3px 6px rgba(0, 0, 0, .08);
        }

        /* EFEK HOVER KONSISTEN (Sama persis kaya Peminjaman) */
        .table-peminjaman tbody tr:hover {
            background-color: #f8f9fa !important; /* Warna abu muda khas Soft UI */
            cursor: pointer;
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

        <div class="card card-peminjaman border-0 shadow-lg">
            <div class="card-header header-peminjaman d-flex justify-content-between align-items-center">
                <h5 class="text-white mb-0" style="font-weight: 600; font-size: 0.9rem;">Buku yang Masih Dipinjam</h5>
                <div class="ms-auto">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <input type="text" class="form-control search-peminjaman" placeholder="Cari buku..">
                    </div>
                </div>
            </div>

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
                    <table class="table table-peminjaman align-items-center mb-0">
                        <thead>
                            <tr class="text-muted">
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-4">NO</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">JUDUL BUKU</th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">TANGGAL PINJAM</th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">JATUH TEMPO</th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">AKSI</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.85rem;">
                            @forelse($peminjamans as $key => $item)
                                <tr class="border-bottom">
                                    <td class="ps-4 align-middle text-secondary">{{ $key + 1 }}</td>
                                    <td class="align-middle">
                                        <span class="text-dark font-weight-bold judul-buku-bold">{{ $item->judul_buku }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="{{ $item->warna_tanggal }} font-weight-bold">
                                            {{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($item->status == 'DIPINJAM')
                                            <a href="{{ route('pengembalian.ajukan', $item->id) }}"
                                                class="btn btn-sm mb-0 shadow-sm font-weight-bold {{ str_contains($item->warna_tanggal, 'danger') ? 'btn-ajukan-terlambat' : (str_contains($item->warna_tanggal, 'warning') ? 'btn-ajukan-hari-h' : 'btn-ajukan-aman') }}"
                                                style="font-size: 0.65rem; padding: 8px 16px;">
                                                AJUKAN PENGEMBALIAN
                                            </a>
                                        @elseif($item->status == 'WAITING')
                                            <span class="badge bg-gradient-info shadow-sm" style="font-size: 0.65rem;">
                                                MENUNGGU VERIFIKASI
                                            </span>
                                        @else
                                            <span class="badge bg-gradient-success shadow-sm" style="font-size: 0.65rem;">
                                                SELESAI
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <p class="text-muted mb-0">Wah, sepertinya Anda tidak punya pinjaman aktif.</p>
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