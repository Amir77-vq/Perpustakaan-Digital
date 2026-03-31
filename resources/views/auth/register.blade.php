<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
</head>
<body>

    @if ($errors->any())
    <div style="color:red">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

<div class="container right">
    <div class="card">
        <h2 class="title">Sign Up</h2>

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

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
                <a href="{{ route('login') }}">Sign in</a>
            </p>
        </form>
    </div>
</div>

</body>
</html>