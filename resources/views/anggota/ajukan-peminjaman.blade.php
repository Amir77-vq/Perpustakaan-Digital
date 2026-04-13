@extends('layouts.app')

@push('styles')
    <link href="{{ asset('assets/css/style-ajukan-peminjaman.css') }}?v={{ time() }}" rel="stylesheet">
    <style>
        /* Samakan persis dengan Detail Buku: Hapus shadow total saat diklik/hover/focus */
        .btn-no-bias:focus, 
        .btn-no-bias:active, 
        .btn-no-bias:hover,
        .btn-no-bias.active {
            box-shadow: none !important;
            outline: none !important;
            opacity: 0.85; /* Memberi sedikit feedback visual tanpa bias warna */
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid pt-0 py-4" id="peminjaman-page">
        <h3 class="font-weight-bold text-dark" style="font-size: 1.5rem; margin-top: -20px; margin-bottom: 30px;">
            Ajukan Peminjaman
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
                        <div class="row mt-1">
                            <div class="col-lg-3 col-md-4 mb-4 text-center">
                                <div class="book-cover-preview">
                                    @if($book->cover)
                                        <img src="{{ asset('storage/cover/' . $book->cover) }}"
                                            class="img-fluid shadow-lg" 
                                            style="border-radius: 0.75rem; aspect-ratio: 3/4; object-fit: cover; width: 100%;">
                                    @else
                                        <div class="no-cover d-flex align-items-center justify-content-center text-white shadow-lg"
                                                style="width: 100%; aspect-ratio: 3/4; background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%); border-radius: 0.75rem;">
                                                <i class="fas fa-book fa-4x"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-9 col-md-8 ps-lg-5">
                                <h4 class="text-dark font-weight-bolder mb-1" style="font-size: 1.6rem;">{{ $book->judul }}</h4>
                                
                                {{-- Line disamakan dengan contoh Detail Buku (Padding bottom 3) --}}
                                <div class="pb-3 mb-4" style="border-bottom: 2px solid #ebeef2;">
                                    <p class="text-xs text-muted mb-0">Penulis : <span class="text-dark font-weight-bold">{{ $book->penulis }}</span></p>
                                </div>

                                <form action="{{ route('peminjaman.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_buku" value="{{ $book->id }}">

                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="label-custom-small" style="font-weight: 700; color: #344767;">Tanggal Pinjam</label>
                                            <input type="date" name="tgl_pinjam" class="form-control border p-2 w-100"
                                                    value="{{ date('Y-m-d') }}" readonly required 
                                                    style="background-color: #f8f9fa; border-radius: 6px;">
                                        </div>
                                        <div class="col-12 mb-4">
                                            <label class="label-custom-small" style="font-weight: 700; color: #344767;">Tanggal Kembali</label>
                                            <input type="date" name="jatuh_tempo" class="form-control border p-2 w-100"
                                                    value="{{ date('Y-m-d', strtotime('+7 days')) }}" required
                                                    style="border-radius: 6px;">
                                        </div>
                                    </div>

                                    {{-- Container Tombol - Shadow dihapus total persis Detail Buku --}}
                                    <div class="d-flex gap-2 mt-2">
                                        <button type="submit" class="btn btn-primary mb-0 shadow-none btn-no-bias"
                                                {{ $book->stok > 0 ? '' : 'disabled' }}
                                                style="background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%); border-radius: 8px; padding: 12px 30px; font-size: 0.8rem; border: none; font-weight: 700; box-shadow: none !important;">
                                            {{ $book->stok > 0 ? 'KONFIRMASI PINJAM' : 'STOK HABIS' }}
                                        </button>

                                        <a href="{{ route('buku.show', ['id' => $book->id, 'from' => $dari ?? 'katalog']) }}"
                                            class="btn btn-outline-secondary mb-0 shadow-none btn-no-bias"
                                            style="border-radius: 8px; padding: 12px 30px; font-size: 0.8rem; font-weight: 700; border: 1.5px solid #d2d6da; color: #344767; background: transparent; box-shadow: none !important;">
                                            BATAL
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection