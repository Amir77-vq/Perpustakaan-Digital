

<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-petugas-peminjaman.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo e(asset('assets/js/validation-peminjaman.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row mt-2">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px; background: #fff;">
                <div class="mx-3 position-relative z-index-2">
                    <div class="px-4 d-flex align-items-center justify-content-between"
                        style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 75px; margin-top: -25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <h6 class="text-white mb-0 font-weight-bold" style="letter-spacing: 0.5px;">Peminjaman</h6>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0 mt-4">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr class="text-secondary opacity-7">
                                    <th class="text-uppercase text-xxs font-weight-bolder ps-4 py-3">ID</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3">NAMA ANGGOTA</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3">JUDUL BUKU</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">TANGGAL PINJAM</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">JATUH TEMPO</th>
                                    <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">STATUS</th>
                                    <th class="text-center text-uppercase text-xxs font-weight-bolder py-3">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $peminjamans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr style="border-bottom: 1px solid #f2f2f2;">
        <td class="ps-4">
            <span class="ps text-xs font-weight-bold">
                <?php echo e($item->kode_peminjaman ?? 'BOOK-0' . str_pad($item->id, 2, '0', STR_PAD_LEFT)); ?>

            </span>
        </td>
        <td class="ps-2">
            <p class="text-sm font-weight-bold mb-0" style="color: #344767;">
                <?php echo e($item->user->name ?? 'User Tidak Ada'); ?>

            </p>
        </td>
        <td class="ps-2">
            <span class="text-xs text-secondary font-weight-normal">
                <?php echo e($item->buku->judul ?? $item->judul_buku); ?>

            </span>
        </td>
        <td class="ps-2 text-center">
            <span class="text-xs text-secondary font-weight-normal">
                <?php echo e(\Carbon\Carbon::parse($item->tgl_pinjam)->format('d-m-Y')); ?>

            </span>
        </td>
        <td class="ps-2 text-center">
            <span class="text-xs text-secondary font-weight-normal">
                <?php echo e(\Carbon\Carbon::parse($item->jatuh_tempo)->format('d-m-Y')); ?>

            </span>
        </td>
        <td class="ps-2 text-center">
            <?php $status = strtoupper($item->status); ?>
            
            <?php if(in_array($status, ['PENDING', 'MENUNGGU'])): ?>
                <span class="badge badge-sm" style="background-color: #fbc02d; color: #fff; font-size: 9px; padding: 5px 10px;">PENDING</span>
            <?php elseif($status == 'WAITING'): ?>
                <span class="badge badge-sm" style="background-color: #fb8c00; color: #fff; font-size: 9px; padding: 5px 10px;">WAITING</span>
            <?php elseif($status == 'DIPINJAM'): ?>
                <span class="badge badge-sm" style="background-color: #3f51b5; color: #fff; font-size: 9px; padding: 5px 10px;">DIPINJAM</span>
            <?php elseif(in_array($status, ['KEMBALI', 'DIKEMBALIKAN'])): ?>
                <span class="badge badge-sm" style="background-color: #2dce89; color: #fff; font-size: 9px; padding: 5px 10px;">DIKEMBALIKAN</span>
            <?php else: ?>
                <span class="badge badge-sm bg-secondary" style="font-size: 9px; padding: 5px 10px;"><?php echo e($status); ?></span>
            <?php endif; ?>
        </td>
        <td class="align-middle text-center">
            <?php if(in_array($status, ['PENDING', 'MENUNGGU'])): ?>
                <form action="<?php echo e(route('peminjaman.konfirmasi', $item->id)); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-xs mb-0 px-3 py-1"
                        style="background-color: #2e7d32; color: #fff; font-size: 10px; border-radius: 5px; font-weight: 700; border: none;">
                        KONFIRMASI
                    </button>
                </form>
            <?php elseif($status == 'WAITING'): ?>
                <span class="text-secondary text-xs font-weight-bold">Selesai</span>
            <?php else: ?>
                <span class="text-secondary text-xs">Selesai</span>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
        <td colspan="7" class="text-center py-5">
            <p class="text-secondary text-sm mb-0">Belum ada data peminjaman.</p>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/petugas/peminjaman.blade.php ENDPATH**/ ?>