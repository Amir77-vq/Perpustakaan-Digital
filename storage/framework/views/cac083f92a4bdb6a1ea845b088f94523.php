

<?php $__env->startSection('content'); ?>

<div class="row stats-section mt-4">
    
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card shadow-sm border-radius-xl p-4 stats-card-custom">
            <div class="d-flex align-items-center w-100">
                <div class="icon icon-lg icon-shape bg-dark shadow-dark border-radius-xl mt-n4 position-absolute d-flex justify-content-center align-items-center">
                    <i class="fas fa-book text-white" style="font-size: 20px;"></i>
                </div>
                <div class="text-end ms-auto">
                    <p class="text-sm mb-0 text-secondary font-weight-bold">Total Buku</p>
                    <h3 class="mb-0 font-weight-bolder text-dark"><?php echo e($totalBuku); ?></h3>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card shadow-sm border-radius-xl p-4 stats-card-custom">
            <div class="d-flex align-items-center w-100">
                <div class="icon icon-lg icon-shape shadow-primary border-radius-xl mt-n4 position-absolute d-flex justify-content-center align-items-center" style="background-color: #e91e63 !important;">
                    <i class="fas fa-user text-white" style="font-size: 20px;"></i>
                </div>
                <div class="text-end ms-auto">
                    <p class="text-sm mb-0 text-secondary font-weight-bold">Total Anggota</p>
                    <h3 class="mb-0 font-weight-bolder text-dark"><?php echo e($totalAnggota); ?></h3>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card shadow-sm border-radius-xl p-4 stats-card-custom">
            <div class="d-flex align-items-center w-100">
                <div class="icon icon-lg icon-shape bg-success shadow-success border-radius-xl mt-n4 position-absolute d-flex justify-content-center align-items-center">
                    <i class="fas fa-user-check text-white" style="font-size: 20px;"></i>
                </div>
                <div class="text-end ms-auto">
                    <p class="text-sm mb-0 text-secondary font-weight-bold">Pinjam Aktif</p>
                    <h3 class="mb-0 font-weight-bolder text-dark"><?php echo e($peminjamanAktif); ?></h3>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card shadow-sm border-radius-xl p-4 stats-card-custom">
            <div class="d-flex align-items-center w-100">
                <div class="icon icon-lg icon-shape shadow-info border-radius-xl mt-n4 position-absolute d-flex justify-content-center align-items-center" style="background-color: #2196f3 !important;">
                    <i class="fas fa-wallet text-white" style="font-size: 20px;"></i>
                </div>
                <div class="text-end ms-auto">
                    <p class="text-sm mb-0 text-secondary font-weight-bold">Belum Bayar</p>
                    <h3 class="mb-0 font-weight-bolder text-dark">Rp <?php echo e(number_format($dendaBelumDibayar, 0, ',', '.')); ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row mt-4 mb-5">
    <div class="col-12">
        <div class="card shadow-sm border-0" style="border-radius: 12px; background: #fff; margin-top: 20px;">
            <div class="mx-3 position-relative z-index-2">
                <div class="peminjaman-header shadow-primary px-3 d-flex align-items-center" 
                    style="background: linear-gradient(310deg, #141727, #3A416F); border-radius: 6px; min-height: 60px; margin-top: -25px;">
                    <h6 class="text-white mb-0 text-xs font-weight-bold" style="letter-spacing: 0.5px;">
                        MONITORING AKTIVITAS PERPUSTAKAAN
                    </h6>
                </div>
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0 mt-3"> 
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3 py-3">NAMA ANGGOTA</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3 py-3">BUKU</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 py-3">STATUS</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 py-3">WAKTU</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr style="border-bottom: 1px solid #f8f9fa;">
                                <td class="ps-3 py-3">
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0 text-xs font-weight-bold"><?php echo e($activity->user?->name ?? 'User Tidak Ditemukan'); ?></h6>
                                        <p class="text-xxs text-secondary mb-0">ID: #<?php echo e($activity->id); ?></p>
                                    </div>
                                </td>
                                <td class="ps-3 py-3">
                                    <p class="text-xs font-weight-bold mb-0 text-dark"><?php echo e($activity->buku?->judul ?? 'Buku Terhapus'); ?></p>
                                </td>
                                <td class="align-middle text-center py-3">
                                    <?php
                                        $status = strtolower($activity->status);
                                    ?>

                                    <?php if($status == 'dipinjam'): ?>
                                        <span class="badge" style="background-color: #2152ff; color: #fff; border-radius: 4px; padding: 5px 10px; font-size: 8px; font-weight: 700;">DIPINJAM</span>
                                    <?php elseif($status == 'dikembalikan' || $status == 'kembali'): ?>
                                        <span class="badge" style="background-color: #2dce89; color: #fff; border-radius: 4px; padding: 5px 10px; font-size: 8px; font-weight: 700;">DIKEMBALIKAN</span>
                                    <?php elseif($status == 'denda_dibayar' || $status == 'sudah_bayar'): ?>
                                        <span class="badge" style="background-color: #4caf50; color: #fff; border-radius: 4px; padding: 5px 10px; font-size: 8px; font-weight: 700;">DENDA LUNAS</span>
                                    <?php elseif($status == 'menunggu'): ?>
                                        <span class="badge" style="background-color: #fb8c00; color: #fff; border-radius: 4px; padding: 5px 10px; font-size: 8px; font-weight: 700;">MENUNGGU KONFIRMASI</span>
                                    <?php else: ?>
                                        <span class="badge" style="background-color: #f44335; color: #fff; border-radius: 4px; padding: 5px 10px; font-size: 8px; font-weight: 700;"><?php echo e(strtoupper($status)); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="align-middle text-center py-3">
                                    <span class="text-secondary text-xs font-weight-bold">
                                        <?php echo e(\Carbon\Carbon::parse($activity->updated_at)->diffForHumans()); ?>

                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <span class="text-secondary text-sm">Belum ada aktivitas terekam.</span>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/kepala/dashboard.blade.php ENDPATH**/ ?>