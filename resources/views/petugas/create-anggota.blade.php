@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/style-petugas-anggota.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/js/validation-anggota.js') }}"></script>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row mt-2 justify-content-center">
        <div class="col-lg-12 col-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px; background: #fff;">
                
                <div class="mx-3 position-relative z-index-2">
                    <div class="px-4 d-flex align-items-center" 
                        style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 80px; margin-top: -30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <h5 class="text-white mb-0 font-weight-bold">Tambah Anggota</h5>
                    </div>
                </div>

                <div class="card-body pt-5 pb-4 px-5">
                    <form action="{{ route('anggota.store') }}" method="POST" novalidate>
                        @csrf
                        
                        {{-- Nama --}}
                        <div class="row mb-4 align-items-center">
                            <div class="col-auto" style="min-width: 120px;">
                                <label class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Nama</label>
                            </div>
                            <div class="col">
                                <input type="text" name="name" class="form-control input-field-custom @error('name') is-invalid-custom @enderror" value="{{ old('name') }}" required>
                                <small class="error-text-custom">@error('name') {{ $message }} @else Mohon lengkapi data ini. @enderror</small>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="row mb-4 align-items-center">
                            <div class="col-auto" style="min-width: 120px;">
                                <label class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Alamat</label>
                            </div>
                            <div class="col">
                                <input type="text" name="alamat" class="form-control input-field-custom @error('alamat') is-invalid-custom @enderror" value="{{ old('alamat') }}" required>
                                <small class="error-text-custom">@error('alamat') {{ $message }} @else Mohon lengkapi data ini. @enderror</small>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row mb-4 align-items-center">
                            <div class="col-auto" style="min-width: 120px;">
                                <label class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Email</label>
                            </div>
                            <div class="col">
                                <input type="email" name="email" class="form-control input-field-custom @error('email') is-invalid-custom @enderror" value="{{ old('email') }}" required>
                                <small class="error-text-custom">@error('email') {{ $message }} @else Mohon lengkapi data ini. @enderror</small>
                            </div>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="row mb-4 align-items-center">
                            <div class="col-auto" style="min-width: 120px;">
                                <label class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Password</label>
                            </div>
                            <div class="col">
                                <input type="password" name="password" 
                                        class="form-control input-field-custom @error('password') is-invalid-custom @enderror" 
                                        value="{{ old('password') }}" required> 
                                @error('password')
                                    <small class="text-danger" style="font-size: 12px;">{{ $message }}</small>
                                @else
                                    <small class="error-text-custom">Password minimal harus 6 karakter.</small>
                                @enderror
                            </div>
                        </div>

                        {{-- No HP --}}
                        <div class="row mb-4 align-items-center">
                            <div class="col-auto" style="min-width: 120px;">
                                <label class="font-weight-bold text-dark mb-0" style="font-size: 14px;">No HP</label>
                            </div>
                            <div class="col">
                                <input type="text" name="no_hp" id="no_hp_input" 
                                    class="form-control input-field-custom @error('no_hp') is-invalid-custom @enderror" 
                                    style="max-width: 250px !important;" value="{{ old('no_hp') }}" required>
                                
                                <small class="error-text-custom" id="no_hp_error">
                                    @error('no_hp') {{ $message }} @else Nomor HP harus diawali dengan 08 dan hanya angka. @enderror
                                </small>
                            </div>
                        </div>

                        {{-- LINE PEMBATAS --}}
                        <div style="width: 100%; height: 1px; background-color: #d2d6da !important; margin: 30px 0; display: block !important; opacity: 1 !important;"></div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('petugas.anggota') }}" class="btn btn-sm mb-0 px-4 py-2" 
                                style="border: 1px solid #344767; color: #344767; background: #fff; border-radius: 8px; font-weight: bold; text-transform: none;">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-sm mb-0 px-5 py-2 text-white" 
                                style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 8px; font-weight: bold; text-transform: uppercase; border: none;">
                                SIMPAN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection