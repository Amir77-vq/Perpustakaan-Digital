<aside
  class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
  id="sidenav-main" style="overflow: hidden;"> 

  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
      id="iconSidenav"></i>

    <a class="navbar-brand m-0" href="#">
      <img src="<?php echo e(asset('assets/img/logo-ct.png')); ?>" class="navbar-brand-img h-100">
      <span class="ms-1 font-weight-bold text-white">Perpustakaan Digital</span>
    </a>
  </div>

  <hr class="horizontal light mt-0 mb-2">

  <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main" style="height: auto; overflow: hidden;">
    
    <ul class="navbar-nav flex-column">

      
      <li class="nav-item">
        <a class="nav-link text-white <?php echo e(Request::is('dashboard') ? 'active bg-gradient-primary' : ''); ?>"
          style="<?php echo e(Request::is('dashboard') ? 'border-radius: 8px !important;' : ''); ?>"
          href="/dashboard">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      
      <li class="nav-item">
        <a class="nav-link text-white <?php echo e(Request::is('kepala/anggota*') ? 'active bg-gradient-primary' : ''); ?>"
          style="<?php echo e(Request::is('kepala/anggota*') ? 'border-radius: 8px !important;' : ''); ?>"
          href="<?php echo e(route('kepala.anggota')); ?>">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">groups</i>
          </div>
          <span class="nav-link-text ms-1">Data Anggota</span>
        </a>
      </li>

      
      <li class="nav-item">
        <a class="nav-link text-white <?php echo e(Request::is('laporan/peminjaman*') ? 'active bg-gradient-primary' : ''); ?>"
          style="<?php echo e(Request::is('laporan/peminjaman*') ? 'border-radius: 8px !important;' : ''); ?>"
          href="/laporan/peminjaman">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">assignment</i>
          </div>
          <span class="nav-link-text ms-1">Laporan Peminjaman</span>
        </a>
      </li>

      
      <li class="nav-item">
        <a class="nav-link text-white <?php echo e(Request::is('laporan/pengembalian*') ? 'active bg-gradient-primary' : ''); ?>"
          style="<?php echo e(Request::is('laporan/pengembalian*') ? 'border-radius: 8px !important;' : ''); ?>"
          href="/laporan/pengembalian">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">assignment_return</i>
          </div>
          <span class="nav-link-text ms-1">Laporan Pengembalian</span>
        </a>
      </li>

      
      <li class="nav-item">
        <a class="nav-link text-white <?php echo e(Request::is('laporan/denda*') ? 'active bg-gradient-primary' : ''); ?>"
          style="<?php echo e(Request::is('laporan/denda*') ? 'border-radius: 8px !important;' : ''); ?>"
          href="/laporan/denda">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">payments</i>
          </div>
          <span class="nav-link-text ms-1">Laporan Denda</span>
        </a>
      </li>

      
      <li class="nav-item">
        <a class="nav-link text-white <?php echo e(Request::is('laporan/buku*') ? 'active bg-gradient-primary' : ''); ?>"
          style="<?php echo e(Request::is('laporan/buku*') ? 'border-radius: 8px !important;' : ''); ?>"
          href="/laporan/buku">
          <div class="text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">menu_book</i>
          </div>
          <span class="nav-link-text ms-1">Laporan Buku</span>
        </a>
      </li>

    </ul>
  </div>
</aside><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/components/sidebar-kepala.blade.php ENDPATH**/ ?>