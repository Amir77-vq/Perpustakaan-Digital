<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian; // FIX: Tambahkan ini agar tabel pengembalians terisi
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
     * Menampilkan halaman detail pengembalian (yang ada foto & denda)
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

        $denda = 0;
        if ($tgl_kembali_real->gt($jatuh_tempo)) {
            $selisih_hari = $tgl_kembali_real->diffInDays($jatuh_tempo);
            $denda = $selisih_hari * 2000;
        }

        // 1. Update data peminjaman (Status berubah jadi DIKEMBALIKAN)
        $peminjaman->update([
            'status' => 'DIKEMBALIKAN',
            'denda' => $denda,
            'tanggal_pengembalian' => $tgl_kembali_real
        ]);

        // 2. FIX: Simpan data ke tabel PENGEMBALIANS agar di phpMyAdmin ada isinya
// Hitung selisih hari terlambat (asumsi Abang punya logika hitung denda di atasnya)
// Jika variabel terlambat belum ada, kita buat simpel dulu:
        $hari_terlambat = $tgl_kembali_real->diffInDays($peminjaman->tanggal_kembali, false);
        $terlambat = $hari_terlambat < 0 ? abs($hari_terlambat) : 0;

        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'user_id' => Auth::id(),
            'tanggal_kembali' => $tgl_kembali_real->format('Y-m-d'),
            'terlambat' => $terlambat, // <-- TAMBAHKAN INI
            'denda' => $denda,
        ]);
        // 3. Kembalikan stok buku
        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stok');
        }

        // 4. Redirect ke halaman HISTORY agar user bisa lihat bukti pengembaliannya
        return redirect()->route('peminjaman.history')->with('success', 'Buku berhasil dikembalikan. Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }
}