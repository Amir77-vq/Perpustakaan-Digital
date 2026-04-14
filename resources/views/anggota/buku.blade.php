@extends('layouts.app')

@push('scripts')
    <script src="{{ asset('assets/js/search-buku.js') }}"></script>
@endpush

@push('styles')
    <link href="{{ asset('assets/css/style-anggota-buku.css') }}?v={{ time() }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid py-2">
        <div class="mb-4">
            <div class="d-flex align-items-center">
                <form action="{{ route('buku.index') }}" method="GET" class="w-100" id="searchForm">
                    <div class="input-group input-group-outline bg-white rounded border" style="max-width: 320px;">
                        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Cari Buku..."
                            value="{{ request('search') }}" style="padding: 10px 15px; border: none; outline: none;"
                            autocomplete="off">
                        <button type="submit" class="btn btn-link text-dark mb-0 px-2 shadow-none">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row" id="bookContainer">
            @forelse ($books as $book)
                <div class="col-xl-3 col-md-4 col-sm-6 mb-4 book-item">
                    <div class="card book-card h-100 shadow-sm border-0"
                        style="border-radius: 12px; transition: transform 0.2s ease;">
                        <div class="card-body p-3">
                            <div class="d-flex gap-3 mb-3">
                                <div class="book-cover-wrapper" style="width: 89px; height: 115px; flex-shrink: 0;">
                                    @if($book->cover)
                                        <img src="{{ asset('storage/cover/' . $book->cover) }}" class="w-100 h-100 shadow-sm"
                                            style="object-fit: cover; border-radius: 8px;"
                                            onerror="this.onerror=null;this.src='{{ asset('assets/img/no-cover.png') }}';">
                                    @else
                                            <div class="w-100 h-100 shadow-sm d-flex align-items-center justify-content-center"
                                                style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 8px;">
                                                <i class="fas fa-book text-white"></i>
                                            </div>
                                        @endif
                                </div>
                                <div class="book-title-info overflow-hidden">
                                    <h6 class="text-sm font-weight-bold mb-1 text-dark text-truncate judul-buku">
                                        {{ $book->judul }}
                                    </h6>
                                    <p class="text-xs text-secondary mb-2 text-truncate penulis-buku"> {{ $book->penulis }}</p>
                                </div>
                            </div>
                            <div class="book-details-bottom">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="status-indicator"
                                        style="width: 8px; height: 8px; border-radius: 50%; display: inline-block; background-color: {{ $book->stok > 0 ? '#4caf50' : '#f44336' }};"></span>
                                    <div class="ms-2">
                                        <p
                                            class="text-xs mb-0 font-weight-bold {{ $book->stok > 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $book->stok > 0 ? 'Tersedia' : 'Habis' }}
                                        </p>
                                        @if($book->stok > 0)
                                            <p class="text-xxs text-secondary mb-0">Stok {{ $book->stok }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 g-2">
                                <div class="col-6">
                                    <a href="{{ route('buku.show', $book->id) }}" class="btn btn-sm w-100 mb-0 shadow-none"
                                        style="background-color: #f0f2f5; color: #344767; text-transform: none; font-weight: 700; border-radius: 6px;">Detail</a>
                                </div>
                                <div class="col-6">
                                    @if($book->stok > 0)
                                        @if($statusBermasalah)
                                            <a href="{{ route('buku.ajukan', $book->id) }}"
                                                class="btn btn-sm w-100 mb-0 shadow-none text-white"
                                                style="background: linear-gradient(310deg, #ea0606, #ff667c); text-transform: none; font-weight: 700; border-radius: 6px;">Pinjam</a>
                                        @else
                                            <a href="{{ route('buku.ajukan', $book->id) }}"
                                                class="btn btn-sm w-100 mb-0 shadow-none text-white"
                                                style="background: linear-gradient(310deg, #2152ff, #21d4fd); text-transform: none; font-weight: 700; border-radius: 6px;">Pinjam</a>
                                        @endif
                                    @else
                                        <button class="btn btn-sm w-100 mb-0 shadow-none text-white" disabled
                                            style="background-color: #d2d6da; text-transform: none; font-weight: 700; border-radius: 6px;">Habis</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h5 class="text-secondary opacity-7">Belum ada buku yang tersedia.</h5>
                </div>
            @endforelse
        </div>

        <div id="jsNoResults" class="row d-none">
            <div class="col-12 d-flex justify-content-center align-items-center" style="min-height: 400px;">
                <div class="text-center">
                    <i class="fas fa-book-open mb-3 text-secondary opacity-4" style="font-size: 4rem;"></i>
                    <h5 class="text-secondary mb-1">Buku tidak ditemukan.</h5>
                    <p class="text-sm text-secondary opacity-8">Coba cari dengan judul atau penulis lain.</p>
                </div>
            </div>
        </div>
    </div>
@endsection