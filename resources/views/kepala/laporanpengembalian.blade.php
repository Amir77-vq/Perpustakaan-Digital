@extends('layouts.app')

@push('styles')
    <style>
        /* Samakan style dengan laporan peminjaman */
        .text-xxs {
            font-size: 0.65rem !important;
        }

        .card .text-xs {
            font-size: 0.75rem !important;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4">
        <div class="row mt-2">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-radius: 15px; background: #fff;">

                    <div class="mx-3 position-relative z-index-2">
                        <div class="px-4 d-flex align-items-center justify-content-between"
                            style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 75px; margin-top: -25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                            <h6 class="text-white mb-0 font-weight-bold" style="letter-spacing: 0.5px;">Laporan Pengembalian
                            </h6>
                        </div>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0 mt-4">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr class="text-secondary opacity-7">
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-4 py-3">No</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3">Nama Anggota</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3">Judul Buku</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">Tanggal
                                            Kembali</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">
                                            Terlambat</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">Denda
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pengembalians as $index => $item)
                                        <tr style="border-bottom: 1px solid #f2f2f2;">
                                            <td class="ps-4">
                                                <span class="text-xs font-weight-bold">{{ $index + 1 }}</span>
                                            </td>

                                            {{-- Nama Anggota (Gue balikin ke mentahan lu) --}}
                                            <td class="ps-2">
                                                <p class="text-sm font-weight-bold mb-0" style="color: #344767;">
                                                    {{ $item->peminjaman->user->name ?? '-' }}
                                                </p>
                                            </td>

                                            {{-- Judul Buku (Gue balikin ke mentahan lu) --}}
                                            <td class="ps-2">
                                                <span class="text-xs text-secondary font-weight-normal">
                                                    {{ $item->buku->judul ?? '-' }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="text-xs text-secondary font-weight-normal">
                                                    @if($item->tanggal_kembali)
                                                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}
                                                    @elseif($item->tgl_kembali)
                                                        {{ \Carbon\Carbon::parse($item->tgl_kembali)->format('d-m-Y') }}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($item->updated_at)->format('d-m-Y') }}
                                                    @endif
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="text-xs font-weight-bold">
                                                    {{-- Ganti > 0 menjadi != 0 dan tambahkan abs() --}}
                                                    @if(($item->denda ?? 0) != 0)
                                                        {{-- Denda dibagi 2000, abs() buat ngilangin tanda minus --}}
                                                        {{ number_format(abs($item->denda) / 2000, 0) }} Hari
                                                    @else
                                                        <span class="text-secondary">-</span>
                                                    @endif
                                                </span>
                                            </td>

                                            {{-- Fix Denda: Biar angka minus di DB tetep muncul --}}
                                            <td class="text-center">
                                                <span
                                                    class="text-xs font-weight-bold {{ ($item->denda ?? 0) != 0 ? 'text-dark' : 'text-secondary' }}">
                                                    @if(($item->denda ?? 0) != 0)
                                                        Rp {{ number_format(abs($totalDenda ?? 0), 0, ',', '.') }}
                                                    @else
                                                        -
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <p class="text-secondary text-sm mb-0">Tidak ada data pengembalian.</p>
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