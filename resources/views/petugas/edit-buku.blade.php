@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/style-create-buku.css') }}">
  <style>
    .form-control:focus {
        border-color: #2152ff !important;
        box-shadow: 0 0 0 2px rgba(33, 82, 255, 0.2);
    }
    .preview-container {
        position: relative;
        display: inline-block;
    }
    #image-preview {
        transition: all 0.3s ease;
    }
  </style>
@endpush

@section('content')
  <div class="container-fluid py-4">
    <div class="row mt-2 justify-content-center">
      <div class="col-lg-10 col-12"> {{-- Sedikit lebih ramping biar fokus --}}
        <div class="card shadow-lg border-0" style="border-radius: 15px; background: #fff;">

          {{-- Header Biru Dinamis --}}
          <div class="mx-3 position-relative z-index-2">
            <div class="px-4 d-flex align-items-center justify-content-between"
              style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 90px; margin-top: -30px; box-shadow: 0 8px 26px -4px rgba(20,20,20,0.15), 0 8px 9px -5px rgba(20,20,20,0.06);">
              <div>
                <h5 class="text-white mb-0 font-weight-bold">Edit Data Buku</h5>
                <p class="text-white text-xs mb-0 opacity-8">ID Buku: #{{ $buku->id }} | {{ $buku->judul }}</p>
              </div>
              <i class="fas fa-edit text-white opacity-5 fa-2x"></i>
            </div>
          </div>

          <div class="card-body pt-5 pb-4 px-5">
            <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <div class="row">
                {{-- Bagian Kiri: Input Data --}}
                <div class="col-md-8">
                  {{-- Judul Buku --}}
                  <div class="form-group mb-4">
                    <label class="font-weight-bold text-dark text-sm">Judul Buku</label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                      style="border: 1px solid #d2d6da; border-radius: 8px; padding: 12px 15px;"
                      value="{{ old('judul', $buku->judul) }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>

                  {{-- Penulis --}}
                  <div class="form-group mb-4">
                    <label class="font-weight-bold text-dark text-sm">Penulis</label>
                    <input type="text" name="penulis" class="form-control @error('penulis') is-invalid @enderror"
                      style="border: 1px solid #d2d6da; border-radius: 8px; padding: 12px 15px;"
                      value="{{ old('penulis', $buku->penulis) }}" required>
                    @error('penulis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      {{-- Stok --}}
                      <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark text-sm">Stok Buku</label>
                        <input type="number" name="stok" class="form-control"
                          style="border: 1px solid #d2d6da; border-radius: 8px; padding: 12px 15px;"
                          value="{{ old('stok', $buku->stok) }}" required>
                      </div>
                    </div>
                  </div>
                </div>

                {{-- Bagian Kanan: Preview Cover --}}
                <div class="col-md-4 text-center">
                    <label class="font-weight-bold text-dark text-sm d-block mb-3">Cover Saat Ini</label>
                    <div class="preview-container mb-3">
                        @if($buku->cover)
                            <img id="image-preview" src="{{ asset('storage/cover/' . $book->cover) }}" 
                                  class="rounded shadow border" 
                                  style="width: 150px; height: 210px; object-fit: cover;">
                        @else
                            <div id="image-preview-placeholder" class="rounded bg-light d-flex align-items-center justify-content-center border" 
                                  style="width: 150px; height: 210px; margin: 0 auto;">
                                <i class="fas fa-image fa-3x text-secondary opacity-3"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="custom-file mt-2">
                        <input type="file" name="cover" id="cover-input" class="form-control text-xs" 
                                style="border-radius: 8px;" onchange="previewImage(this)">
                        <small class="text-muted d-block mt-2" style="font-size: 10px; line-height: 1.4;">
                            *Klik untuk ganti cover<br>Kosongkan jika tetap menggunakan <strong>{{ $buku->judul }}</strong>
                        </small>
                    </div>
                </div>
              </div>

              <hr class="horizontal dark my-4">

              <div class="d-flex justify-content-end align-items-center gap-3">
                <a href="{{ route('petugas.buku') }}" class="btn btn-link text-secondary mb-0 font-weight-bold text-decoration-none">
                  Batal
                </a>
                <button type="submit" class="btn btn-sm mb-0 px-5 py-3 shadow-sm"
                  style="background: linear-gradient(310deg, #2152ff, #21d4fd); color: #fff; border-radius: 10px; font-weight: bold; text-transform: uppercase; border: none; letter-spacing: 1px;">
                  SIMPAN PERUBAHAN
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                let preview = document.getElementById('image-preview');
                if(!preview) {
                    let container = document.querySelector('.preview-container');
                    container.innerHTML = `<img id="image-preview" src="${e.target.result}" class="rounded shadow border" style="width: 150px; height: 210px; object-fit: cover;">`;
                } else {
                    preview.src = e.target.result;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
  </script>
@endsection