@extends('layouts.app')

@section('content')

<div class="row stats-section">
    {{-- Total Buku --}}
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card shadow-sm border-radius-xl p-3 stats-card-custom">
            <div class="d-flex align-items-center w-100">
                <div class="icon icon-lg icon-shape bg-dark shadow-dark border-radius-xl mt-n4 position-absolute d-flex justify-content-center align-items-center">
                    <i class="fas fa-book"></i>
                </div>
                <div class="text-end ms-auto">
                    <p class="text-sm mb-0 text-secondary">Total Buku</p>
                    <h4 class="mb-0 font-weight-bolder text-dark">{{ $totalBuku }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Anggota --}}
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card shadow-sm border-radius-xl p-3 stats-card-custom">
            <div class="d-flex align-items-center w-100">
                <div class="icon icon-lg icon-shape shadow-primary border-radius-xl mt-n4 position-absolute d-flex justify-content-center align-items-center" style="background-color: #e91e63 !important;">
                    <i class="fas fa-user"></i>
                </div>
                <div class="text-end ms-auto">
                    <p class="text-sm mb-0 text-secondary">Total Anggota</p>
                    <h4 class="mb-0 font-weight-bolder text-dark">{{ $totalAnggota }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Peminjaman Aktif --}}
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card shadow-sm border-radius-xl p-3 stats-card-custom">
            <div class="d-flex align-items-center w-100">
                <div class="icon icon-lg icon-shape bg-success shadow-success border-radius-xl mt-n4 position-absolute d-flex justify-content-center align-items-center">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="text-end ms-auto">
                    <p class="text-sm mb-0 text-secondary">Peminjaman Aktif</p>
                    <h4 class="mb-0 font-weight-bolder text-dark">{{ $peminjamanAktif }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Denda Belum Dibayar --}}
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card shadow-sm border-radius-xl p-3 stats-card-custom">
            <div class="d-flex align-items-center w-100">
                <div class="icon icon-lg icon-shape shadow-info border-radius-xl mt-n4 position-absolute d-flex justify-content-center align-items-center" style="background-color: #2196f3 !important;">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="text-end ms-auto">
                    <p class="text-sm mb-0 text-secondary">Denda Belum Dibayar</p>
                    <h4 class="mb-0 font-weight-bolder text-dark">Rp {{ number_format($dendaBelumDibayar, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Aktivitas Terbaru --}}
<div class="row mt-1 mb-5">
    <div class="col-12">
        <div class="card shadow-sm border-0" style="border-radius: 12px; background: #fff; margin-top: 20px;">
            <div class="mx-3 position-relative z-index-2">
                <div class="peminjaman-header shadow-primary px-3 d-flex align-items-center" 
                    style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 6px; min-height: 60px; margin-top: -25px;">
                    <h6 class="text-white mb-0 text-xs font-weight-bold" style="letter-spacing: 0.5px;">
                        Aktivitas Terbaru
                    </h6>
                </div>
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0 mt-3"> 
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3 py-2">NAMA</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3 py-2">JUDUL BUKU</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 py-2">STATUS</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 py-2">TANGGAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentActivities as $activity)
                            <tr style="border-bottom: 1px solid #f8f9fa;">
                                <td class="ps-3 py-2">
                                    <p class="text-xs font-weight-bold mb-0 text-dark">{{ $activity->user?->name ?? 'User Tidak Ditemukan' }}</p>
                                </td>
                                <td class="ps-3 py-2">
                                    <p class="text-xs font-weight-bold mb-0 text-dark">{{ $activity->buku?->judul ?? 'Buku Terhapus' }}</p>
                                </td>
                                <td class="align-middle text-center py-2">
                                    @php
                                        // Normalisasi status ke huruf kecil untuk pengecekan
                                        $status = strtolower($activity->status);
                                    @endphp

                                    @if($status == 'dipinjam')
                                        <span class="badge" style="background-color: #2152ff; color: #fff; border-radius: 4px; padding: 4px 8px; font-size: 8px; font-weight: 700;">DIPINJAM</span>
                                    @elseif($status == 'dikembalikan' || $status == 'kembali')
                                        <span class="badge" style="background-color: #2dce89; color: #fff; border-radius: 4px; padding: 4px 8px; font-size: 8px; font-weight: 700;">DIKEMBALIKAN</span>
                                    @elseif($status == 'denda_dibayar' || $status == 'sudah_bayar')
                                        <span class="badge" style="background-color: #4caf50; color: #fff; border-radius: 4px; padding: 4px 8px; font-size: 8px; font-weight: 700;">DENDA DI BAYAR</span>
                                    @elseif($status == 'menunggu')
                                        <span class="badge" style="background-color: #fb8c00; color: #fff; border-radius: 4px; padding: 4px 8px; font-size: 8px; font-weight: 700;">PENDING</span>
                                    @else
                                        <span class="badge" style="background-color: #f44335; color: #fff; border-radius: 4px; padding: 4px 8px; font-size: 8px; font-weight: 700;">{{ strtoupper($status) }}</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center py-2">
                                    <span class="text-secondary text-xxs font-weight-bold">
                                        {{ \Carbon\Carbon::parse($activity->tanggal ?? $activity->created_at)->format('d/m/y') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <span class="text-secondary text-xs">Belum ada aktivitas terbaru.</span>
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

@endsection