

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-petugas-anggota.css')); ?>">
    <style>
        .text-xxs {
            font-size: 0.65rem !important;
        }
        .card .text-xs {
            font-size: 0.75rem !important;
        }
        /* Style agar kotak badge seragam */
        .badge-role {
            display: inline-block;
            width: 80px; 
            text-align: center;
            text-transform: uppercase;
            font-size: 10px;
            border-radius: 4px;
            padding: 5px 0;
            font-weight: bold;
            color: #fff;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?php echo e(asset('assets/js/buku.js')); ?>"></script>

<div class="container-fluid py-4">
  <div class="row mt-2"> 
    <div class="col-12">
      <div class="card shadow-sm border-0" style="border-radius: 15px; background: #fff;">     
        <div class="mx-3 position-relative z-index-2">
          <div class="px-4 d-flex align-items-center justify-content-between" 
              style="background: linear-gradient(310deg, #2152ff, #21d4fd); border-radius: 10px; min-height: 75px; margin-top: -25px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
            <h6 class="text-white mb-0 font-weight-bold" style="letter-spacing: 0.5px;">Data Pengguna</h6>
            <a href="<?php echo e(route('anggota.create')); ?>" class="btn btn-sm mb-0" 
                style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.4); color: #fff; border-radius: 8px; text-transform: none; font-size: 12px;">
              + Tambah Data
            </a>
          </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0 mt-4"> 
              <table class="table align-items-center mb-0">
                  <thead>
                    <tr class="text-secondary opacity-7">
                      <th class="text-uppercase text-xxs font-weight-bolder ps-4 py-3">ID</th>
                      <th class="text-uppercase text-xxs font-weight-bolder ps-2 py-3">NAMA</th>
                      <th class="text-uppercase text-xxs font-weight-bolder py-3" style="padding-left: 35px;">ROLE</th>
                      <th class="text-center text-uppercase text-xxs font-weight-bolder py-3">AKSI</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $anggotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $anggota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom: 1px solid #f2f2f2;">
                      <td class="ps-4">
                        <span class="text-xs font-weight-bold text-dark">U<?php echo e(str_pad($anggota->id, 2, '0', STR_PAD_LEFT)); ?></span>
                      </td>
                      <td class="ps-2">
                        <p class="text-sm font-weight-bold mb-0" style="color: #344767;"><?php echo e($anggota->name); ?></p>
                      </td>
                      <td style="padding-left: 35px;">
                        <span class="badge-role" 
                              style="background: <?php echo e($anggota->role == 'kepala' ? '#f44335' : ($anggota->role == 'petugas' ? '#2152ff' : '#67748e')); ?>;">
                          <?php echo e($anggota->role); ?>

                        </span>
                      </td>
                      <td class="align-middle text-center">
                        <div class="d-flex justify-content-center gap-2">
                          <a href="<?php echo e(route('anggota.edit', $anggota->id)); ?>" class="btn btn-xs mb-0 px-3 py-1" 
                              style="background-color: #2152ff; color: #fff; font-size: 10px; border-radius: 5px; font-weight: 700; border: none;">
                              EDIT
                          </a>
                          <form action="<?php echo e(route('anggota.destroy', $anggota->id)); ?>" method="POST" id="form-hapus-<?php echo e($anggota->id); ?>">
                              <?php echo csrf_field(); ?>
                              <?php echo method_field('DELETE'); ?>
                              <button type="button" class="btn btn-xs mb-0 px-3 py-1 btn-hapus" data-id="<?php echo e($anggota->id); ?>"
                                      style="background-color: #f44335; color: #fff; font-size: 10px; border-radius: 5px; font-weight: 700; border: none;">
                                      HAPUS 
                              </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                      <td colspan="4" class="text-center py-5">
                        <p class="text-secondary text-sm mb-0">Belum ada data pengguna.</p>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-hapus');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const dataId = this.getAttribute('data-id');
                const form = document.getElementById('form-hapus-' + dataId);

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#f44335',
                    cancelButtonColor: '#67748e',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/kepala/anggota.blade.php ENDPATH**/ ?>