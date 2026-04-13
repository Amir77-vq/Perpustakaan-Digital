


<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-create-buku.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row mt-2 justify-content-center">
        
        <div class="col-lg-12 col-12">
            <div class="card shadow-sm border-0" style="border-radius: 15px; background: #fff;">
                
                
                <div class="mx-3 position-relative z-index-2">
                    <div class="px-4 d-flex align-items-center" 
                        style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 80px; margin-top: -30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <h5 class="text-white mb-0 font-weight-bold">Tambah Buku</h5>
                    </div>
                </div>

                <div class="card-body pt-5 pb-4 px-5">
                    <form action="<?php echo e(route('buku.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        
                        <div class="row mb-4 align-items-center">
                            <div class="col-auto" style="min-width: 120px;">
                                <label class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Judul Buku</label>
                            </div>
                            <div class="col">
                                <input type="text" name="judul" class="form-control" 
                                    style="border: 1px solid #d2d6da; border-radius: 5px; padding: 10px 15px;" 
                                    placeholder="Masukkan judul buku..." required>
                            </div>
                        </div>

                        
                        <div class="row mb-4 align-items-center">
                            <div class="col-auto" style="min-width: 120px;">
                                <label class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Penulis</label>
                            </div>
                            <div class="col">
                                <input type="text" name="penulis" class="form-control" 
                                    style="border: 1px solid #d2d6da; border-radius: 5px; padding: 10px 15px;" 
                                    placeholder="Nama penulis..." required>
                            </div>
                        </div>

                        
                        <div class="row mb-4 align-items-center">
                            <div class="col-auto" style="min-width: 120px;">
                                <label class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Stok</label>
                            </div>
                            <div class="col">
                                <input type="number" name="stok" class="form-control" 
                                    style="border: 1px solid #d2d6da; border-radius: 5px; padding: 10px 15px; width: 150px;" 
                                    placeholder="0" required>
                            </div>
                        </div>

                        
                        <div class="row mb-5 align-items-center">
                            <div class="col-auto" style="min-width: 120px;">
                                <label class="font-weight-bold text-dark mb-0" style="font-size: 14px;">Cover Buku</label>
                            </div>
                            <div class="col">
                                <input type="file" name="cover" class="form-control" 
                                    style="border: 1px solid #d2d6da; border-radius: 5px; padding: 8px;">
                                <small class="text-muted" style="font-size: 11px;">*Format: JPG, PNG, JPEG (Maks 2MB)</small>
                            </div>
                        </div>

                        <hr class="horizontal dark mt-0 mb-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('petugas.buku')); ?>" class="btn btn-sm mb-0 px-4 py-2" 
                                style="border: 1px solid #344767; color: #344767; background: transparent; border-radius: 8px; font-weight: bold; text-transform: none;">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-sm mb-0 px-5 py-2" 
                                style="background: linear-gradient(310deg, #2152ff, #21d4fd); color: #fff; border-radius: 8px; font-weight: bold; text-transform: uppercase; border: none;">
                                SIMPAN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/petugas/create-buku.blade.php ENDPATH**/ ?>