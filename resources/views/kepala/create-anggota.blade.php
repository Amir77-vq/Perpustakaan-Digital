@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/style-petugas-anggota.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/validation-anggota.js') }}"></script>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row mt-5 justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius: 15px; background: #fff;">
                
                <div class="mx-3 position-relative z-index-2">
                    <div class="px-4 d-flex align-items-center card-header-gradient">
                        <div class="icon icon-shape bg-white shadow text-center border-radius-md d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                            <i class="fas fa-user-plus text-primary" style="font-size: 20px;"></i>
                        </div>
                        <h5 class="text-white mb-0 font-weight-bold">Tambah Pengguna Baru</h5>
                    </div>
                </div>
                <div class="card-body pt-5 pb-5 px-5">
                    <form id="formUser" action="{{ route('anggota.store') }}" method="POST" novalidate>
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="label-custom">NAMA LENGKAP</label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-custom"><i class="fas fa-user"></i></span>
                                    <input type="text" name="name" class="form-control input-field-custom @error('name') is-invalid-custom @enderror" placeholder="" value="{{ old('name') }}" required>
                                </div>
                                <small class="error-text-custom" style="color: #dc3545; display: none; font-size: 12px; margin-top: 5px;">Data ini wajib diisi.</small>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="label-custom">ALAMAT EMAIL</label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-custom"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control input-field-custom @error('email') is-invalid-custom @enderror" placeholder="" value="{{ old('email') }}" required>
                                </div>
                                <small class="error-text-custom" style="color: #dc3545; display: none; font-size: 12px; margin-top: 5px;">Format alamat email tidak valid.</small>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="label-custom">HAK AKSES (ROLE)</label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-custom"><i class="fas fa-user-tag"></i></span>
                                    <select name="role" class="form-control input-field-custom @error('role') is-invalid-custom @enderror" required style="appearance: auto !important; -webkit-appearance: auto !important; padding-right: 10px !important;">
                                        <option value="" selected disabled>Pilih Hak Akses</option>
                                        <option value="kepala" {{ old('role') == 'kepala' ? 'selected' : '' }}>Kepala</option>
                                        <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                        <option value="anggota" {{ old('role') == 'anggota' ? 'selected' : '' }}>Anggota</option>
                                    </select>
                                </div>
                                <small class="error-text-custom" style="color: #dc3545; display: none; font-size: 12px; margin-top: 5px;">Silakan pilih hak akses pengguna.</small>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="label-custom">KATA SANDI</label>
                                <div class="input-group">
                                    <span class="input-group-text input-group-text-custom"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" class="form-control input-field-custom @error('password') is-invalid-custom @enderror" placeholder="" value="{{ old('password') }}" required>
                                </div>
                                <small class="error-text-custom" style="color: #dc3545; display: none; font-size: 12px; margin-top: 5px;">Kata sandi wajib diisi.</small>
                            </div>
                        </div>
                        <hr class="horizontal dark my-4" style="opacity: 0.2;">
                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('kepala.anggota') }}" class="btn btn-link text-secondary mb-0 font-weight-bold" style="text-transform: none; font-size: 14px;">
                                Batal
                            </a>
                            <button type="submit" class="btn mb-0 px-5 text-white shadow" 
                                style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; font-weight: bold; text-transform: uppercase; border: none; height: 45px;">
                                SIMPAN USER
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .input-group-text-custom {
        background: #f8f9fa;
        border: 1px solid #d2d6da;
        border-right: none;
        border-radius: 10px 0 0 10px;
        color: #344767;
        padding: 0 20px;
        display: flex;
        align-items: center;
    }
    .input-field-custom {
        border-radius: 0 10px 10px 0 !important;
        border: 1px solid #d2d6da !important;
        height: 48px !important;
        font-size: 14px !important;
    }
    .card-header-gradient {
        background: linear-gradient(310deg, #2152ff, #21d4fd);
        border-radius: 12px;
        min-height: 85px;
        margin-top: -35px;
        box-shadow: 0 4px 15px rgba(33, 82, 255, 0.3);
    }
    .label-custom {
        font-weight: 700;
        color: #344767;
        margin-bottom: 8px;
        font-size: 13px;
        display: block;
        letter-spacing: 0.5px;
    }
    select.input-field-custom {
        padding-top: 10px;
        padding-bottom: 10px;
        cursor: pointer;
    }
    .input-field-custom:focus {
        border-color: #2152ff !important;
        box-shadow: 0 0 0 3px rgba(33, 82, 255, 0.15) !important;
    }
    .input-group:focus-within .input-group-text-custom {
        border-color: #2152ff;
        color: #2152ff;
    }
</style>