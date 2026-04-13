

<?php $__env->startSection('content'); ?>
<div class="container-fluid pt-0 py-4" id="pengembalian-page">
    <h3 class="font-weight-bold text-dark mt-n2 mb-4" style="font-size: 1.5rem;">
        Ajukan Pengembalian
    </h3>

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
                            <div class="book-cover-preview shadow-sm">
                                <?php if($book->cover): ?>
                                    <img src="<?php echo e(asset('storage/cover/' . $book->cover)); ?>" alt="<?php echo e($book->judul); ?>">
                                <?php else: ?>
                                    <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center bg-light" style="min-height: 250px; border-radius: 1rem;">
                                        <i class="fas fa-book fa-3x text-secondary mb-2"></i>
                                        <p class="text-xs text-secondary mb-0">No Cover</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        
                        <div class="col-lg-9 col-md-8 ps-lg-5">
                            <h4 class="text-dark font-weight-bolder mb-1" style="font-size: 1.6rem;"><?php echo e($book->judul); ?></h4>
                            
                            
                            <div class="pb-3 mb-4" style="border-bottom: 2px solid #ebeef2;">
                                <p class="text-sm text-muted mb-0">Penulis : <span class="text-dark font-weight-bold"><?php echo e($book->penulis); ?></span></p>
                            </div>

                            
                            <div class="pb-3 mb-4" style="border-bottom: 2px solid #ebeef2;">
                                <p class="font-weight-bold mb-1 text-uppercase text-xs text-muted">Periode Peminjaman</p>
                                <p class="text-dark font-weight-bold mb-0" style="font-size: 1.1rem;">
                                    <?php echo e(date('d M Y', strtotime($peminjaman->tgl_pinjam))); ?> — <?php echo e(date('d M Y', strtotime($peminjaman->jatuh_tempo))); ?>

                                </p>
                            </div>

                            
                            <?php if($terlambat > 0): ?>
                                <div class="alert-denda-pembayaran p-4 border-radius-lg mb-4" style="background-color: #fff5f5; border: 1px solid #ffe3e3;">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-danger-soft text-danger me-2" style="background-color: #fee2e2;">Terlambat <?php echo e($terlambat); ?> Hari</span>
                                    </div>

                                    <h5 class="font-weight-bolder text-danger mb-3" style="font-size: 1.25rem;">
                                        Total Denda : Rp <?php echo e(number_format($denda, 0, ',', '.')); ?>

                                    </h5>

                                    <div class="text-sm text-dark p-3 bg-white border-radius-lg shadow-sm">
                                        <p class="font-weight-bold mb-2 text-xs text-uppercase text-muted">Instruksi Pembayaran</p>
                                        <p class="mb-1 text-dark">Silakan lakukan pembayaran denda melalui kasir atau transfer:</p>
                                        <p class="font-weight-bold text-dark mb-0">Bank BCA: 1234-567-890 (A.N. Perpustakaan Digital)</p>
                                        <p class="text-xs text-muted mt-2">*Lampirkan bukti bayar saat menyerahkan buku ke petugas.</p>
                                    </div>
                                </div>

                                <form action="<?php echo e(route('pengembalian.proses', $peminjaman->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="id_peminjaman" value="<?php echo e($peminjaman->id); ?>">

                                    <div class="d-flex gap-2 mt-4">
                                        <button type="submit" class="btn btn-denda mb-0 btn-no-bias"
                                            style="border-radius: 8px; padding: 12px 30px; font-size: 0.8rem; font-weight: 700;">
                                            PROSES & BAYAR DENDA
                                        </button>
                                        <a href="<?php echo e(route('pengembalian.index')); ?>" class="btn btn-outline-secondary mb-0 btn-no-bias"
                                            style="border-radius: 8px; padding: 12px 30px; font-size: 0.8rem; font-weight: 700; border: 1.5px solid #d2d6da;">
                                            BATAL
                                        </a>
                                    </div>
                                </form>

                            <?php else: ?>
                                <div class="mb-3 p-3 bg-light border-radius-lg shadow-none border" style="background-color: #f0fff4 !important; border-color: #c6f6d5 !important;">
                                    <p class="text-success font-weight-bold mb-0" style="font-size: 1rem;">
                                        <i class="fas fa-check-circle me-1"></i> Tepat Waktu. Tidak ada denda.
                                    </p>
                                </div>

                                <form action="<?php echo e(route('pengembalian.proses', $peminjaman->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="id_peminjaman" value="<?php echo e($peminjaman->id); ?>">

                                    <div class="d-flex gap-2 mt-4">
                                        <button type="submit" class="btn btn-proses-simpel mb-0 btn-no-bias"
                                            style="border-radius: 8px; padding: 12px 30px; font-size: 0.8rem; font-weight: 700;">
                                            KEMBALIKAN BUKU
                                        </button>
                                        <a href="<?php echo e(route('pengembalian.index')); ?>" class="btn btn-outline-secondary mb-0 btn-no-bias"
                                            style="border-radius: 8px; padding: 12px 30px; font-size: 0.8rem; font-weight: 700; border: 1.5px solid #d2d6da;">
                                            BATAL
                                        </a>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    /* Tombol Biru Gradasi */
    #pengembalian-page .btn-proses-simpel {
        background: linear-gradient(310deg, #2152ff 0%, #21d4fd 100%) !important;
        color: #fff !important;
        border: none !important;
    }
    
    /* Tombol Denda (Merah-Oranye) */
    #pengembalian-page .btn-denda {
        background: linear-gradient(310deg, #ea0606 0%, #ff667c 100%) !important;
        color: #fff !important;
        border: none !important;
    }

    /* Hilangkan Bias Biru Saat Klik */
    .btn-no-bias:focus, .btn-no-bias:active {
        box-shadow: none !important;
        outline: none !important;
    }

    /* Layout Cover */
    #pengembalian-page .book-cover-preview {
        aspect-ratio: 3/4;
        border-radius: 1rem;
        overflow: hidden;
        background-color: #f8f9fa;
    }

    #pengembalian-page .book-cover-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/anggota/ajukan-pengembalian.blade.php ENDPATH**/ ?>