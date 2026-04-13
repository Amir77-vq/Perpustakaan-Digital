<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Pengembalian; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search');

        $peminjamans = Peminjaman::where('user_id', Auth::id())
            ->whereIn('status', ['PENDING', 'DIPINJAM', 'DI SETUJUI', 'WAITING'])
            ->when($search, function ($query) use ($search) {
                return $query->where('judul_buku', 'LIKE', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('anggota.peminjaman', compact('peminjamans'));
    }

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

public function prosesPengembalian($id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    
    // Pake startOfDay biar hitungan harinya presisi (nggak hitung jam)
    $tgl_sekarang = Carbon::now()->startOfDay();
    $jatuh_tempo = Carbon::parse($peminjaman->jatuh_tempo)->startOfDay();
    $denda = 0;
    $terlambat = 0;

    if ($tgl_sekarang->gt($jatuh_tempo)) {
        $terlambat = $tgl_sekarang->diffInDays($jatuh_tempo);
        $denda = $terlambat * 2000;
    }

    // Update di tabel peminjaman
    $peminjaman->update([
        'status' => 'WAITING',
        'tgl_kembali' => $tgl_sekarang->toDateString(), 
        'terlambat' => $terlambat,
        'denda' => $denda
    ]);

    // Update atau buat di tabel pengembalian (sesuaikan kolom migration)
    Pengembalian::updateOrCreate(
        ['peminjaman_id' => $peminjaman->id],
        [
            'tanggal_kembali' => $tgl_sekarang->toDateString(),
            'terlambat' => $terlambat,
            'denda' => $denda,
            'status' => 0 // Masih pending konfirmasi petugas
        ]
    );

    return redirect()->route('peminjaman.index')->with('success', 'Permintaan pengembalian dikirim!');
}

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
            'user_id' => Auth::id(),
            'buku_id' => $buku->id,
            'judul_buku' => $buku->judul,
            // 'tgl_pinjam'  => Carbon::now()->format('Y-m-d'),
            // 'jatuh_tempo' => Carbon::now()->addDays(7)->format('Y-m-d'),
            'tgl_pinjam' => $request->tgl_pinjam,
            'jatuh_tempo' => $request->jatuh_tempo,
            'status' => 'PENDING',
        ]);

        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')->with('success', 'Berhasil diajukan! Tunggu konfirmasi petugas.');
    }
}