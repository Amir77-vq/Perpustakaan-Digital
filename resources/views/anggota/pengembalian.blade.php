@extends('layouts.app')

@push('styles')
    <link href="{{ asset('assets/css/style-anggota-pengembalian.css') }}?v={{ time() }}" rel="stylesheet">
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
                            {{-- Logika Alur Jatuh Tempo (JANGAN DI APA-APAIN) --}}
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
                                    <span class="text-dark font-weight-bold judul-buku-bold">{{ $item->judul_buku }}</span>
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
                                        class="btn-ajukan {{ $btnClass }} shadow-sm">
                                        AJUKAN PENGEMBALIAN
                                    </a>
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