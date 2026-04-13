@extends('layouts.app')

@push('styles')
    <link href="{{ asset('assets/css/style-anggota-pengembalian.css') }}?v={{ time() }}" rel="stylesheet">
    <style>
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

        .bg-approved {
            background: linear-gradient(310deg, #2dce89 0%, #6decb9 100%) !important;
        }

        .bg-waiting {
            background: linear-gradient(310deg, #11cdef 0%, #1172ef 100%) !important;
        }

        .bg-late {
            background: linear-gradient(310deg, #ea0606 0%, #ff667c 100%) !important;
        }

        .bg-pending {
            background: linear-gradient(310deg, #fbcf33 0%, #fbb144 100%) !important;
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
        <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">Riwayat Peminjaman</h3>
        <p class="text-muted mb-4" style="font-size: 0.8rem;">Pantau status buku dan riwayat denda Anda di sini.</p>

        <div class="card card-peminjaman border-0 shadow-lg">
            <div class="card-header header-peminjaman d-flex justify-content-between align-items-center">
                <h5 class="text-white mb-0" style="font-weight: 600; font-size: 0.9rem;">
                    <i class="fas fa-history me-2"></i> Daftar Aktivitas
                </h5>
                <div class="ms-auto">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <input type="text" class="form-control search-peminjaman" id="historySearch"
                            placeholder="Cari buku..">
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-peminjaman align-items-center mb-0" id="historyTable">
                        <thead>
                            <tr class="text-muted">
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-4">NO</th>
                                <th class="text-uppercase text-xxs font-weight-bolder opacity-7">JUDUL BUKU</th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">TANGGAL PINJAM</th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">TANGGAL KEMBALI</th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">STATUS</th>
                                <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">DENDA</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.85rem;">
                            @forelse($peminjamans as $key => $item)
                                <tr class="border-bottom">
                                    <td class="ps-4 align-middle text-secondary">{{ $key + 1 }}</td>
                                    <td class="align-middle">
                                        <span class="text-dark font-weight-bold judul-buku-bold">{{ $item->judul_buku }}</span>
                                    </td>
                                    <td class="align-middle text-center text-secondary">
                                        {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/y') }}
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($item->tgl_kembali || $item->status == 'DIKEMBALIKAN' || $item->status == 'SELESAI')
                                            <span class="text-dark font-weight-bold">
                                                {{ \Carbon\Carbon::parse($item->tgl_kembali ?? $item->updated_at)->format('d/m/y') }}
                                            </span>
                                        @else
                                            <span class="text-xxs text-muted font-weight-bold">- Belum Kembali -</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @php
                                            $statusClass = match ($item->status) {
                                                'DIKEMBALIKAN' => 'bg-approved', 
                                                'DIPINJAM' => 'bg-waiting',     
                                                'WAITING' => 'bg-pending',      
                                                'TERLAMBAT' => 'bg-late',        
                                                default => 'bg-pending',
                                            };
                                        @endphp
                                        <span class="badge-status {{ $statusClass }} shadow-sm">{{ $item->status }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="{{ $item->denda > 0 ? 'text-danger' : 'text-dark' }} font-weight-bold">
                                            Rp {{ number_format(abs($item->denda), 0, ',', '.') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <p class="text-muted mb-0">Wah, sepertinya Anda tidak punya riwayat pinjaman.</p>
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