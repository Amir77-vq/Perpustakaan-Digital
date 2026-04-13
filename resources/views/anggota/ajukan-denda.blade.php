@extends('layouts.app')

@push('scripts')

    <script src="{{ asset('assets/js/validation-denda.js') }}?v={{ time() }}"></script>

@endpush

@section('content')
    <div class="container-fluid pt-0 py-4" id="denda-page">
        <h3 class="font-weight-bold text-dark mt-n2 mb-4" style="font-size: 1.5rem;">
            Penyelesaian Administrasi
        </h3>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0" style="border-radius: 1rem;">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-danger border-radius-lg py-3"
                            style="background: linear-gradient(310deg, #ea0606 0%, #ff667c 100%); min-height: 50px;">
                        </div>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <div class="row justify-content-between">
                            <div class="col-lg-5 mb-4">
                                <h6 class="text-uppercase text-muted text-xxs font-weight-bolder mb-3">Informasi Buku</h6>
                                <div class="d-flex align-items-center mb-4">
                                    <div class="icon-shape bg-gradient-danger border-radius-md text-center d-flex align-items-center justify-content-center"
                                        style="width: 60px; height: 60px;">
                                        <i class="fas fa-book text-white fa-lg"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="text-dark font-weight-bolder mb-0">{{ $book->judul }}</h5>
                                        <p class="text-sm text-muted mb-0">
                                            <span class="font-weight-bold text-dark">
                                                {{ date('ym') }}-B-{{ str_pad($book->id, 3, '0', STR_PAD_LEFT) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="p-3 border-radius-lg bg-light border mb-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-sm text-secondary">Tanggal Pinjam</span>
                                        <span
                                            class="text-sm font-weight-bold text-dark">{{ date('d M Y', strtotime($peminjaman->tgl_pinjam)) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-sm text-secondary">Batas Kembali</span>
                                        <span
                                            class="text-sm font-weight-bold text-danger">{{ date('d M Y', strtotime($peminjaman->jatuh_tempo)) }}</span>
                                    </div>
                                </div>

                                <h6 class="text-uppercase text-muted text-xxs font-weight-bolder mb-3">Rincian Pembayaran
                                </h6>
                                <ul class="list-group">
                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-0 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark font-weight-bold text-sm">Denda Keterlambatan</h6>
                                            <span class="text-xs">Kalkulasi: {{ $terlambat }} hari &times; Rp 2.000</span>
                                        </div>
                                        <div
                                            class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                                            Rp {{ number_format($denda, 0, ',', '.') }}
                                        </div>
                                    </li>

                                    <hr class="my-3" style="border: 0; border-top: 2px solid #344767; opacity: 0.1;">

                                    <li
                                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark font-weight-bolder text-sm">TOTAL TAGIHAN</h6>
                                        </div>
                                        <div class="d-flex align-items-center text-danger text-lg font-weight-bolder">
                                            Rp {{ number_format($denda, 0, ',', '.') }}
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-lg-6">
                                <h6 class="text-uppercase text-muted text-xxs font-weight-bolder mb-3">Transaksi Tunai</h6>

                                <form action="{{ route('pengembalian.proses', $peminjaman->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_peminjaman" value="{{ $peminjaman->id }}">
                                    <input type="hidden" name="denda" value="{{ $denda }}">
                                    <input type="hidden" id="input_total_denda" value="{{ $denda }}">

                                    <div class="form-group mb-3">
                                        <label
                                            class="form-control-label text-xs font-weight-bold text-uppercase text-muted">Bayar
                                            Tunai</label>
                                        <div class="p-2 border-radius-md bg-light d-flex align-items-center"
                                            style="height: 50px;">
                                            <span class="ps-2 text-dark font-weight-bolder"
                                                style="font-size: 1.1rem;">Rp</span>
                                            <input type="number" id="input_bayar" name="bayar"
                                                class="form-control border-0 bg-transparent text-dark font-weight-bolder no-spin"
                                                required onkeydown="return disableArrowKeys(event)"
                                                style="box-shadow: none; font-size: 1.1rem; padding-left: 8px;">
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label
                                            class="form-control-label text-xs font-weight-bold text-uppercase text-muted">Kembalian</label>
                                        <div class="p-2 border-radius-md bg-light d-flex align-items-center"
                                            style="height: 50px;">
                                            <h5 class="mb-0 text-dark font-weight-bolder ps-2" id="text_kembalian"
                                                style="font-size: 1.1rem;">Rp 0</h5>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 mt-4">
                                        <button type="submit" id="btn_submit" class="btn btn-denda mb-0"
                                            style="border-radius: 10px; padding: 15px; font-size: 0.85rem; font-weight: 700; box-shadow: none !important;">
                                            KONFIRMASI PEMBAYARAN
                                        </button>
                                        <a href="{{ route('pengembalian.index') }}"
                                            class="btn btn-outline-secondary mb-0 border-0 text-xs font-weight-bold text-center">
                                            KEMBALI
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            #denda-page .btn-denda {
                background: linear-gradient(310deg, #ea0606 0%, #ff667c 100%) !important;
                color: #fff !important;
                border: none !important;
            }

            #denda-page .btn-denda:disabled {
                background: #d2d6da !important;
                cursor: not-allowed;
                box-shadow: none !important;
            }

            .no-spin::-webkit-inner-spin-button,
            .no-spin::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            .no-spin {
                -moz-appearance: textfield;
            }

            .form-control:focus {
                outline: none !important;
                box-shadow: none !important;
            }
        </style>
    @endpush
@endsection