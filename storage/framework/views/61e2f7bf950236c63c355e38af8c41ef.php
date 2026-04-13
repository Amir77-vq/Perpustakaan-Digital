

<?php $__env->startPush('styles'); ?>
    <style>
        .text-xxs { font-size: 0.65rem !important; }
        .card .text-xs { font-size: 0.75rem !important; }
        .table-responsive { overflow-x: auto; }
        .badge-sm {
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.65rem;
            text-transform: uppercase;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid py-4">
        <div class="row mt-2">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-radius: 15px; background: #fff;">
                    
                    
                    <div class="mx-3 position-relative z-index-2">
                        <div class="px-4 d-flex align-items-center justify-content-between"
                            style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 75px; margin-top: -25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                            <h6 class="text-white mb-0 font-weight-bold" style="letter-spacing: 0.5px;">Laporan Peminjaman</h6>
                        </div>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0 mt-4">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr class="text-secondary opacity-7">
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-4 py-3">No</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3">Nama Anggota</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3">Judul Buku</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">Tanggal Pinjam</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">Jatuh Tempo</th>
                                        <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $peminjamans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr style="border-bottom: 1px solid #f2f2f2;">
                                            <td class="ps-4">
                                                <span class="text-xs font-weight-bold"><?php echo e($index + 1); ?></span>
                                            </td>
                                            <td class="ps-2">
                                                <p class="text-sm font-weight-bold mb-0" style="color: #344767;">
                                                    <?php echo e($item->user->name ?? '-'); ?>

                                                </p>
                                            </td>
                                            <td class="ps-2">
                                                <span class="text-xs text-secondary font-weight-normal">
                                                    <?php echo e($item->buku->judul ?? '-'); ?>

                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="text-xs text-secondary font-weight-normal">
                                                    <?php echo e($item->tgl_pinjam ? date('d-m-Y', strtotime($item->tgl_pinjam)) : '-'); ?>

                                                </span>
                                            </td>
                                            
                                            
                                            <td class="text-center">
                                                <?php
                                                    $isOverdue = $item->jatuh_tempo && strtotime($item->jatuh_tempo) < strtotime(date('Y-m-d'));
                                                    $statusNow = strtoupper($item->status);
                                                ?>
                                                <span class="text-xs font-weight-bold <?php echo e($isOverdue && !in_array($statusNow, ['KEMBALI', 'DIKEMBALIKAN', 'SELESAI']) ? 'text-danger' : 'text-secondary'); ?>">
                                                    <?php echo e($item->jatuh_tempo ? date('d-m-Y', strtotime($item->jatuh_tempo)) : '-'); ?>

                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <?php $status = strtoupper($item->status); ?>
                                                
                                                <?php if(in_array($status, ['PENDING', 'MENUNGGU'])): ?>
                                                    <span class="badge badge-sm" style="background-color: #fbc02d; color: #fff;">PENDING</span>
                                                <?php elseif($status == 'WAITING'): ?>
                                                    <span class="badge badge-sm" style="background-color: #fb8c00; color: #fff;">WAITING</span>
                                                <?php elseif($status == 'DIPINJAM' || $status == 'AKTIF'): ?>
                                                    <span class="badge badge-sm" style="background-color: #3f51b5; color: #fff;">DIPINJAM</span>
                                                <?php elseif(in_array($status, ['KEMBALI', 'DIKEMBALIKAN', 'SELESAI'])): ?>
                                                    <span class="badge badge-sm" style="background-color: #2dce89; color: #fff;">DIKEMBALIKAN</span>
                                                <?php else: ?>
                                                    <span class="badge badge-sm bg-secondary text-white"><?php echo e($status); ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="6" class="text-center py-5">
                                                <p class="text-secondary text-sm mb-0">Tidak ada data peminjaman.</p>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/kepala/laporanpeminjaman.blade.php ENDPATH**/ ?>