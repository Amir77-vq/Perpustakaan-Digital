@extends('layouts.app')

@section('content')
<div class="container-fluid pt-0 py-4" id="pengembalian-page">
    <h3 class="font-weight-bold text-dark mt-n2 mb-4" style="font-size: 1.5rem;">
        Ajukan Pengembalian
    </h3>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius: 1rem;">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3"
                        style="background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%); min-height: 50px;">
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-start">
                        {{-- Cover Buku --}}
                        <div class="col-lg-3 col-md-4 mb-4">
                            <div class="book-cover-preview shadow-sm">
                                {{-- PERBAIKAN: Jalur ke storage sesuai update sebelumnya --}}
                                @if($book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->judul }}">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-light" style="min-height: 250px; border-radius: 1rem;">
                                        <i class="fas fa-book fa-3x text-secondary mb-2"></i>
                                        <p class="text-xs text-secondary mb-0">No Cover</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Info Pengembalian --}}
                        <div class="col-lg-9 col-md-8 ps-lg-5">
                            <h4 class="text-dark font-weight-bolder mb-1" style="font-size: 1.6rem;">{{ $book->judul }}</h4>
                            <p class="text-sm text-muted mb-3">Penulis : <span class="text-dark font-weight-bold">{{ $book->penulis }}</span></p>

                            <hr class="horizontal-custom my-4" style="border-top: 1px solid #f0f2f5;">

                            <div class="mb-3">
                                <p class="font-weight-bold mb-1 text-uppercase text-xs text-muted">Periode Peminjaman</p>
                                <p class="text-dark font-weight-bold" style="font-size: 1.1rem;">
                                    {{ date('d M Y', strtotime($peminjaman->tgl_pinjam)) }} — {{ date('d M Y', strtotime($peminjaman->jatuh_tempo)) }}
                                </p>
                            </div>

                            <hr class="horizontal-custom my-4" style="border-top: 1px solid #f0f2f5;">

                            {{-- --- LOGIKA TAMPILAN DENDA --- --}}
                            @if($terlambat > 0)
                                <div class="alert-denda-pembayaran p-4 border-radius-lg mb-4" style="background-color: #fff5f5; border: 1px solid #ffe3e3;">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-danger-soft text-danger me-2" style="background-color: #fee2e2;">Terlambat {{ $terlambat }} Hari</span>
                                    </div>

                                    <h5 class="font-weight-bolder text-danger mb-3" style="font-size: 1.25rem;">
                                        Total Denda : Rp {{ number_format($denda, 0, ',', '.') }}
                                    </h5>

                                    <div class="text-sm text-dark p-3 bg-white border-radius-lg shadow-sm">
                                        <p class="font-weight-bold mb-2 text-xs text-uppercase text-muted">Instruksi Pembayaran</p>
                                        <p class="mb-1 text-dark">Silakan lakukan pembayaran denda melalui kasir atau transfer:</p>
                                        <p class="font-weight-bold text-dark mb-0">Bank BCA: 1234-567-890 (A.N. Perpustakaan Digital)</p>
                                        <p class="text-xs text-muted mt-2">*Lampirkan bukti bayar saat menyerahkan buku ke petugas.</p>
                                    </div>
                                </div>

                                <form action="{{ route('pengembalian.proses', $peminjaman->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_peminjaman" value="{{ $peminjaman->id }}">

                                    <div class="d-flex gap-2 mt-4">
                                        <button type="submit" class="btn btn-denda mb-0"
                                            style="border-radius: 6px; padding: 12px 30px; font-size: 0.8rem; font-weight: 700;">
                                            PROSES & BAYAR DENDA
                                        </button>
                                        <a href="{{ route('pengembalian.index') }}" class="btn btn-outline-secondary mb-0"
                                            style="border-radius: 6px; padding: 12px 30px; font-size: 0.8rem; font-weight: 700;">
                                            Batal
                                        </a>
                                    </div>
                                </form>

                            @else
                                <div class="mb-3 p-3 bg-light border-radius-lg shadow-none border" style="background-color: #f0fff4 !important; border-color: #c6f6d5 !important;">
                                    <p class="text-success font-weight-bold mb-0" style="font-size: 1rem;">
                                        <i class="fas fa-check-circle me-1"></i> Tepat Waktu. Tidak ada denda.
                                    </p>
                                </div>

                                <form action="{{ route('pengembalian.proses', $peminjaman->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_peminjaman" value="{{ $peminjaman->id }}">

                                    <div class="d-flex gap-2 mt-4">
                                        <button type="submit" class="btn btn-proses-simpel mb-0"
                                            style="border-radius: 6px; padding: 12px 30px; font-size: 0.8rem; font-weight: 700;">
                                            KEMBALIKAN BUKU
                                        </button>
                                        <a href="{{ route('pengembalian.index') }}" class="btn btn-outline-secondary mb-0"
                                            style="border-radius: 6px; padding: 12px 30px; font-size: 0.8rem; font-weight: 700;">
                                            Batal
                                        </a>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Tombol Biru Gradasi */
    #pengembalian-page .btn-proses-simpel {
        background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%) !important;
        color: #fff !important;
        border: none !important;
    }
    
    /* Tombol Denda (Merah-Oranye) */
    #pengembalian-page .btn-denda {
        background: linear-gradient(310deg, #ea0606 0%, #ff667c 100%) !important;
        color: #fff !important;
        border: none !important;
    }

    #pengembalian-page .btn-proses-simpel:active, 
    #pengembalian-page .btn-denda:active {
        transform: scale(0.98);
        filter: brightness(1.1);
    }

    /* Fix Layout Cover */
    #pengembalian-page .book-cover-preview {
        aspect-ratio: 3/4;
        border-radius: 1rem;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    #pengembalian-page .book-cover-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endpush
@endsection