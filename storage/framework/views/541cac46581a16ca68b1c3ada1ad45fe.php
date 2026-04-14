<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/auth.css')); ?>">
</head>
<body>

    <?php if($errors->any()): ?>
    <div style="color:red">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <p><?php echo e($error); ?></p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

<div class="container right">
    <div class="card">
        <h2 class="title">Sign Up</h2>

        <form method="POST" action="<?php echo e(route('register.post')); ?>">
            <?php echo csrf_field(); ?>

            <input type="text" name="name" placeholder="Nama" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <select name="role" required>
                <option value="" disabled selected>Pilih Role</option>
                <option value="anggota">Anggota</option>
                <option value="petugas">Petugas</option>
                <option value="kepala">Kepala</option>
            </select>

            <button type="submit">SIGN UP</button>

            <p class="link">Sudah memiliki akun? 
                <a href="<?php echo e(route('login')); ?>">Sign in</a>
            </p>
        </form>
    </div>
</div>

</body>
</html><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/auth/register.blade.php ENDPATH**/ ?>