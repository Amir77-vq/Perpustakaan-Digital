

<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-petugas-peminjaman.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px; background: #fff;">
        <div class="mx-3 position-relative z-index-2">
            <div class="px-4 d-flex align-items-center justify-content-between"
                style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 75px; margin-top: -25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                <h6 class="text-white mb-0 font-weight-bold">Manajemen Pengembalian</h6>
            </div>
        </div>

        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0 mt-4">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr class="text-secondary opacity-7">
                            <th class="ps-4 py-3 text-xxs font-weight-bolder">ID</th>
                            <th class="ps-2 py-3 text-xxs font-weight-bolder">NAMA ANGGOTA</th>
                            <th class="ps-2 py-3 text-xxs font-weight-bolder">JUDUL BUKU</th>
                            <th class="text-center py-3 text-xxs font-weight-bolder">TGL PINJAM</th>
                            <th class="text-center py-3 text-xxs font-weight-bolder">TGL KEMBALI</th>
                            <th class="text-center py-3 text-xxs font-weight-bolder">STATUS</th>
                            <th class="text-center py-3 text-xxs font-weight-bolder">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pengembalians; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr style="border-bottom: 1px solid #f2f2f2;">
                            <td class="ps-4 text-xs font-weight-bold">
                                BOOK-0<?php echo e(str_pad($item->id, 3, '0', STR_PAD_LEFT)); ?>

                            </td>
                            <td class="ps-2 text-sm font-weight-bold" style="color: #344767;">
                                <?php echo e($item->user->name ?? '-'); ?>

                            </td>
                            <td class="ps-2 text-xs text-secondary">
                                <?php echo e($item->buku->judul ?? '-'); ?>

                            </td>
                            <td class="text-center text-xs text-secondary">
                                <?php echo e(date('d/m/y', strtotime($item->tgl_pinjam ?? $item->created_at))); ?>

                            </td>
                            <td class="text-center">
                                <span class="text-xs text-secondary font-weight-normal">
                                    <?php if($item->tanggal_kembali): ?>
                                        <?php echo e(\Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y')); ?>

                                    <?php else: ?>
                                        <?php echo e(\Carbon\Carbon::parse($item->updated_at)->format('d-m-Y')); ?>

                                    <?php endif; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if($item->status == 'WAITING'): ?>
                                    <span style="background-color: #fbc02d !important; color: #fff !important; font-size: 9px; padding: 4px 8px; border-radius: 4px; font-weight: bold; display: inline-block;">WAITING</span>
                                <?php else: ?>
                                    <span style="background-color: #2ecc71 !important; color: #ffffff !important; font-size: 9px; padding: 4px 8px; border-radius: 4px; font-weight: bold; display: inline-block;">DIKEMBALIKAN</span>
                                <?php endif; ?>
                            </td>
                            <td class="align-middle text-center">
                                <?php if($item->status == 'WAITING'): ?>
                                    <form action="<?php echo e(route('pengembalian.konfirmasi', $item->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                            style="background-color: #2152ff !important; color: #fff !important; font-size: 10px !important; border-radius: 5px !important; font-weight: 700 !important; border: none !important; padding: 4px 12px !important; text-transform: uppercase; cursor: pointer;">
                                            KONFIRMASI
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-secondary text-xs font-weight-bold">Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="7" class="text-center py-5 text-secondary text-sm">Data tidak ditemukan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/petugas/pengembalian.blade.php ENDPATH**/ ?>