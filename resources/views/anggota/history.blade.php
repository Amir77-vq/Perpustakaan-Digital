@extends('layouts.app')

@push('styles')
    <link href="{{ asset('assets/css/style-anggota-history.css') }}?v={{ time() }}" rel="stylesheet">
    <style>
        /* Warna Badge Status Solid & Konsisten */
        .badge-status {
            padding: 0.5em 0.9em;
            border-radius: 0.45rem;
            font-size: 0.7rem;
            font-weight: 700;
            color: #fff !important;
            display: inline-block;
            text-transform: uppercase;
            min-width: 90px;
            text-align: center;
        }

        /* Palet Warna Material */
        .bg-approved { background-color: #2dce89 !important; } /* Hijau - Selesai */
        .bg-waiting  { background-color: #11cdef !important; } /* Biru - Dipinjam */
        .bg-pending  { background-color: #fbcf33 !important; } /* Kuning - Proses */
        .bg-late     { background-color: #f5365c !important; } /* Merah - Terlambat */
        
        .badge-status:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
            transition: all 0.2s;
        }

        .table-peminjaman tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/search-history.js') }}?v={{ time() }}"></script>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">Riwayat Peminjaman</h3>
            <p class="text-muted mb-4" style="font-size: 0.8rem;">Pantau status buku dan riwayat denda Anda di sini.</p>
        </div>
    </div>

    <div class="card card-peminjaman border-0 shadow-lg" style="border-radius: 1rem;">
        <div class="card-header header-peminjaman d-flex justify-content-between align-items-center p-3" 
             style="background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%); border-radius: 1rem 1rem 0 0;">
            <h5 class="text-white mb-0" style="font-weight: 600; font-size: 0.9rem;">
                <i class="fas fa-history me-2"></i> Daftar Aktivitas
            </h5>
            <div class="ms-auto">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                    <input type="text" id="searchInput" class="form-control ps-2" placeholder="Cari judul buku...">
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-align-items-center mb-0" id="historyTable">
                    <thead>
                        <tr class="text-muted" style="background-color: #f8f9fa;">
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-4">NO</th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">JUDUL BUKU</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">PINJAM</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">KEMBALI</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">STATUS</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">DENDA</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.85rem;">
                        @forelse($peminjamans as $key => $item)
                        <tr>
                            <td class="ps-4 align-middle text-secondary">{{ $key + 1 }}</td>
                            <td class="align-middle">
                                <span class="text-dark font-weight-bold judul-buku">{{ $item->judul_buku }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/y') }}</span>
                            </td>
                            <td class="align-middle text-center">
                                @if($item->tgl_kembali || ($item->status == 'SELESAI'))
                                    <span class="text-dark font-weight-bold">
                                        {{ \Carbon\Carbon::parse($item->tgl_kembali ?? $item->updated_at)->format('d/m/y') }}
                                    </span>
                                @else
                                    <span class="text-xs text-muted font-italic">- Belum Kembali -</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                @php
                                    $statusClass = match($item->status) {
                                        'SELESAI' => 'bg-approved',
                                        'DIPINJAM' => 'bg-waiting',
                                        'TERLAMBAT' => 'bg-late',
                                        default => 'bg-pending',
                                    };
                                @endphp
                                <span class="badge-status {{ $statusClass }}">{{ $item->status }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="{{ $item->denda > 0 ? 'text-danger' : 'text-dark' }} font-weight-bold">
                                    Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="{{ asset('assets/img/empty-data.png') }}" style="width: 100px; opacity: 0.5;" alt=""><br>
                                <p class="text-muted mt-2">Belum ada riwayat peminjaman.</p>
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