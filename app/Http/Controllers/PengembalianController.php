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
    $peminjamans = Peminjaman::where('user_id', Auth::id())
        ->whereIn('status', ['DIPINJAM', 'WAITING']) 
        ->get();

    $totalDenda = 0;
    $tarifDenda = 2000;

    foreach ($peminjamans as $item) {
        $deadline = Carbon::parse($item->jatuh_tempo)->startOfDay();
        $hariIni = Carbon::now()->startOfDay();

        if ($hariIni->gt($deadline)) {
            $item->warna_tanggal = 'text-danger';
            $item->btn_warna = 'bg-gradient-danger';
            
            $telat = $hariIni->diffInDays($deadline);
            $item->hitung_denda = $telat * $tarifDenda;
            $totalDenda += $item->hitung_denda;
        } else {
            $item->warna_tanggal = $hariIni->eq($deadline) ? 'text-warning' : 'text-secondary';
            $item->btn_warna = $hariIni->eq($deadline) ? 'bg-gradient-warning' : 'bg-gradient-info';
            $item->hitung_denda = 0;
        }
    }

    return view('anggota.pengembalian', compact('peminjamans', 'totalDenda'));
}

    public function ajukan($id)
{
    $peminjaman = Peminjaman::with('buku')->findOrFail($id);
    $book = $peminjaman->buku;

    if ($peminjaman->status !== 'DIPINJAM') {
        return redirect()->route('pengembalian.index')
            ->with('error', 'Transaksi ini sudah diproses atau sedang menunggu verifikasi.');
    }

    $hariIni = Carbon::now()->startOfDay();
    $jatuhTempo = Carbon::parse($peminjaman->jatuh_tempo)->startOfDay();

    $terlambat = 0;
    $denda = 0;
    $tarifDenda = 2000;

    if ($hariIni->gt($jatuhTempo)) {
        $terlambat = $hariIni->diffInDays($jatuhTempo);
        $denda = $terlambat * $tarifDenda;
        return view('anggota.ajukan-denda', compact('peminjaman', 'book', 'terlambat', 'denda'));
    }

    return view('anggota.ajukan-pengembalian', compact('peminjaman', 'book', 'terlambat', 'denda'));
}

    public function proses(Request $request, $id)
    {
        $targetId = $request->id_peminjaman ?? $id;
        $peminjaman = Peminjaman::findOrFail($targetId);

        $tgl_kembali_real = Carbon::now();
        $jatuh_tempo = Carbon::parse($peminjaman->jatuh_tempo)->startOfDay();
        $hari_ini = Carbon::now()->startOfDay();

        $denda = 0;
        $terlambat = 0;

        if ($hari_ini->gt($jatuh_tempo)) {
            $terlambat = $hari_ini->diffInDays($jatuh_tempo);
            $denda = $terlambat * 2000;
        }

        $peminjaman->update([
            'status' => 'WAITING',
            'denda' => $denda,
            'tanggal_pengembalian' => $tgl_kembali_real
        ]);

        Pengembalian::updateOrCreate(
            ['peminjaman_id' => $peminjaman->id],
            [
                'user_id' => Auth::id(),
                'tanggal_kembali' => $tgl_kembali_real->format('Y-m-d'),
                'terlambat' => $terlambat,
                'denda' => $denda,
                'status' => 0,
            ]
        );

        return redirect()->route('peminjaman.history')->with('success', 'Pengembalian diajukan! Denda: Rp ' . number_format($denda));
    }

}