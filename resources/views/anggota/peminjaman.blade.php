@extends('layouts.app')

@push('styles')
    <link href="{{ asset('assets/css/style-anggota-peminjaman.css') }}?v={{ time() }}" rel="stylesheet">
    <style>
        /* Style Badge Status agar mirip foto */
        .badge-status {
            padding: 5px 12px;
            border-radius: 6px;
            color: white;
            font-weight: 700;
            display: inline-block;
            text-align: center;
        }
        /* Warna Kuning untuk Menunggu */
        .bg-waiting {
            background-color: #f6e05e; /* Kuning cerah sesuai foto */
            color: #ffffff;
        }
        /* Warna Hijau untuk Disetujui */
        .bg-approved {
            background-color: #48bb78; /* Hijau sesuai foto */
            color: #ffffff;
        }
        /* Warna Merah untuk Ditolak */
        .bg-rejected {
            background-color: #f56565;
            color: #ffffff;
        }
        .table-peminjaman tr {
            border-bottom: 1px solid #e2e8f0;
        }
        .judul-buku-bold {
            color: #2d3748;
            font-weight: 700;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/search-peminjaman.js') }}"></script>
@endpush

@section('content')
<div class="container-fluid">
    
    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">Peminjaman Buku</h3>
    <p class="text-muted mb-4" style="font-size: 0.8rem;">Lihat daftar buku yg sedang atau pernah Anda pinjam.</p>

    <div class="card card-peminjaman border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-header header-peminjaman d-flex justify-content-between align-items-center" style="background: #3b82f6; padding: 20px;">
            <h5 class="text-white mb-0" style="font-weight: 600; font-size: 1rem;">Status Peminjaman</h5>
            <div class="form-group mb-0">
                <input type="text" class="form-control form-control-sm search-peminjaman" placeholder="Search.." 
                    style="font-size: 0.75rem; border-radius: 8px; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: white;">
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-borderless table-peminjaman mb-0">
                    <thead>
                        <tr class="text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px; border-bottom: 2px solid #edf2f7;">
                            <th class="pl-4 py-4 font-weight-bold text-uppercase">NO</th>
                            <th class="py-4 font-weight-bold text-uppercase">JUDUL BUKU</th>
                            <th class="py-4 text-center font-weight-bold text-uppercase">TANGGAL PINJAM</th>
                            <th class="py-4 text-center font-weight-bold text-uppercase">JATUH TEMPO</th>
                            <th class="py-4 text-center font-weight-bold text-uppercase">STATUS</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 0.85rem;">
                        @forelse($peminjamans as $key => $item)
                        <tr>
                            <td class="align-middle pl-4 text-dark font-weight-bold">{{ $key + 1 }}</td>
                            <td class="align-middle judul-buku-bold">{{ $item->judul_buku }}</td>
                            <td class="align-middle text-center text-secondary">
                                {{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/y') }}
                            </td>
                            <td class="align-middle text-center text-secondary">
                                {{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d/m/y') }}
                            </td>
                            <td class="align-middle text-center">
                                {{-- Logika Warna Status --}}
                                @if($item->status == 'MENUNGGU' || $item->status == 'PENDING')
                                    <span class="badge-status bg-waiting" style="font-size: 0.65rem; min-width: 90px;">MENUNGGU</span>
                                @elseif($item->status == 'DI SETUJUI' || $item->status == 'DIPINJAM')
                                    <span class="badge-status bg-approved" style="font-size: 0.65rem; min-width: 90px;">DI SETUJUI</span>
                                @elseif($item->status == 'DI TOLAK')
                                    <span class="badge-status bg-rejected" style="font-size: 0.65rem; min-width: 90px;">DI TOLAK</span>
                                @else
                                    <span class="badge-status bg-secondary" style="font-size: 0.65rem; min-width: 90px;">{{ $item->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data peminjaman buku.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection