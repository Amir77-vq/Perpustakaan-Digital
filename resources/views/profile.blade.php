@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        {{-- Header Profil --}}
        <div class="col-12 mb-4">
            <div class="card card-body shadow-sm border-radius-xl p-3" style="background: linear-gradient(310deg, #2152ff, #21d4fd);">
                <div class="row gx-4 align-items-center">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative bg-white shadow-sm d-flex align-items-center justify-content-center" style="width: 74px; height: 74px; border-radius: 12px;">
                            <i class="fas fa-user text-primary" style="font-size: 30px;"></i>
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1 text-white font-weight-bolder">
                                {{ auth()->user()->nama ?? auth()->user()->name }}
                            </h5>
                            <p class="mb-0 font-weight-bold text-xs text-white opacity-8">
                                {{ strtoupper(auth()->user()->role) }} | ID: #{{ auth()->user()->id }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Edit Profil --}}
        <div class="col-lg-8">
            @if(session('success'))
                
            @endif

            <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                <div class="card-header pb-0 p-3 bg-transparent border-0">
                    <h6 class="mb-0 font-weight-bold text-dark">Pengaturan Akun</h6>
                </div>
                <div class="card-body p-3">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label text-xs text-secondary font-weight-bolder opacity-7">NAMA LENGKAP</label>
                                <input class="form-control form-control-sm" type="text" name="nama" value="{{ auth()->user()->nama ?? auth()->user()->name }}" style="border-radius: 8px; border: 1px solid #d2d6da !important;" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label text-xs text-secondary font-weight-bolder opacity-7">EMAIL</label>
                                <input class="form-control form-control-sm" type="email" name="email" value="{{ auth()->user()->email }}" style="border-radius: 8px; border: 1px solid #d2d6da !important;" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label text-xs text-secondary font-weight-bolder opacity-7">UBAH PASSWORD</label>
                                <input class="form-control form-control-sm" type="password" name="password" placeholder="••••••••" style="border-radius: 8px; border: 1px solid #d2d6da !important;" autocomplete="new-password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label text-xs text-secondary font-weight-bolder opacity-7">KONFIRMASI PASSWORD</label>
                                <input class="form-control form-control-sm" type="password" name="password_confirmation" placeholder="••••••••" style="border-radius: 8px; border: 1px solid #d2d6da !important;">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end align-items-center mt-4 gap-2">
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light px-4 mb-0" style="border-radius: 8px; text-transform: none; border: 1px solid #d2d6da;">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-sm text-white px-4 mb-0" style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 8px; text-transform: none; font-weight: 700; border: none;">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Kartu Status --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 12px;">
                <div class="card-body p-3 text-center d-flex flex-column justify-content-center">
                    <div class="p-3 border-radius-lg mb-4" style="background: #f8f9fa;">
                        <p class="text-xs font-weight-bold text-secondary mb-1">TERDAFTAR SEJAK</p>
                        <h6 class="text-sm font-weight-bolder text-dark">{{ auth()->user()->created_at->format('d M Y') }}</h6>
                    </div>
                    <span class="badge py-3" style="background-color: #2dce89; color: #fff; border-radius: 8px; font-size: 10px; font-weight: 800;">
                        STATUS: AKTIF
                    </span>
                    <div class="mt-4 pt-2">
                        <p class="text-xxs text-secondary px-3">
                            Pastikan email Anda tetap aktif untuk menerima notifikasi penting dari sistem perpustakaan digital.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection