<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>LIBRARY</title>

    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/soft-ui-dashboard.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/dashboard.css')); ?>?v=<?php echo e(time()); ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/style.css')); ?>?v=<?php echo e(time()); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body class="g-sidenav-show bg-gray-100">

    <?php if(auth()->user()->role == 'anggota'): ?>
        <?php echo $__env->make('components.sidebar-anggota', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php elseif(auth()->user()->role == 'petugas'): ?>
        <?php echo $__env->make('components.sidebar-petugas', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('components.sidebar-kepala', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        
        <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="container-fluid py-4">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show text-white border-0 mb-4" role="alert" style="background-image: linear-gradient(310deg, #17ad37 0%, #98ec2d 100%);">
                    <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
                    <span class="alert-text"><strong>Berhasil!</strong> <?php echo e(session('success')); ?></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show text-white border-0 mb-4" role="alert" style="background-image: linear-gradient(310deg, #ea0606 0%, #ff667c 100%);">
                    <span class="alert-icon"><i class="fas fa-exclamation-triangle"></i></span>
                    <span class="alert-text"><strong>Ups!</strong> <?php echo e(session('error')); ?></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>

    </main>

    <script src="<?php echo e(asset('assets/js/core/bootstrap.min.js')); ?>"></script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/layouts/app.blade.php ENDPATH**/ ?>