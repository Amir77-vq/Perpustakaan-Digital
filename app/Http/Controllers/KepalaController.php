<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KepalaController extends Controller
{
        public function laporanPeminjaman()
{
    $peminjamans = Peminjaman::with(['user', 'buku'])
        ->orderBy('created_at', 'desc') 
        ->get();

    return view('kepala.laporanpeminjaman', compact('peminjamans'));
}
    
    public function laporanPengembalian()
{
    $pengembalians = \App\Models\Pengembalian::with(['peminjaman.user', 'peminjaman.buku'])
        ->latest()
        ->get();

    return view('kepala.laporanpengembalian', compact('pengembalians'));
}

public function laporanDenda()
{
    // Samain kayak petugas, narik dari model Peminjaman
    $peminjamans = Peminjaman::with(['user', 'buku'])
        ->where('denda', '!=', 0)
        ->latest()
        ->get();

    return view('kepala.laporandenda', compact('peminjamans'));
}

    public function anggota()
    {
        $anggotas = User::latest()->get();
        return view('kepala.anggota', compact('anggotas'));
    }

    public function anggotaCreate()
    {
        return view('kepala.create-anggota');
    }

    public function anggotaStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'no_hp' => 'required|numeric'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota',
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('kepala.anggota')->with('success', 'Anggota ditambahkan!');
    }

    public function anggotaEdit($id)
    {
        $anggota = User::findOrFail($id);
        return view('kepala.edit-anggota', compact('anggota'));
    }

    public function anggotaUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc|unique:users,email,' . $id,
            'role' => 'required|in:kepala,petugas,anggota',
            'password' => 'nullable|min:6',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email sudah terdaftar.',
            'role.required' => 'Silakan pilih hak akses.',
        ]);

        $user = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('kepala.anggota')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function anggotaDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Anggota berhasil dihapus!');
    }

}