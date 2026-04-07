@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/style-petugas-peminjaman.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px; background: #fff;">
        {{-- Header dengan Gradient --}}
        <div class="mx-3 position-relative z-index-2">
            <div class="px-4 d-flex align-items-center justify-content-between"
                style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 75px; margin-top: -25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <h6 class="text-white mb-0 font-weight-bold">Manajemen Pengembalian</h6>
            </div>
        </div>

        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0 mt-4">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr class="text-secondary opacity-7">
                            <th class="ps-4 py-3 text-xxs font-weight-bolder">ID</th>
                            <th class="ps-2 py-3 text-xxs font-weight-bolder">NAMA ANGGOTA</th>
                            <th class="ps-2 py-3 text-xxs font-weight-bolder">JUDUL BUKU</th>
                            <th class="text-center py-3 text-xxs font-weight-bolder">TGL PINJAM</th>
                            <th class="text-center py-3 text-xxs font-weight-bolder">TGL KEMBALI</th>
                            <th class="text-center py-3 text-xxs font-weight-bolder">STATUS</th>
                            <th class="text-center py-3 text-xxs font-weight-bolder">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalians as $item)
                        <tr style="border-bottom: 1px solid #f2f2f2;">
                            <td class="ps-4 text-xs font-weight-bold">
                                {{-- Ambil ID asli agar tidak jadi 000 --}}
                                KMB-{{ str_pad($item->getAttribute($item->getKeyName()), 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="ps-2 text-sm font-weight-bold" style="color: #344767;">
                                {{ $item->peminjaman->user->name ?? '-' }}
                            </td>
                            <td class="ps-2 text-xs text-secondary">
                                {{ $item->peminjaman->buku->judul ?? '-' }}
                            </td>
                            <td class="text-center text-xs text-secondary">
                                {{ date('d/m/y', strtotime($item->peminjaman->tgl_pinjam)) }}
                            </td>
                            <td class="text-center text-xs text-secondary">
                                {{ $item->status != 0 ? date('d/m/y', strtotime($item->tanggal_kembali)) : '-' }}
                            </td>
                            <td class="text-center">
                                @if($item->status == 0)
                                    {{-- Status PENDING (Kuning) --}}
                                    <span style="background-color: #fbc02d !important; color: #fff !important; font-size: 9px; padding: 4px 8px; border-radius: 4px; font-weight: bold; display: inline-block;">PENDING</span>
                                @else
                                    {{-- FIX: WARNA DIKEMBALIKAN SESUAI CONTOH FOTO --}}
                                    <span style="background-color: #2ecc71 !important; color: #ffffff !important; font-size: 9px; padding: 4px 8px; border-radius: 4px; font-weight: bold; display: inline-block;">DIKEMBALIKAN</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                @if($item->status == 0)
                                    <form action="{{ route('pengembalian.konfirmasi', $item->peminjaman_id) }}" method="POST">
                                        @csrf
                                        {{-- Tombol Konfirmasi Biru Tua Tanpa Border Muda --}}
                                        <button type="submit" 
                                            style="background-color: #2152ff !important; color: #fff !important; font-size: 10px !important; border-radius: 5px !important; font-weight: 700 !important; border: none !important; padding: 4px 12px !important; text-transform: uppercase; cursor: pointer;"
                                            onclick="return confirm('Konfirmasi pengembalian ini?')">
                                            KONFIRMASI
                                        </button>
                                    </form>
                                @else
                                    <span class="text-secondary text-xs font-weight-bold">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-5 text-secondary text-sm">Data tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection