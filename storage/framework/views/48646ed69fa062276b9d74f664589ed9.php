

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/search-buku.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('assets/css/style-anggota-buku.css')); ?>?v=<?php echo e(time()); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-2">
        <div class="mb-4">
            <div class="d-flex align-items-center">
                <form action="<?php echo e(route('buku.index')); ?>" method="GET" class="w-100" id="searchForm">
                    <div class="input-group input-group-outline bg-white rounded border" style="max-width: 320px;">
                        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Cari Buku..."
                            value="<?php echo e(request('search')); ?>" style="padding: 10px 15px; border: none; outline: none;"
                            autocomplete="off">
                        <button type="submit" class="btn btn-link text-dark mb-0 px-2 shadow-none">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="row" id="bookContainer">
            <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-xl-3 col-md-4 col-sm-6 mb-4 book-item">
                    <div class="card book-card h-100 shadow-sm border-0"
                        style="border-radius: 12px; transition: transform 0.2s ease;">
                        <div class="card-body p-3">
                            <div class="d-flex gap-3 mb-3">
                                <div class="book-cover-wrapper" style="width: 89px; height: 115px; flex-shrink: 0;">
                                    <?php if($book->cover): ?>
                                        <img src="<?php echo e(asset('storage/cover/' . $book->cover)); ?>" class="w-100 h-100 shadow-sm"
                                            style="object-fit: cover; border-radius: 8px;"
                                            onerror="this.onerror=null;this.src='<?php echo e(asset('assets/img/no-cover.png')); ?>';">
                                    <?php else: ?>
                                            <div class="w-100 h-100 shadow-sm d-flex align-items-center justify-content-center"
                                                style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 8px;">
                                                <i class="fas fa-book text-white"></i>
                                            </div>
                                        <?php endif; ?>
                                </div>
                                <div class="book-title-info overflow-hidden">
                                    <h6 class="text-sm font-weight-bold mb-1 text-dark text-truncate judul-buku">
                                        <?php echo e($book->judul); ?>

                                    </h6>
                                    <p class="text-xs text-secondary mb-2 text-truncate penulis-buku"> <?php echo e($book->penulis); ?></p>
                                </div>
                            </div>

                            <div class="book-details-bottom">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="status-indicator"
                                        style="width: 8px; height: 8px; border-radius: 50%; display: inline-block; background-color: <?php echo e($book->stok > 0 ? '#4caf50' : '#f44336'); ?>;"></span>
                                    <div class="ms-2">
                                        <p
                                            class="text-xs mb-0 font-weight-bold <?php echo e($book->stok > 0 ? 'text-success' : 'text-danger'); ?>">
                                            <?php echo e($book->stok > 0 ? 'Tersedia' : 'Habis'); ?>

                                        </p>
                                        <?php if($book->stok > 0): ?>
                                            <p class="text-xxs text-secondary mb-0">Stok <?php echo e($book->stok); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3 g-2">
                                <div class="col-6">
                                    <a href="<?php echo e(route('buku.show', $book->id)); ?>" class="btn btn-sm w-100 mb-0 shadow-none"
                                        style="background-color: #f0f2f5; color: #344767; text-transform: none; font-weight: 700; border-radius: 6px;">Detail</a>
                                </div>
                                <div class="col-6">
                                    <?php if($book->stok > 0): ?>
                                        <a href="<?php echo e(route('buku.ajukan', $book->id)); ?>"
                                            class="btn btn-sm w-100 mb-0 shadow-none text-white"
                                            style="background: linear-gradient(310deg, #2152ff, #21d4fd); text-transform: none; font-weight: 700; border-radius: 6px;">Pinjam</a>
                                    <?php else: ?>
                                        <button class="btn btn-sm w-100 mb-0 shadow-none text-white" disabled
                                            style="background-color: #d2d6da; text-transform: none; font-weight: 700; border-radius: 6px;">Habis</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center py-5">
                    <h5 class="text-secondary opacity-7">Belum ada buku yang tersedia.</h5>
                </div>
            <?php endif; ?>
        </div>

        <div id="jsNoResults" class="row d-none">
            <div class="col-12 d-flex justify-content-center align-items-center" style="min-height: 400px;">
                <div class="text-center">
                    <i class="fas fa-book-open mb-3 text-secondary opacity-4" style="font-size: 4rem;"></i>
                    <h5 class="text-secondary mb-1">Buku tidak ditemukan.</h5>
                    <p class="text-sm text-secondary opacity-8">Coba cari dengan judul atau penulis lain.</p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/anggota/buku.blade.php ENDPATH**/ ?>