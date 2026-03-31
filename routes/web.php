<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'role' => 'required'
    ]);

    if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password,
        'role' => $request->role
    ])) {
        $request->session()->regenerate();
        return redirect('/dashboard');
    }

    return back()->with('error', 'Email / Password salah');

})->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required'
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role
    ]);

    return redirect('/login');

})->name('register.post');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'anggota' => view('anggota.dashboard'),
        'petugas' => view('petugas.dashboard'),
        'kepala' => view('kepala.dashboard'),
        default => abort(403)
    };
})->name('dashboard');

Route::middleware(['auth', 'role:anggota'])->group(function () {
    Route::get('/buku', fn() => view('anggota.buku'));
    Route::get('/peminjaman', fn() => view('anggota.peminjaman'));
    Route::get('/pengembalian', fn() => view('anggota.pengembalian'));
    Route::get('/history', fn() => view('anggota.history'));
});

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/petugas/buku', fn() => view('petugas.buku'));
});

Route::middleware(['auth', 'role:kepala'])->group(function () {
    Route::get('/laporan', fn() => view('kepala.laporan-buku'));
    Route::get('/laporan/peminjaman', fn() => view('kepala.laporan-peminjaman'));
    Route::get('/laporan/pengembalian', fn() => view('kepala.laporan-pengembalian'));
    Route::get('/laporan/denda', fn() => view('kepala.laporan-denda'));
});

Route::middleware(['auth', 'role:anggota'])->group(function () {
    Route::get('/pengembalian', fn() => view('anggota.pengembalian'));
    Route::get('/history', fn() => view('anggota.history'));
});

Route::middleware(['auth', 'role:petugas'])->group(function () {

    Route::get('/buku', fn() => view('petugas.buku'));
    Route::get('/anggota', fn() => view('petugas.anggota'));
    Route::get('/peminjaman', fn() => view('petugas.peminjaman'));
    Route::get('/pengembalian', fn() => view('petugas.pengembalian'));
    Route::get('/denda', fn() => view('petugas.denda'));
});

Route::middleware(['auth', 'role:kepala'])->group(function () {
    Route::get('/laporan/buku', fn() => view('kepala.laporan-buku'));
});