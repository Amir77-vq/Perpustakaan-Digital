@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/css/style-petugas-peminjaman.css') }}">
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

                    {{-- Header --}}
                    <div class="mx-3 position-relative z-index-2">
                        <div class="px-4 d-flex align-items-center justify-content-between"
                            style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 75px; margin-top: -25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                            <h6 class="text-white mb-0 font-weight-bold" style="letter-spacing: 0.5px;">Manajemen Denda
                                Anggota</h6>
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
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">JATUH
                                            TEMPO</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">TANGGAL
                                            KEMBALI</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">
                                            TERLAMBAT</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">DENDA
                                        </th>
                                        <th class="text-center text-uppercase text-xxs font-weight-bolder py-3">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($peminjamans as $item)
                                        <tr style="border-bottom: 1px solid #f2f2f2;">
                                            <td class="ps-4">
                                                <span class="text-xs font-weight-bold text-dark">
                                                    {{ $item->kode_peminjaman ?? 'A' . str_pad($item->id, 2, '0', STR_PAD_LEFT) }}
                                                </span>
                                            </td>
                                            <td class="ps-2">
                                                <p class="text-sm font-weight-bold mb-0" style="color: #344767;">
                                                    {{ $item->user->name ?? '-' }}
                                                </p>
                                            </td>
                                            <td class="ps-2">
                                                <span class="text-xs text-secondary font-weight-normal">
                                                    {{ $item->buku->judul ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-xs text-secondary">
                                                    {{ date('d/m/Y', strtotime($item->jatuh_tempo)) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-xs text-secondary">
                                                    {{ $item->tgl_kembali ? date('d/m/Y', strtotime($item->tgl_kembali)) : 'Belum Kembali' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-xs {{ $item->denda > 0 ? 'text-danger font-weight-bold' : 'text-secondary' }}">
                                                    {{ (int) ($item->terlambat ?? 0) }} Hari
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="text-xs font-weight-bold {{ $item->denda != 0 ? 'text-dark' : 'text-secondary' }}">
                                                    {{ $item->denda != 0 ? 'Rp ' . number_format(abs($item->denda), 0, ',', '.') : '-' }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if($item->denda != 0 && ($item->status != 'dikembalikan' && $item->status != 'kembali'))
                                                    {{-- SESUAIKAN NAMA ROUTE DENGAN WEB.PHP LU --}}
                                                    <form action="{{ route('petugas.konfirmasi_lunas', $item->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-xs mb-0 px-3 py-1 text-white"
                                                            onclick="return confirm('Konfirmasi pelunasan denda Rp {{ number_format(abs($item->denda), 0, ',', '.') }}?')"
                                                            style="background-color: #d81b60; font-size: 10px; border-radius: 5px; font-weight: 700; border: none; text-transform: uppercase; cursor: pointer;">
                                                            KONFIRMASI LUNAS
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="badge badge-sm"
                                                        style="background-color: #2dce89; color: #fff; font-size: 9px; padding: 5px 10px;">LUNAS
                                                        / SELESAI</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <p class="text-secondary text-sm mb-0">Tidak ada data denda saat ini.</p>
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