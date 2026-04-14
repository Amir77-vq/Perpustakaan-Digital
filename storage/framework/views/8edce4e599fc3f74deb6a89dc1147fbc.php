

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <div class="row mt-2">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-radius: 15px; background: #fff;">
                    <div class="mx-3 position-relative z-index-2">
                        <div class="px-4 d-flex align-items-center justify-content-between"
                            style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 75px; margin-top: -25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                            <h6 class="text-white mb-0 font-weight-bold" style="letter-spacing: 0.5px;">Rekapitulasi Laporan
                                Denda</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0 mt-4">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr class="text-secondary opacity-7">
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-4 py-3">NO</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3">NAMA ANGGOTA</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">JUMLAH
                                            DENDA</th>
                                        <th class="text-center text-uppercase text-xxs font-weight-bolder py-3">STATUS
                                            PEMBAYARAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php $__empty_1 = true; $__currentLoopData = $peminjamans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr style="border-bottom: 1px solid #f2f2f2;">
                                            <td class="ps-4">
                                                <span class="text-xs font-weight-bold text-dark"><?php echo e($no++); ?></span>
                                            </td>
                                            <td class="ps-2">
                                                <p class="text-sm font-weight-bold mb-0">
                                                    <?php echo e($item->user->name ?? 'User Tidak Ditemukan'); ?>

                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-xs font-weight-bold text-dark">
                                                    Rp <?php echo e(number_format(abs($item->denda ?? 0), 0, ',', '.')); ?>

                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <?php if($item->denda == 0): ?>
                                                    <span class="badge badge-sm"
                                                        style="background-color: #2dce89; color: #fff; font-size: 9px; padding: 5px 10px;">LUNAS
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-sm"
                                                        style="background-color: #f5365c; color: #fff; font-size: 9px; padding: 5px 10px;">BELUM
                                                        BAYAR (Rp <?php echo e(number_format(abs($item->denda), 0, ',', '.')); ?>)</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <p class="text-secondary text-sm mb-0">Tidak ada data denda.</p>
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
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/kepala/laporandenda.blade.php ENDPATH**/ ?>