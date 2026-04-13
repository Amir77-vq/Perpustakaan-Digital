<div class="card rekom-card shadow-sm border-0 h-100" style="border-radius: 12px; margin-top: 15px; transition: transform 0.2s ease;">
    <div class="card-body p-3">
        <div class="d-flex gap-3">
            <div class="rekom-cover-wrapper shadow-lg" 
                    style="width: 85px; height: 115px; flex-shrink: 0; background: #f0f2f5; border-radius: 8px; overflow: hidden; margin-top: -35px; z-index: 2; box-shadow: 0 8px 20px -8px rgba(0,0,0,0.3) !important;">
                @if($book->cover)
                    <img src="{{ asset('assets/cover/' . $book->cover) }}" class="w-100 h-100" style="object-fit: cover;">
                @else
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(310deg, #2152ff, #21d4fd);">
                        <i class="fas fa-book text-white"></i>
                    </div>
                @endif
            </div>

            <div class="book-info overflow-hidden d-flex flex-column justify-content-between py-1" style="margin-top: -5px;">
                <div>
                    <h6 class="mb-0 text-sm font-weight-bold text-dark text-truncate">{{ $book->judul }}</h6>
                    <p class="text-xs text-secondary mb-0 text-truncate">{{ $book->penulis }}</p>
                </div>
                
                <div class="mt-2">
                    <div class="d-flex align-items-center">
                        {{-- Bulat hijau/merah sejajar dengan teks --}}
                        <span class="status-dot" style="width: 7px; height: 7px; border-radius: 50%; display: inline-block; background-color: {{ $book->stok > 0 ? '#4caf50' : '#f44336' }}; flex-shrink: 0;"></span>
                        <div class="ms-2">
                            <span class="text-xs font-weight-bold {{ $book->stok > 0 ? 'text-success' : 'text-danger' }}" style="line-height: 1; display: block;">
                                {{ $book->stok > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3">
            @if($book->stok > 0)
                <a href="{{ route('buku.show', $book->id) }}" class="btn btn-sm w-100 mb-0 text-white shadow-none" 
                    style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 6px; text-transform: none; font-weight: 700;">
                    Detail
                </a>
            @else
                <button class="btn btn-sm w-100 mb-0 text-white bg-gradient-secondary shadow-none" disabled style="border-radius: 6px; text-transform: none;">
                    Habis
                </button>
            @endif
        </div>
    </div>
</div>