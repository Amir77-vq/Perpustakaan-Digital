@extends('layouts.app')

@section('content')

<div class="row stats-section">
  {{-- Total Peminjaman --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card shadow-sm border-radius-xl p-3 stats-card-custom">
      <div class="d-flex align-items-center w-100">
        <div class="icon icon-lg icon-shape bg-dark shadow-dark border-radius-xl mt-n4 position-absolute d-flex justify-content-center align-items-center">
          <i class="fas fa-archive"></i>
        </div>
        <div class="text-end ms-auto">
          <p class="text-sm mb-0 text-secondary">Total Peminjaman</p>
          <h4 class="mb-0 font-weight-bolder text-dark">{{ $totalPeminjaman }}</h4>
        </div>
      </div>
    </div>
  </div>

  {{-- Sedang Dipinjam --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card shadow-sm border-radius-xl p-3 stats-card-custom">
      <div class="d-flex align-items-center w-100">
        <div class="icon icon-lg icon-shape bg-primary shadow-primary border-radius-xl mt-n4 position-absolute d-flex justify-content-center align-items-center" style="background-color: #e91e63 !important;">
          <i class="fas fa-user"></i>
        </div>
        <div class="text-end ms-auto">
          <p class="text-sm mb-0 text-secondary">Sedang di Pinjam</p>
          <h4 class="mb-0 font-weight-bolder text-dark">{{ $sedangDipinjam }}</h4>
        </div>
      </div>
    </div>
  </div>

  {{-- Total Pengembalian --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card shadow-sm border-radius-xl p-3 stats-card-custom">
      <div class="d-flex align-items-center w-100">
        <div class="icon icon-lg icon-shape bg-success shadow-success border-radius-xl mt-n4 position-absolute d-flex justify-content-center align-items-center">
          <i class="fas fa-user-plus"></i>
        </div>
        <div class="text-end ms-auto">
          <p class="text-sm mb-0 text-secondary">Total Pengembalian</p>
          <h4 class="mb-0 font-weight-bolder text-dark">{{ $totalPengembalian }}</h4>
        </div>
      </div>
    </div>
  </div>

  {{-- Total Denda --}}
  <div class="col-xl-3 col-sm-6 mb-4">
    <div class="card shadow-sm border-radius-xl p-3 stats-card-custom">
      <div class="d-flex align-items-center w-100">
        <div class="icon icon-lg icon-shape bg-info shadow-info border-radius-xl mt-n4 position-absolute d-flex justify-content-center align-items-center">
          <i class="fas fa-wallet"></i>
        </div>
        <div class="text-end ms-auto">
          <p class="text-sm mb-0 text-secondary">Total Denda</p>
          <h4 class="mb-0 font-weight-bolder text-dark"> Rp {{ number_format(abs($totalDenda), 0, ',', '.') }}</h4>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Rekomendasi Buku --}}
<div class="mt-4">
  <button class="btn btn-sm mb-4 px-4 text-white" style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 8px; text-transform: none;">Rekomendasi Buku</button>
  
  <div class="row">
    @foreach ($books as $book)
    <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
      <div class="card rekom-card shadow-sm" style="border-radius: 12px;">
        <div class="rekom-cover-wrapper" style="height: 245px; overflow: hidden; border-radius: 12px 12px 0 0;">
            @if($book->cover)
                <img src="{{ asset('storage/cover/' . $book->cover) }}" class="w-100 h-100" style="object-fit: cover;">
            @else
                <div class="w-100 h-100" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-book text-secondary"></i>
                </div>
            @endif
        </div>
        <div class="card-body p-3">
          <h6 class="mb-0 text-sm font-weight-bold text-dark text-truncate">{{ $book->judul }}</h6>
          <p class="text-xs text-secondary mb-2 text-truncate">{{ $book->penulis }}</p>
          
          <div class="d-flex justify-content-between align-items-center mt-3">
            <span class="d-flex align-items-center justify-content-center" 
                  style="background-color: {{ $book->stok > 0 ? '#2dce89' : '#f5365c' }}; color: #fff; width: 80px; height: 30px; border-radius: 6px; font-size: 0.6rem; font-weight: 800; text-transform: uppercase; border: none;">
              {{ $book->stok > 0 ? 'Tersedia' : 'Habis' }}
            </span>
            
            <a href="{{ route('buku.show', ['id' => $book->id, 'from' => 'dashboard']) }}" 
                class="d-flex align-items-center justify-content-center text-white" 
                style="background: linear-gradient(310deg, #2152ff, #21d4fd); width: 80px; height: 30px; border-radius: 6px; text-transform: uppercase; font-size: 0.6rem; font-weight: 800; text-decoration: none;">
                Detail
            </a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>

{{-- Riwayat Peminjaman --}}
<div class="row mt-1 mb-5">
  <div class="col-12">
    <div class="card shadow-sm border-0" style="border-radius: 12px; background: #fff; margin-top: 20px;">
      <div class="mx-3 position-relative z-index-2">
        <div class="peminjaman-header shadow-primary px-3 d-flex align-items-center" 
            style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 6px; min-height: 50px; margin-top: -20px;">
          <h6 class="text-white mb-0 text-xs font-weight-bold" style="letter-spacing: 0.5px;">
              Peminjaman Terakhir
          </h6>
        </div>
      </div>

      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0 mt-3"> 
            <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3 py-2">JUDUL BUKU</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 py-2">COVER</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 py-2">STATUS</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 py-2">JATUH TEMPO</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recentLoans as $loan)
                  @php
                    $statusName = strtoupper($loan->status);
                    
                    $color = match($statusName) {
                        'WAITING'      => '#ffad46',
                        'DIKEMBALIKAN' => '#2dce89', 
                        'DIPINJAM'     => '#1172ef', 
                        'PENDING'      => '#fbb144', 
                        default        => '#adb5bd' 
                    };
                  @endphp
                  <tr style="border-bottom: 1px solid #f8f9fa;">
                    <td class="ps-3 py-2">
                      <p class="text-xs font-weight-bold mb-0 text-dark">{{ $loan->buku->judul ?? 'Buku Dihapus' }}</p>
                    </td>
                    <td class="align-middle text-center py-2">
                      <div class="d-inline-block shadow-sm" style="width: 30px; height: 40px; background-color: #eee; border-radius: 3px; overflow: hidden;">
                        @if($loan->buku && $loan->buku->cover)
                          {{-- FIX: Ditambahkan /cover/ sesuai lokasi folder lu --}}
                          <img src="{{ asset('storage/cover/' . $loan->buku->cover) }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                          <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-book" style="font-size: 10px; color: #ccc;"></i>
                          </div>
                        @endif
                      </div>
                    </td>
                    <td class="align-middle text-center py-2">
                      <span class="badge shadow-sm" style="background-color: {{ $color }}; color: #fff; border-radius: 8px; padding: 6px 12px; font-size: 9px; font-weight: 800; border: none;">
                        {{ $statusName }}
                      </span>
                    </td>
                    <td class="align-middle text-center py-2">
                      <span class="text-secondary text-xxs font-weight-bold">
                        {{ $loan->jatuh_tempo ? date('d/m/Y', strtotime($loan->jatuh_tempo)) : '-' }}
                      </span>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="4" class="text-center py-4">
                      <span class="text-secondary text-xs">Belum ada riwayat peminjaman pribadi.</span>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection