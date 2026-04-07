<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;
use Auth;

class PengembalianController extends Controller
{
    public function index()
    {
        // Menampilkan buku yang statusnya masih dipinjam untuk dikembalikan
        $peminjamans = Peminjaman::where('user_id', Auth::id())
            ->whereIn('status', ['DI SETUJUI', 'dipinjam', 'DIPINJAM'])
            ->get();

        $totalDenda = 0;
        $tarifDenda = 2000;

        foreach ($peminjamans as $item) {
            $deadline = Carbon::parse($item->jatuh_tempo);
            $hariIni = Carbon::now();

            if ($hariIni->gt($deadline)) {
                $telat = $hariIni->diffInDays($deadline);
                $item->hitung_denda = $telat * $tarifDenda;
                $totalDenda += $item->hitung_denda;
            } else {
                $item->hitung_denda = 0;
            }
        }

        return view('anggota.pengembalian', compact('peminjamans', 'totalDenda'));
    }

    /**
     * Menampilkan halaman detail pengembalian
     */
    public function ajukan($id)
    {
        $peminjaman = Peminjaman::with('buku')->findOrFail($id);
        $book = $peminjaman->buku;

        $hariIni = Carbon::now()->startOfDay();
        $jatuhTempo = Carbon::parse($peminjaman->jatuh_tempo)->startOfDay();

        $terlambat = 0;
        $denda = 0;
        $tarifDenda = 2000;

        if ($hariIni->gt($jatuhTempo)) {
            $terlambat = $hariIni->diffInDays($jatuhTempo);
            $denda = $terlambat * $tarifDenda;
        }

        return view('anggota.ajukan-pengembalian', compact('peminjaman', 'book', 'terlambat', 'denda'));
    }

    public function proses(Request $request, $id)
    {
        $targetId = $request->id_peminjaman ?? $id;
        $peminjaman = Peminjaman::findOrFail($targetId);

        $tgl_kembali_real = now();
        $jatuh_tempo = Carbon::parse($peminjaman->jatuh_tempo);

        // Hitung denda & terlambat
        $denda = 0;
        $terlambat = 0; // Default 0 hari

        if ($tgl_kembali_real->gt($jatuh_tempo)) {
            $terlambat = $tgl_kembali_real->diffInDays($jatuh_tempo);
            $denda = $terlambat * 2000;
        }

        // 1. Update status peminjaman jadi WAITING
        $peminjaman->update([
            'status' => 'WAITING',
            'denda' => $denda,
            'tanggal_pengembalian' => $tgl_kembali_real
        ]);

        // 2. Simpan ke tabel pengembalians (FIX: Tambah field 'terlambat' & 'user_id')
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'user_id' => Auth::id(), // Pastikan kolom user_id ada di tabel
            'tanggal_kembali' => $tgl_kembali_real->format('Y-m-d'),
            'terlambat' => $terlambat, // <-- INI YANG TADI BIKIN EROR
            'denda' => $denda,
            'status' => 0,
        ]);

        return redirect()->route('peminjaman.history')->with('success', 'Permohonan pengembalian buku berhasil diajukan. Mohon tunggu verifikasi dari petugas perpustakaan.');
    }

    /**
     * KONFIRMASI OLEH PETUGAS: Status jadi DIKEMBALIKAN & Stok Nambah
     */
    public function konfirmasi($peminjaman_id)
    {
        $peminjaman = Peminjaman::findOrFail($peminjaman_id);

        // 1. Update status Peminjaman jadi DIKEMBALIKAN
        $peminjaman->update([
            'status' => 'DIKEMBALIKAN'
        ]);

        // 2. Update status di tabel Pengembalian jadi 1 (Selesai/OK)
        $pengembalian = Pengembalian::where('peminjaman_id', $peminjaman_id)->first();
        if ($pengembalian) {
            $pengembalian->update(['status' => 1]);
        }

        // 3. BARU DI SINI STOK BUKU DITAMBAH
        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stok');
        }

        // NOTIFIKASI FORMAL UNTUK PETUGAS
        return redirect()->back()->with('success', 'Data pengembalian telah berhasil diverifikasi. Status peminjaman telah diperbarui dan stok buku telah ditambahkan.');
    }
}