

<?php $__env->startSection('content'); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo e(asset('assets/js/validation-buku.js')); ?>"></script>

<div class="container-fluid py-4">
  <div class="row mt-2">
    <div class="col-12">
      <div class="card shadow-sm border-0" style="border-radius: 15px; background: #fff;">
        
        
        <div class="mx-3 position-relative z-index-2">
          <div class="px-4 d-flex align-items-center justify-content-between" 
              style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 75px; margin-top: -25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
            <h6 class="text-white mb-0 font-weight-bold" style="letter-spacing: 0.5px;">Data Buku</h6>

            
            <a href="<?php echo e(route('buku.create')); ?>" class="btn btn-sm mb-0" 
                style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.4); color: #fff; border-radius: 8px; text-transform: none; font-size: 12px;">
              + Tambah Buku
            </a>
          </div>
        </div>

        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0 mt-4"> 
              <table class="table align-items-center mb-0">
                  <thead>
                    <tr class="text-secondary opacity-7">
                      <th class="text-uppercase text-xxs font-weight-bolder ps-4 py-3">ID</th>
                      <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3">JUDUL BUKU</th>
                      <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3">PENULIS</th>
                      <th class="text-center text-uppercase text-xxs font-weight-bolder py-3">STOK</th>
                      <th class="text-center text-uppercase text-xxs font-weight-bolder py-3">AKSI</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $bukus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $buku): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #f2f2f2;">
                      <td class="ps-4">
                        <span class="text-xs font-weight-bold text-dark"><?php echo e(str_pad($buku->id, 2, '0', STR_PAD_LEFT)); ?></span>
                      </td>
                      <td class="ps-2">
                        <p class="text-sm font-weight-bold mb-0" style="color: #344767;"><?php echo e($buku->judul); ?></p>
                      </td>
                      <td class="ps-2">
                        <span class="text-xs text-secondary font-weight-normal"><?php echo e($buku->penulis); ?></span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-xs font-weight-bold text-secondary"><?php echo e($buku->stok); ?></span>
                      </td>
                      <td class="align-middle text-center">
                        <div class="d-flex justify-content-center gap-2">
                          
                          
                          <a href="<?php echo e(route('buku.edit', $buku->id)); ?>" class="btn btn-xs mb-0 px-3 py-1" 
                              style="background-color: #2152ff; color: #fff; font-size: 10px; border-radius: 5px; font-weight: 700; border: none;">
                              EDIT
                          </a>
                          
                          
                          <form action="<?php echo e(route('buku.destroy', $buku->id)); ?>" method="POST" id="form-hapus-<?php echo e($buku->id); ?>">
                              <?php echo csrf_field(); ?>
                              <?php echo method_field('DELETE'); ?>
                              <button type="button" class="btn btn-xs mb-0 px-3 py-1 btn-hapus" data-id="<?php echo e($buku->id); ?>"
                                      style="background-color: #f44335; color: #fff; font-size: 10px; border-radius: 5px; font-weight: 700; border: none;">
                                      HAPUS
                              </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                      <td colspan="5" class="text-center py-5">
                        <p class="text-secondary text-sm mb-0">Wah, belum ada data buku nih.</p>
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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/petugas/buku.blade.php ENDPATH**/ ?>