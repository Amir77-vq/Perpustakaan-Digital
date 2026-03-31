<aside
  class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
  id="sidenav-main">

  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
      id="iconSidenav"></i>

    <a class="navbar-brand m-0" href="#">
      <img src="{{ asset('assets/img/logo-ct.png') }}" class="navbar-brand-img h-100">
      <span class="ms-1 font-weight-bold text-white">Perpustakaan Digital</span>
    </a>
  </div>

  <hr class="horizontal light mt-0 mb-2">

  <div class="px-3 text-white">
    <h6 class="text-white">Petugas</h6>
  </div>

  <div class="collapse navbar-collapse w-auto max-height-vh-100">
    <ul class="navbar-nav">

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('dashboard') ? 'active bg-gradient-primary' : '' }}" href="/dashboard">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('buku*') ? 'active bg-gradient-primary' : '' }}" href="/buku">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">menu_book</i>
          </div>
          <span class="nav-link-text ms-1">Data Buku</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('anggota*') ? 'active bg-gradient-primary' : '' }}" href="/anggota">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">groups</i>
          </div>
          <span class="nav-link-text ms-1">Data Anggota</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('peminjaman*') ? 'active bg-gradient-primary' : '' }}" href="/peminjaman">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">assignment</i>
          </div>
          <span class="nav-link-text ms-1">Peminjaman</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('pengembalian*') ? 'active bg-gradient-primary' : '' }}" href="/pengembalian">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">assignment_return</i>
          </div>
          <span class="nav-link-text ms-1">Pengembalian</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('denda*') ? 'active bg-gradient-primary' : '' }}" href="/denda">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">payments</i>
          </div>
          <span class="nav-link-text ms-1">Denda</span>
        </a>
      </li>

    </ul>
  </div>
</aside>