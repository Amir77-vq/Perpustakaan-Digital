@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row">

    <!-- CARD 1 -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">weekend</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Total Peminjaman</p>
            <h4 class="mb-0">22</h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">person</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Sedang di Pinjam</p>
            <h4 class="mb-0">9</h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">assignment_turned_in</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Total Pengembalian</p>
            <h4 class="mb-0">7</h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
      </div>
    </div>

    <!-- CARD 4 -->
    <div class="col-xl-3 col-sm-6">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
            <i class="material-icons opacity-10">payments</i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 text-capitalize">Total Denda</p>
            <h4 class="mb-0">Rp. 25.000</h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
      </div>
    </div>

  </div>
</div>
@endsection