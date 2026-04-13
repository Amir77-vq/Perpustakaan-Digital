<nav class="navbar navbar-main navbar-expand-lg px-3 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3 d-flex justify-content-between align-items-center">

        <div aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                </li>

                <?php 
                    $allSegments = Request::segments();

                    if(request('from') == 'dashboard') {
                        $allSegments = array_values(array_filter($allSegments, function($value) {
                            return $value !== 'buku';
                        }));
                    }

                    // Tambahkan 'kepala' ke dalam filter biar gak muncul di breadcrumb
                    $segments = collect($allSegments)->filter(function ($value) {
                        return !is_numeric($value) && !in_array(strtolower($value), ['petugas', 'kepala']); 
                    })->values()->all(); 
                ?>

                <?php $__currentLoopData = $segments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $segment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($index + 1 < count($segments)): ?>
                        <li class="breadcrumb-item text-sm text-dark opacity-5 text-capitalize">
                            <?php echo e(str_replace(['-', '_'], ' ', $segment)); ?>

                        </li>
                    <?php else: ?>
                        <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">
                            <?php echo e(str_replace(['-', '_'], ' ', $segment)); ?>

                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ol>

            <h6 class="font-weight-bolder mb-0 text-capitalize">
                <?php if(Request::is('dashboard')): ?> 
                    Dashboard 
                <?php elseif(Request::is('kepala/anggota*')): ?> 
                    Manajemen Anggota
                <?php elseif(Request::is('laporan/peminjaman*')): ?> 
                    Laporan Peminjaman
                <?php elseif(Request::is('laporan/pengembalian*')): ?> 
                    Laporan Pengembalian
                <?php elseif(Request::is('laporan/denda*')): ?> 
                    Laporan Denda
                <?php elseif(Request::is('laporan/buku*')): ?> 
                    Laporan Ketersediaan Buku
                <?php elseif(Request::is('petugas/buku*')): ?> 
                    Manajemen Buku
                <?php elseif(Request::is('peminjaman-petugas*')): ?> 
                    Konfirmasi Peminjaman
                <?php elseif(Request::is('pengembalian-petugas*')): ?> 
                    Konfirmasi Pengembalian
                <?php else: ?> 
                    <?php 
                        $lastSegment = end($segments);
                        if(request('from') == 'dashboard' && $lastSegment == 'detail') {
                            $displayTitle = "Detail Buku";
                        } else {
                            $displayTitle = str_replace(['-', '_'], ' ', $lastSegment);
                        }
                    ?>
                    <?php echo e($displayTitle); ?> 
                <?php endif; ?>
            </h6>
        </div>

        <div class="d-flex align-items-center gap-3">
            
            <div class="d-flex flex-column align-items-end me-1">
                <span class="text-sm font-weight-bold text-dark"><?php echo e(Auth::user()->name); ?></span>
                
                <span class="text-xs <?php echo e(Auth::user()->role == 'kepala' ? 'text-danger' : 'text-primary'); ?> font-weight-bold" style="font-size: 10px !important;">
                    <?php echo e(Auth::user()->role == 'kepala' ? 'KEPALA PERPUSTAKAAN' : ucfirst(Auth::user()->role)); ?>

                </span>
            </div>

            
            <a href="<?php echo e(route('profile')); ?>" class="nav-link text-body p-0">
                <div class="avatar avatar-sm bg-gradient-info d-flex align-items-center justify-content-center shadow-sm" 
                    style="width: 35px; height: 35px; border-radius: 50%;">
                    <i class="fas fa-user text-white text-xs"></i>
                </div>
            </a>

            
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="m-0">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-link text-danger p-0 m-0 shadow-none" title="Logout">
                    <i class="fas fa-sign-out-alt" style="font-size: 18px;"></i>
                </button>
            </form>

            <div class="nav-item d-xl-none d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
            </div>
        </div>

    </div>
</nav><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/components/navbar.blade.php ENDPATH**/ ?>