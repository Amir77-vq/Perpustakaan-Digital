<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Library</title>
<link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">LIBRARY</div>
        
        @if(session('error'))
        <p style="color:red; font-size:12px;">
        {{ session('error') }}
        </p>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

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
                <a href="{{ route('register') }}">Sign up</a>
            </p>
        </form>
    </div>
</div>

</body>
</html>