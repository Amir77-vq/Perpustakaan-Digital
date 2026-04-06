<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman; 
use App\Models\Buku;
use App\Models\Pengembalian; // Tambahkan ini agar sinkron
use Carbon\Carbon;          
use Illuminate\Support\Facades\Auth; 

class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar pinjaman aktif milik anggota
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $peminjamans = Peminjaman::where('user_id', Auth::id())
            ->whereIn('status', ['PENDING', 'DIPINJAM', 'DI SETUJUI']) // Tambahkan DI SETUJUI agar muncul
            ->when($search, function ($query) use ($search) {
                return $query->where('judul_buku', 'LIKE', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('anggota.peminjaman', compact('peminjamans'));
    }

    /**
     * Menampilkan seluruh riwayat peminjaman anggota
     */
    public function history(Request $request)
    {
        $search = $request->get('search');

        $peminjamans = Peminjaman::where('user_id', Auth::id())
            ->when($search, function ($query) use ($search) {
                return $query->where('judul_buku', 'LIKE', "%{$search}%");
            })
            ->orderBy('created_at', 'desc') 
            ->get();

        $totalDenda = $peminjamans->sum('denda');

        return view('anggota.history', compact('peminjamans', 'totalDenda'));
    }

    /**
     * Proses pengembalian buku oleh anggota
     */
    public function prosesPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $tgl_sekarang = Carbon::now();
        $jatuh_tempo = Carbon::parse($peminjaman->jatuh_tempo);
        $denda = 0;

        // Hitung denda jika terlambat
        if ($tgl_sekarang->gt($jatuh_tempo)) {
            $selisih = $tgl_sekarang->diffInDays($jatuh_tempo);
            $denda = $selisih * 2000;
        }

        // 1. Update status di tabel peminjamans
        $peminjaman->update([
            'status' => 'DIKEMBALIKAN', // Samakan dengan PengembalianController
            'tgl_kembali' => $tgl_sekarang->format('Y-m-d'),
            'denda' => $denda
        ]);

        // 2. Simpan ke tabel pengembalians agar di phpMyAdmin terisi
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'user_id'       => Auth::id(),
            'tgl_kembali'   => $tgl_sekarang->format('Y-m-d'),
            'denda'         => $denda,
        ]);

        // 3. Kembalikan stok buku
        $buku = Buku::find($peminjaman->buku_id);
        if ($buku) {
            $buku->increment('stok');
        }

        return redirect()->route('peminjaman.history')->with('success', 'Buku berhasil dikembalikan!');
    }

    /**
     * Menyimpan data peminjaman baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:bukus,id' 
        ]);

        $sudahPinjam = Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $request->id_buku)
            ->whereIn('status', ['PENDING', 'DIPINJAM', 'DI SETUJUI'])
            ->exists();

        if ($sudahPinjam) {
            return redirect()->back()->with('error', 'Anda masih meminjam buku ini.');
        }

        $buku = Buku::findOrFail($request->id_buku);

        if ($buku->stok <= 0) {
            return redirect()->back()->with('error', 'Stok buku ini sudah habis!');
        }

        Peminjaman::create([
            'user_id'     => Auth::id(),
            'buku_id'     => $buku->id,
            'judul_buku'  => $buku->judul, 
            'tgl_pinjam'  => Carbon::now()->format('Y-m-d'),
            'jatuh_tempo' => Carbon::now()->addDays(7)->format('Y-m-d'),
            'status'      => 'PENDING', 
        ]);

        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')->with('success', 'Berhasil diajukan! Tunggu konfirmasi petugas.');
    }
}