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
          <h4 class="mb-0 font-weight-bolder text-dark">Rp {{ number_format($totalDenda, 0, ',', '.') }}</h4>
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
      <div class="card rekom-card shadow-sm">
        <div class="rekom-cover-wrapper" style="height: 300px; overflow: hidden; border-radius: 10px 10px 0 0;">
            @if($book->cover)
                {{-- PERBAIKAN DISINI: Pakai storage/ --}}
                <img src="{{ asset('storage/' . $book->cover) }}" class="w-100 h-100" style="object-fit: cover;">
            @else
                <div class="w-100 h-100 no-cover-blue" style="background: #e9ecef; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-book text-secondary"></i>
                </div>
            @endif
        </div>
        <div class="card-body">
          <h6 class="mb-0 text-sm font-weight-bold text-dark">{{ $book->judul }}</h6>
          <p class="text-xs text-secondary mb-1">{{ $book->penulis }}</p>
          
          <div class="d-flex justify-content-between align-items-center mt-3">
            <p class="text-xs font-weight-bold mb-0 {{ $book->stok > 0 ? 'text-info' : 'text-danger' }}">
              {{ $book->stok > 0 ? 'Tersedia' : 'Tidak Tersedia' }}
            </p>
            
            <a href="{{ route('buku.show', ['id' => $book->id, 'from' => 'dashboard']) }}" 
                class="btn btn-sm mb-0 px-3 text-white font-weight-bold" 
                style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 8px; text-transform: none; font-size: 0.7rem;">
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
            style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 6px; min-height: 60px; margin-top: -25px;">
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
                  <tr style="border-bottom: 1px solid #f8f9fa;">
                    <td class="ps-3 py-2">
                      <p class="text-xs font-weight-bold mb-0 text-dark">{{ $loan->buku->judul ?? 'Buku Dihapus' }}</p>
                    </td>
                    <td class="align-middle text-center py-2">
                      <div class="d-inline-block shadow-sm" style="width: 30px; height: 42px; background-color: #2152ff; border-radius: 3px; overflow: hidden;">
                        @if($loan->buku && $loan->buku->cover)
                          {{-- PERBAIKAN DISINI JUGA --}}
                          <img src="{{ asset('storage/' . $loan->buku->cover) }}" class="w-100 h-100" style="object-fit: cover;">
                        @endif
                      </div>
                    </td>
                    <td class="align-middle text-center py-2">
                      <span class="badge" style="background-color: {{ $loan->status == 'dipinjam' ? '#66bb6a' : '#596c76' }}; color: #fff; border-radius: 4px; padding: 4px 8px; font-size: 8px; font-weight: 700;">
                        {{ strtoupper($loan->status) }}
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