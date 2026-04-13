<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Library</title>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/auth.css')); ?>">
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">LIBRARY</div>
        
        <?php if(session('error')): ?>
        <p style="color:red; font-size:12px;">
        <?php echo e(session('error')); ?>

        </p>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login.post')); ?>">
            <?php echo csrf_field(); ?>

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role">
                <option value="">Pilih Role</option>
                <option value="anggota">Anggota</option>
                <option value="petugas">Petugas</option>
                <option value="kepala">Kepala</option>
            </select>

            <button type="submit">LOGIN</button>

            <p class="link">Belum mempunyai akun? 
                <a href="<?php echo e(route('register')); ?>">Sign up</a>
            </p>
        </form>
    </div>
</div>

</body>
</html><?php /**PATH C:\laragon\www\perpustakaan-digital\resources\views/auth/login.blade.php ENDPATH**/ ?>