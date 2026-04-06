<aside
  class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
  id="sidenav-main" style="overflow: hidden;"> 

  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
      id="iconSidenav"></i>

    <a class="navbar-brand m-0" href="#">
      <img src="{{ asset('assets/img/logo-ct.png') }}" class="navbar-brand-img h-100">
      <span class="ms-1 font-weight-bold text-white">Perpustakaan Digital</span>
    </a>
  </div>

  <hr class="horizontal light mt-0 mb-2">

  <div class="collapse navbar-collapse" id="sidenav-collapse-main" style="height: auto; overflow: hidden;">
    <ul class="navbar-nav">

      {{-- Dashboard --}}
      <li class="nav-item">
        <a class="nav-link text-white {{ Request::is('dashboard') ? 'active bg-gradient-primary' : '' }}"
          style="{{ Request::is('dashboard') ? 'border-radius: 8px !important;' : '' }}"
          href="/dashboard">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      {{-- Data Buku --}}
      <li class="nav-item">
        <a class="nav-link text-white {{ Request::is('petugas/buku*') ? 'active bg-gradient-primary' : '' }}"
          style="{{ Request::is('petugas/buku*') ? 'border-radius: 8px !important;' : '' }}"
          href="{{ route('petugas.buku') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">menu_book</i>
          </div>
          <span class="nav-link-text ms-1">Data Buku</span>
        </a>
      </li>

      {{-- Data Anggota --}}
      <li class="nav-item">
        <a class="nav-link text-white {{ Request::is('petugas/anggota*') ? 'active bg-gradient-primary' : '' }}"
          style="{{ Request::is('petugas/anggota*') ? 'border-radius: 8px !important;' : '' }}"
          href="{{ route('petugas.anggota') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">groups</i>
          </div>
          <span class="nav-link-text ms-1">Data Anggota</span>
        </a>
      </li>

      {{-- Peminjaman --}}
      <li class="nav-item">
        <a class="nav-link text-white {{ Request::is('peminjaman-petugas*') ? 'active bg-gradient-primary' : '' }}"
          style="{{ Request::is('peminjaman-petugas*') ? 'border-radius: 8px !important;' : '' }}"
          href="{{ route('petugas.peminjaman') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">assignment</i>
          </div>
          <span class="nav-link-text ms-1">Peminjaman</span>
        </a>
      </li>

      {{-- Pengembalian (FIXED: Route & Active State) --}}
      <li class="nav-item">
        <a class="nav-link text-white {{ Request::is('pengembalian-petugas*') ? 'active bg-gradient-primary' : '' }}"
          style="{{ Request::is('pengembalian-petugas*') ? 'border-radius: 8px !important;' : '' }}"
          href="{{ route('petugas.pengembalian') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">assignment_return</i>
          </div>
          <span class="nav-link-text ms-1">Pengembalian</span>
        </a>
      </li>

      {{-- Denda --}}
      <li class="nav-item">
        <a class="nav-link text-white {{ Request::is('petugas/denda*') || Request::is('denda*') ? 'active bg-gradient-primary' : '' }}" 
          style="{{ Request::is('petugas/denda*') || Request::is('denda*') ? 'border-radius: 8px !important;' : '' }}"
          href="{{ route('petugas.denda') }}">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">payments</i>
          </div>
          <span class="nav-link-text ms-1">Denda</span>
        </a>
      </li>

    </ul>
  </div>
</aside>