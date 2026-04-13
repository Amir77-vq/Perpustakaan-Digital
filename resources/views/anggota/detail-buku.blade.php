@extends('layouts.app')

@push('styles')
    <link href="{{ asset('assets/css/style-peminjaman.css') }}?v={{ time() }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style-detail-buku.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid pt-0 py-4">

        <div class="row mb-3">
            <div class="col-12">
                <h3 class="font-weight-bold text-dark mt-n2" style="font-size: 1.5rem;">
                    Detail Buku
                </h3>
            </div>
        </div>

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

                            {{-- Cover --}}
                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="book-cover-wrapper-fixed shadow-lg" style="border-radius: 12px; overflow: hidden; aspect-ratio: 3/4;">
                                    @if($book->cover)
                                        <img src="{{ asset('storage/cover/' . $book->cover) }}"
                                            alt="Cover {{ $book->judul }}" 
                                            class="w-100 h-100" 
                                            style="object-fit: cover;">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" 
                                            style="background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%);">
                                            <i class="fas fa-book text-white fa-4x"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Info Detail --}}
                            <div class="col-lg-9 col-md-8 ps-lg-5">
                                <h4 class="text-dark font-weight-bolder mb-1" style="font-size: 1.6rem;">
                                    {{ $book->judul }}
                                </h4>
                                {{-- Line dipertebal dengan border 2px --}}
                                <div class="pb-3" style="border-bottom: 2px solid #ebeef2;">
                                    <p class="text-xs text-muted mb-0">
                                        Penulis : <span class="text-dark font-weight-bold">{{ $book->penulis }}</span>
                                    </p>
                                </div>

                                <div class="py-3" style="border-bottom: 2px solid #ebeef2;">
                                    <p class="label-custom-small mb-1" style="font-size: 0.85rem; color: #8392ab;">Stok :</p>
                                    <p class="value-custom-small font-weight-bold mb-0" style="color: #344767;">
                                        {{ $book->stok }} Buku
                                    </p>
                                </div>

                                <div class="py-3" style="border-bottom: 2px solid #ebeef2;">
                                    <p class="label-custom-small mb-1" style="font-size: 0.85rem; color: #8392ab;">Status :</p>
                                    <p class="value-custom-small font-weight-bold mb-0 {{ $book->stok > 0 ? 'text-success' : 'text-danger' }}">
                                        {{ $book->stok > 0 ? 'Tersedia untuk Dipinjam' : 'Sedang Habis' }}
                                    </p>
                                </div>

                                {{-- Container Tombol - Shadow dihapus total untuk menghindari bias warna --}}
                                <div class="d-flex gap-2 mt-5">
                                    @if($book->stok > 0)
                                        <a href="{{ route('buku.ajukan', ['id' => $book->id, 'from' => $dari]) }}"
                                            class="btn btn-primary mb-0 shadow-none"
                                            style="background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%); border-radius: 8px; padding: 12px 30px; font-size: 0.8rem; border: none; font-weight: 700; box-shadow: none !important;">
                                            AJUKAN PEMINJAMAN
                                        </a>
                                    @endif

                                    <a href="{{ $dari == 'dashboard' ? '/dashboard' : '/buku' }}" 
                                        class="btn btn-outline-secondary mb-0 shadow-none" 
                                        style="border-radius: 8px; padding: 12px 30px; font-size: 0.8rem; font-weight: 700; border: 1.5px solid #d2d6da; color: #344767; background: transparent; box-shadow: none !important;">
                                        KEMBALI
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection