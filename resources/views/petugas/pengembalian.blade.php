@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/style-petugas-peminjaman.css') }}">
    <style>
        .badge-pending {
            background-color: #fbc02d;
            color: #fff;
            font-size: 9px;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .badge-success-custom {
            background-color: #3f51b5;
            color: #fff;
            font-size: 9px;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .btn-konfirmasi {
            background-color: #2e7d32;
            color: #fff;
            font-size: 10px;
            border-radius: 5px;
            font-weight: 700;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-konfirmasi:hover {
            background-color: #1b5e20;
            transform: translateY(-1px);
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/validation-peminjaman.js') }}"></script>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row mt-2">
        <div class="col-12">
            {{-- Card Utama --}}
            <div class="card shadow-sm border-0" style="border-radius: 15px; background: #fff;">

                {{-- Header Gradien --}}
                <div class="mx-3 position-relative z-index-2">
                    <div class="px-4 d-flex align-items-center justify-content-between"
                        style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 75px; margin-top: -25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <h6 class="text-white mb-0 font-weight-bold" style="letter-spacing: 0.5px;">Manajemen Pengembalian</h6>
                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0 mt-4">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr class="text-secondary opacity-7">
                                    <th class="text-uppercase text-xxs font-weight-bolder ps-4 py-3">ID</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3">NAMA ANGGOTA</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3">JUDUL BUKU</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">TANGGAL PINJAM</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">TANGGAL KEMBALI</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">DENDA</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">STATUS</th>
                                    <th class="text-center text-uppercase text-xxs font-weight-bolder py-3">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengembalians as $item)
                                <tr style="border-bottom: 1px solid #f2f2f2;">
                                    <td class="ps-4">
                                        <span class="text-xs font-weight-bold text-dark">
                                            KMB-{{ str_pad($item->pengembalian_id ?? $item->id, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td class="ps-2">
                                        <p class="text-sm font-weight-bold mb-0" style="color: #344767;">
                                            {{ $item->peminjaman->user->name ?? 'User Tidak Ada' }}
                                        </p>
                                    </td>
                                    <td class="ps-2">
                                        <span class="text-xs text-secondary font-weight-normal">
                                            {{ $item->peminjaman->buku->judul ?? 'Buku Dihapus' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-xs text-secondary">
                                            {{ date('d/m/Y', strtotime($item->peminjaman->tgl_pinjam)) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-xs text-secondary">
                                            {{ $item->status == 1 ? date('d/m/Y', strtotime($item->tanggal_kembali)) : '-' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="text-xs font-weight-bold {{ $item->denda > 0 ? 'text-danger' : 'text-secondary' }}">
                                            Rp {{ number_format($item->denda, 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($item->status == 0)
                                            <span class="badge badge-sm badge-pending">PENDING</span>
                                        @else
                                            <span class="badge badge-sm badge-success-custom">DIKEMBALIKAN</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($item->status == 0)
                                            <form action="{{ route('pengembalian.konfirmasi', $item->peminjaman_id) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                                                <button type="submit" class="btn-konfirmasi btn btn-xs mb-0 px-3 py-1">
                                                    KONFIRMASI
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-secondary text-xs" style="font-style: italic;">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <p class="text-secondary text-sm mb-0">Belum ada antrean data pengembalian.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div> 
    </div> 
</div> 
@endsection