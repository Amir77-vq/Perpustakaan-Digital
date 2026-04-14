

<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('assets/css/style-peminjaman.css')); ?>?v=<?php echo e(time()); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/css/style-detail-buku.css')); ?>?v=<?php echo e(time()); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid pt-0 py-4">
        <div class="row mb-3">
            <div class="col-12">
                <h3 class="font-weight-bold text-dark mt-n2" style="font-size: 1.5rem;">
                    Detail Buku
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg border-0" style="border-radius: 1rem;">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3"
                            style="background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%); min-height: 50px;">
                        </div>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="row align-items-start">
                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="book-cover-wrapper-fixed shadow-lg" style="border-radius: 12px; overflow: hidden; aspect-ratio: 3/4;">
                                    <?php if($book->cover): ?>
                                        <img src="<?php echo e(asset('storage/cover/' . $book->cover)); ?>"
                                            alt="Cover <?php echo e($book->judul); ?>" 
                                            class="w-100 h-100" 
                                            style="object-fit: cover;">
                                    <?php else: ?>
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" 
                                            style="background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%);">
                                            <i class="fas fa-book text-white fa-4x"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-8 ps-lg-5">
                                <h4 class="text-dark font-weight-bolder mb-1" style="font-size: 1.6rem;">
                                    <?php echo e($book->judul); ?>

                                </h4>
                                <div class="pb-3" style="border-bottom: 2px solid #ebeef2;">
                                    <p class="text-xs text-muted mb-0">
                                        Penulis : <span class="text-dark font-weight-bold"><?php echo e($book->penulis); ?></span>
                                    </p>
                                </div>
                                <div class="py-3" style="border-bottom: 2px solid #ebeef2;">
                                    <p class="label-custom-small mb-1" style="font-size: 0.85rem; color: #8392ab;">Stok :</p>
                                    <p class="value-custom-small font-weight-bold mb-0" style="color: #344767;">
                                        <?php echo e($book->stok); ?> Buku
                                    </p>
                                </div>
                                <div class="py-3" style="border-bottom: 2px solid #ebeef2;">
                                    <p class="label-custom-small mb-1" style="font-size: 0.85rem; color: #8392ab;">Status :</p>
                                    <p class="value-custom-small font-weight-bold mb-0 <?php echo e($book->stok > 0 ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e($book->stok > 0 ? 'Tersedia untuk Dipinjam' : 'Sedang Habis'); ?>

                                    </p>
                                </div>
                                <div class="d-flex gap-2 mt-5">
                                    <?php if($book->stok > 0): ?>
                                        <a href="<?php echo e(route('buku.ajukan', ['id' => $book->id, 'from' => $dari])); ?>"
                                            class="btn btn-primary mb-0 shadow-none text-white"
                                            style="background: linear-gradient(310deg, <?php echo e(isset($statusBermasalah) && $statusBermasalah ? '#ea0606, #ff667c' : '#2152ff, #21d4fd'); ?>); border-radius: 8px; padding: 12px 30px; font-size: 0.8rem; border: none; font-weight: 700; box-shadow: none !important; text-transform: uppercase;">
                                            AJUKAN PEMINJAMAN
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php echo e($dari == 'dashboard' ? '/dashboard' : '/buku'); ?>" 
                                        class="btn btn-outline-secondary mb-0 shadow-none" 
                                        style="border-radius: 8px; padding: 12px 30px; font-size: 0.8rem; font-weight: 700; border: 1.5px solid #d2d6da; color: #344767; background: transparent; box-shadow: none !important; text-transform: uppercase;">
                                        KEMBALI
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/anggota/detail-buku.blade.php ENDPATH**/ ?>