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

                {{-- Header Biru Melayang --}}
                <div class="mx-3 position-relative z-index-2">
                    <div class="px-4 d-flex align-items-center"
                        style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 80px; margin-top: -30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <h5 class="text-white mb-0 font-weight-bold">Edit Data Anggota: {{ $anggota->name }}</h5>
                    </div>
                </div>

                <div class="card-body pt-5 pb-4 px-5">
                    <form action="{{ route('anggota.update', $anggota->id) }}" method="POST" id="formAnggota" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- Nama --}}
                        <div class="row mb-4 align-items-center">
                            <div class="col-auto" style="min-width: 120px;">
                                <label class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Nama</label>
                            </div>
                            <div class="col">
                                <input type="text" name="name" class="form-control input-field-custom @error('name') is-invalid-custom @enderror" 
                                        value="{{ old('name', $anggota->name) }}" required>
                                <small class="error-text-custom">@error('name') {{ $message }} @else Mohon lengkapi data ini. @enderror</small>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="row mb-4 align-items-center">
                            <div class="col-auto" style="min-width: 120px;">
                                <label class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Alamat</label>
                            </div>
                            <div class="col">
                                <input type="text" name="alamat" class="form-control input-field-custom @error('alamat') is-invalid-custom @enderror" 
                                        value="{{ old('alamat', $anggota->alamat) }}" required>
                                <small class="error-text-custom">@error('alamat') {{ $message }} @else Mohon lengkapi data ini. @enderror</small>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row mb-4 align-items-center">
                            <div class="col-auto" style="min-width: 120px;">
                                <label class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Email</label>
                            </div>
                            <div class="col">
                                <input type="email" name="email" class="form-control input-field-custom @error('email') is-invalid-custom @enderror" 
                                        value="{{ old('email', $anggota->email) }}" required>
                                <small class="error-text-custom">@error('email') {{ $message }} @else Mohon lengkapi data ini. @enderror</small>
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="row mb-4 align-items-center">
                            <div class="col-auto" style="min-width: 120px;">
                                <label class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Password</label>
                            </div>
                            <div class="col">
                                <input type="text" name="password" 
                                        class="form-control input-field-custom @error('password') is-invalid-custom @enderror"
                                        value="{{ session('reset_pass') ?? old('password') }}"
                                        placeholder="Isi jika ingin mengubah password">
                                
                                {{-- Notifikasi di dalam tabel/bawah input sudah dihapus agar bersih --}}
                                <small class="error-text-custom">
                                    @if(!session('reset_pass'))
                                        Kosongkan jika tidak ingin mengubah password secara manual.
                                    @endif
                                </small>
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
                                        style="max-width: 250px !important;" value="{{ old('no_hp', $anggota->no_hp) }}" required>
                                <small class="error-text-custom" id="no_hp_error">
                                    @error('no_hp') {{ $message }} @else Nomor HP harus diawali dengan 08 dan hanya angka. @enderror
                                </small>
                            </div>
                        </div>

                        {{-- Line Pembatas --}}
                        <div style="width: 100%; height: 1px; background-color: #d2d6da !important; margin: 30px 0; display: block !important; opacity: 1 !important;"></div>

                        <div class="d-flex justify-content-between align-items-center">
                            {{-- Tombol Reset Password --}}
                            <div>
                                <button type="button" class="btn btn-sm mb-0 px-4 py-2 text-white" 
                                    style="background: linear-gradient(310deg, #f53939, #fb8c00); border: none; border-radius: 8px; font-weight: bold; text-transform: uppercase;"
                                    onclick="event.preventDefault(); if(confirm('Yakin ingin mereset password menjadi perpustakaan444?')) { document.getElementById('form-reset').submit(); }">
                                    RESET PASSWORD
                                </button>
                            </div>

                            {{-- Tombol Batal & Update --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('petugas.anggota') }}"
                                    style="background: #f8f9fa; color: #344767; border: 1px solid #d2d6da; border-radius: 8px; padding: 8px 24px; font-size: 12px; font-weight: bold; text-decoration: none; display: inline-block;">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-sm mb-0 px-5 py-2 text-white"
                                    style="background: linear-gradient(310deg, #2152ff, #21d4fd); border: none; border-radius: 8px; font-weight: bold; text-transform: uppercase;">
                                    UPDATE ANGGOTA
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- Form Tersembunyi untuk Reset Password --}}
                    <form id="form-reset" action="{{ route('anggota.reset', $anggota->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('PUT')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection