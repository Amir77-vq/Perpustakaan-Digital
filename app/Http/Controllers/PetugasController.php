<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PetugasController extends Controller
{
    /**
     * Dashboard Petugas
     */
    public function index()
    {
        $totalBuku = Buku::count();
        $totalAnggota = User::where('role', 'anggota')->count();
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();
        $dendaBelumDibayar = Peminjaman::where('status', 'belum_bayar')->sum('denda');

        $peminjaman = Peminjaman::select('id', 'user_id', 'buku_id', 'status', 'created_at')
            ->with(['user', 'buku']);

        $recentActivities = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->limit(10) 
            ->get();

        return view('petugas.dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'peminjamanAktif',
            'dendaBelumDibayar',
            'recentActivities'
        ));
    }

    /**
     * Manajemen Peminjaman
     */
    public function peminjaman()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->latest()->get();
        return view('petugas.peminjaman', compact('peminjamans'));
    }

    /**
     * Proses Konfirmasi Peminjaman
     */
    public function konfirmasiPeminjaman($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $peminjaman->update([
            'status' => 'DIPINJAM'
        ]);

        return redirect()->back()->with('success', 'Peminjaman dikonfirmasi!');
    }

    /**
     * Manajemen Pengembalian 
     */
    public function pengembalian()
    {
        $pengembalians = Pengembalian::with(['peminjaman.user', 'peminjaman.buku'])->latest()->get();
        return view('petugas.pengembalian', compact('pengembalians'));
    }

    /**
     * Proses Konfirmasi Pengembalian
     */
    public function konfirmasiPengembalian($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $jatuhTempo = Carbon::parse($pengembalian->peminjaman->jatuh_tempo);
        $tglKembali = Carbon::now();

        $terlambat = 0;
        $denda = 0;

        if ($tglKembali->gt($jatuhTempo)) {
            $terlambat = $tglKembali->diffInDays($jatuhTempo);
            $denda = $terlambat * 2000;
        }

        $pengembalian->update([
            'tanggal_kembali' => $tglKembali->format('Y-m-d'),
            'terlambat' => $terlambat,
            'denda' => $denda,
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'Pengembalian dikonfirmasi!');
    }

    /**
     * Manajemen Buku
     */
    public function buku()
    {
        $bukus = Buku::latest()->get();
        return view('petugas.buku', compact('bukus'));
    }

    public function create()
    {
        return view('petugas.create-buku');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'stok' => 'required|numeric',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'required' => 'Mohon lengkapi data ini.'
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $namaFile = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('public/covers', $namaFile);

            $data['cover'] = $namaFile;
        }

        Buku::create($data);
        return redirect()->route('petugas.buku')->with('success', 'Data buku ditambahkan!');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('petugas.edit-buku', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'stok' => 'required|numeric',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'required' => 'Mohon lengkapi data ini.'
        ]);

        $buku = Buku::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::delete('public/covers/' . $buku->cover);
            }

            $file = $request->file('cover');
            $namaFile = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('public/covers', $namaFile);

            $data['cover'] = $namaFile;
        }

        $buku->update($data);
        return redirect()->route('petugas.buku')->with('success', 'Data buku diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->cover) {
            Storage::delete('public/covers/' . $buku->cover);
        }

        $buku->delete();
        return redirect()->back()->with('success', 'Buku berhasil dihapus!');
    }

    /**
     * Manajemen Anggota
     */
    public function anggota()
    {
        $anggotas = User::where('role', 'anggota')->latest()->get();
        return view('petugas.anggota', compact('anggotas'));
    }

    public function anggotaCreate()
    {
        return view('petugas.create-anggota');
    }

    public function anggotaStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp' => 'required|numeric|starts_with:08|digits_between:10,13',
        ], [
            'required' => 'Mohon lengkapi data ini.',
            'min' => 'Password minimal 6 karakter.',
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'no_hp.starts_with' => 'Nomor HP harus diawali dengan 08.',
            'no_hp.digits_between' => 'Nomor HP harus 10-13 digit.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota',
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('petugas.anggota')->with('success', 'Anggota ditambahkan!');
    }

    public function anggotaEdit($id)
    {
        $anggota = User::findOrFail($id);
        return view('petugas.edit-anggota', compact('anggota'));
    }

    public function anggotaUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_hp' => 'required|numeric|starts_with:08|digits_between:10,13',
        ], [
            'required' => 'Mohon lengkapi data ini.',
            'no_hp.numeric' => 'Nomor HP harus berupa angka.',
            'no_hp.starts_with' => 'Nomor HP harus diawali dengan 08.',
            'no_hp.digits_between' => 'Nomor HP harus 10-13 digit.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('petugas.anggota')->with('success', 'Data anggota diperbarui!');
    }

    public function anggotaDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Anggota dihapus!');
    }

    public function anggotaReset($id)
    {
        $user = User::findOrFail($id);

        return redirect()->route('anggota.edit', $id)
            ->with('success', 'Password berhasil di reset.')
            ->with('reset_pass', 'perpustakaan444');
    }

    /**
     * Menampilkan Daftar Denda Anggota
     */
    public function denda()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])
            ->where('denda', '>', 0)
            ->latest()
            ->get();

        return view('petugas.denda', compact('peminjamans'));
    }
}