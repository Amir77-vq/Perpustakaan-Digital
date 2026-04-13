<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header text-center" style="padding-top: 20px !important;"> 
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="<?php echo e(route('dashboard')); ?>" style="padding-top: 0; padding-bottom: 0;">
            <div class="d-flex align-items-center justify-content-center">
                <img src="<?php echo e(asset('assets/img/logo-ct.png')); ?>" class="navbar-brand-img h-100" alt="main_logo" style="max-height: 32px;">
                <span class="ms-2 font-weight-bold text-white" style="line-height: 1; font-size: 0.95rem;">Perpustakaan Digital</span>
            </div>
        </a>
    </div>

    <hr class="horizontal light mt-0 mb-2">

    <div class="collapse navbar-collapse w-auto max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                
                <a class="nav-link text-white <?php echo e(Request::is('dashboard') ? 'active bg-gradient-info' : ''); ?>" href="/dashboard">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-home text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                
                <a class="nav-link text-white <?php echo e(Request::is('buku') || (Request::is('buku/*') && !Request::is('buku/*/ajukan')) ? 'active bg-gradient-info' : ''); ?>" href="/buku">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-book text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Daftar Buku</span>
                </a>
            </li>

            <li class="nav-item">
                
                <a class="nav-link text-white <?php echo e(Request::is('peminjaman*') || Request::is('buku/*/ajukan') ? 'active bg-gradient-info' : ''); ?>" href="/peminjaman">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-hand-holding text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Peminjaman Saya</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white <?php echo e(Request::is('pengembalian*') ? 'active bg-gradient-info' : ''); ?>" href="/pengembalian">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-undo text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pengembalian</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white <?php echo e(Request::is('history*') ? 'active bg-gradient-info' : ''); ?>" href="/history">
                    <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-history text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">History</span>
                </a>
            </li>
        </ul>
    </div>
</aside><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/components/sidebar-anggota.blade.php ENDPATH**/ ?>