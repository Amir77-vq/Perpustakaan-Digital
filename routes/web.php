<?php

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\PetugasController;

// --- GUEST ROUTES ---
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'role'     => 'required'
        ]);

        $credentials['role'] = strtolower($request->role);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/dashboard');
        }
        return back()->with('error', 'Email / Password / Role salah');
    })->name('login.post');

    Route::get('/register', fn() => view('auth.register'))->name('register');

    Route::post('/register', function (Request $request) {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => strtolower($request->role)
        ]);

        return redirect('/login');
    })->name('register.post');
});

// --- LOGOUT ---
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::get('/', fn() => redirect('/dashboard'));

// --- AUTHENTICATED ROUTES ---
Route::middleware(['auth'])->group(function () {

    // --- PROFILE ROUTES ---
    Route::get('/profile', fn() => view('profile'))->name('profile');
    
    // RUTE UPDATE INI YANG BIKIN ERROR TADI KARENA GA ADA
    Route::post('/profile/update', function (Request $request) {
        $user = Auth::user();
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        if (isset($user->nama)) { $user->nama = $request->nama; } 
        else { $user->name = $request->nama; }

        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    })->name('profile.update');

    // --- DASHBOARD CENTRAL ---
    Route::get('/dashboard', function () {
        $userId = auth()->id();
        $user   = auth()->user();
        $role   = strtolower($user->role);

        $books = Buku::latest()->take(8)->get();

        if ($role === 'anggota') {
            $recentLoans = Peminjaman::with('buku')
                ->where('user_id', $userId)
                ->latest()
                ->take(5)
                ->get();

            $totalPeminjaman   = Peminjaman::where('user_id', $userId)->count();
            $sedangDipinjam    = Peminjaman::where('user_id', $userId)->where('status', 'dipinjam')->count();
            $totalPengembalian = Peminjaman::where('user_id', $userId)->where('status', 'dikembalikan')->count();
            $totalDenda        = Peminjaman::where('user_id', $userId)->sum('denda');

            return view('anggota.dashboard', compact('books', 'recentLoans', 'totalPeminjaman', 'sedangDipinjam', 'totalPengembalian', 'totalDenda'));
        }

        if ($role === 'petugas') {
            return (new PetugasController)->index();
        }

        if ($role === 'kepala') {
            return view('kepala.dashboard', compact('books'));
        }

        abort(403, "Role ($role) tidak terdaftar di sistem.");
    })->name('dashboard');

    // --- ROLE: ANGGOTA ---
    Route::middleware(['role:anggota'])->group(function () {
        Route::prefix('buku')->group(function () {
            Route::get('/', [BukuController::class, 'index'])->name('buku.index');
            Route::get('/detail/{id}', [BukuController::class, 'show'])->name('buku.show');
            Route::get('/detail/{id}/peminjaman', [BukuController::class, 'ajukan'])->name('buku.ajukan');
        });

        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/history', [PeminjamanController::class, 'history'])->name('peminjaman.history');
        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
        Route::get('/pengembalian/ajukan/{id}', [PengembalianController::class, 'ajukan'])->name('pengembalian.ajukan');
        Route::post('/pengembalian/{id}/proses', [PengembalianController::class, 'proses'])->name('pengembalian.proses');
    });

    // --- ROLE: PETUGAS ---
    Route::middleware(['role:petugas'])->group(function () {
        Route::get('/petugas/buku', [PetugasController::class, 'buku'])->name('petugas.buku');
        Route::get('/petugas/buku/create', [PetugasController::class, 'create'])->name('buku.create');
        Route::post('/petugas/buku/store', [PetugasController::class, 'store'])->name('buku.store');
        Route::get('/petugas/buku/{id}/edit', [PetugasController::class, 'edit'])->name('buku.edit');
        Route::put('/petugas/buku/{id}/update', [PetugasController::class, 'update'])->name('buku.update'); 
        Route::delete('/petugas/buku/{id}', [PetugasController::class, 'destroy'])->name('buku.destroy');

        Route::get('/petugas/anggota', [PetugasController::class, 'anggota'])->name('petugas.anggota');
        Route::get('/petugas/anggota/create', [PetugasController::class, 'anggotaCreate'])->name('anggota.create');
        Route::post('/petugas/anggota/store', [PetugasController::class, 'anggotaStore'])->name('anggota.store');
        Route::get('/petugas/anggota/{id}/edit', [PetugasController::class, 'anggotaEdit'])->name('anggota.edit');
        Route::put('/petugas/anggota/{id}/update', [PetugasController::class, 'anggotaUpdate'])->name('anggota.update'); 
        Route::delete('/petugas/anggota/{id}', [PetugasController::class, 'anggotaDestroy'])->name('anggota.destroy');
        Route::put('/anggota/{id}/reset', [PetugasController::class, 'anggotaReset'])->name('anggota.reset');

        Route::get('/peminjaman-petugas', [PetugasController::class, 'peminjaman'])->name('petugas.peminjaman');
        Route::post('/peminjaman/{id}/konfirmasi', [PetugasController::class, 'konfirmasiPeminjaman'])->name('peminjaman.konfirmasi');
        Route::get('/pengembalian-petugas', [PetugasController::class, 'pengembalian'])->name('petugas.pengembalian');
        Route::post('/pengembalian/konfirmasi/{id}', [PetugasController::class, 'konfirmasiPengembalian'])->name('pengembalian.konfirmasi');
        Route::get('/denda', [PetugasController::class, 'denda'])->name('petugas.denda');
    });

    // --- ROLE: KEPALA ---
    Route::middleware(['role:kepala'])->group(function () {
        Route::get('/laporan/buku', fn() => view('kepala.laporan-buku'))->name('kepala.laporan_buku');
        Route::get('/laporan/peminjaman', fn() => view('kepala.laporan-peminjaman'))->name('kepala.laporan_peminjaman');
    });
});