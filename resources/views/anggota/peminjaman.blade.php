@extends('layouts.app')

@push('styles')
    <link href="{{ asset('assets/css/style-anggota-pengembalian.css') }}?v={{ time() }}" rel="stylesheet">
    <style>
        .badge-status {
            padding: 5px 12px;
            border-radius: 6px;
            color: white;
            font-weight: 700;
            display: inline-block;
            text-align: center;
            font-size: 0.65rem;
            min-width: 90px;
        }
        
        /* Gradasi disamakan dengan history sesuai perintah */
        .bg-waiting  { background: linear-gradient(310deg, #fbcf33 0%, #fbb144 100%) !important; color: #ffffff !important; } 
        .bg-approved { background: linear-gradient(310deg, #2dce89 0%, #6decb9 100%) !important; color: #ffffff !important; } 
        .bg-rejected { background: linear-gradient(310deg, #ea0606 0%, #ff667c 100%) !important; color: #ffffff !important; } 

        .table-peminjaman tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/search-peminjaman.js') }}"></script>
@endpush

@section('content')
<div class="container-fluid py-4">
    <h3 class="font-weight-bold text-dark mb-1" style="font-size: 1.5rem;">Peminjaman Buku</h3>
    <p class="text-muted mb-4" style="font-size: 0.8rem;">Lihat daftar buku yg sedang atau pernah Anda pinjam.</p>

    <div class="card card-peminjaman border-0 shadow-lg">
        {{-- Header Melayang --}}
        <div class="card-header header-peminjaman d-flex justify-content-between align-items-center">
            <h5 class="text-white mb-0" style="font-weight: 600; font-size: 0.9rem;">Status Peminjaman</h5>
            <div class="ms-auto">
                <div class="input-group input-group-sm" style="width: 200px;">
                    <input type="text" class="form-control search-peminjaman" placeholder="Cari buku..">
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-peminjaman align-items-center mb-0">
                    <thead>
                        <tr class="text-muted">
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7 ps-4">NO</th>
                            <th class="text-uppercase text-xxs font-weight-bolder opacity-7">JUDUL BUKU</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">TANGGAL PINJAM</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">JATUH TEMPO</th>
                            <th class="text-center text-uppercase text-xxs font-weight-bolder opacity-7">STATUS</th>
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
                            <td class="align-middle text-center text-secondary">
                                {{ \Carbon\Carbon::parse($item->jatuh_tempo)->format('d/m/y') }}
                            </td>
                            <td class="align-middle text-center">
    @if($item->status == 'PENDING')
        <span class="badge-status bg-waiting shadow-sm">PENDING</span>
    @elseif($item->status == 'WAITING')
        <span class="badge-status bg-waiting shadow-sm">WAITING</span>
    @elseif($item->status == 'DI SETUJUI' || $item->status == 'DIPINJAM')
        <span class="badge-status bg-approved shadow-sm">DI SETUJUI</span>
    @elseif($item->status == 'DI TOLAK')
        <span class="badge-status bg-rejected shadow-sm">DI TOLAK</span>
    @else
        <span class="badge-status bg-secondary shadow-sm">{{ $item->status }}</span>
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