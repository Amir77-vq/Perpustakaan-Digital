<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    /**
     * Dashboard Petugas
     */
    public function index()
    {
        $totalBuku = Buku::count();
        $totalAnggota = User::where('role', 'anggota')->count();
        $peminjamanAktif = Peminjaman::where('status', 'DIPINJAM')->count();
        $dendaBelumDibayar = Peminjaman::where('denda', '>', 0)->sum('denda');

        $recentActivities = Peminjaman::with(['user', 'buku'])->latest()->limit(10)->get();

        return view('petugas.dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'peminjamanAktif',
            'totalBuku', 
            'dendaBelumDibayar',
            'recentActivities'
        ));
    }

    /**
     * Manajemen Peminjaman
     */
    public function peminjaman()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])
            ->whereIn('status', ['PENDING', 'DIPINJAM', 'WAITING'])
            ->latest()
            ->get();

        return view('petugas.peminjaman', compact('peminjamans'));
    }

    public function konfirmasiPeminjaman($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status === 'DIPINJAM') {
            return redirect()->back()->with('error', 'Peminjaman ini sudah dikonfirmasi.');
        }

        $peminjaman->update([
            'status' => 'DIPINJAM'
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil dikonfirmasi!');
    }

    /**
     * Manajemen Pengembalian
     */
    public function pengembalian()
    {
        $pengembalians = Peminjaman::with(['user', 'buku'])
            ->whereIn('status', ['WAITING', 'DIKEMBALIKAN'])
            ->latest('updated_at') 
            ->get();

        return view('petugas.pengembalian', compact('pengembalians'));
    }

    public function konfirmasiPengembalian($id)
{
    $peminjaman = Peminjaman::findOrFail($id);
    $pengembalian = Pengembalian::where('peminjaman_id', $id)->first();

    $tglSekarangStr = date('Y-m-d');

    $jatuhTempo = Carbon::parse($peminjaman->jatuh_tempo)->startOfDay();
    $tglBalik = Carbon::parse($tglSekarangStr)->startOfDay();

    $terlambat = $tglBalik->gt($jatuhTempo) ? $tglBalik->diffInDays($jatuhTempo) : 0;
    $denda = $terlambat * 2000;

    DB::beginTransaction();
    try {
        if (!$pengembalian) {
            $pengembalian = new Pengembalian();
            $pengembalian->peminjaman_id = $id;
        }
        
        $pengembalian->tanggal_kembali = $tglSekarangStr;
        $pengembalian->terlambat = $terlambat;
        $pengembalian->denda = $denda;
        $pengembalian->status = 1;
        $pengembalian->save();

        $statusBaru = ($denda > 0) ? 'TERLAMBAT' : 'DIKEMBALIKAN';

        $peminjaman->update([
            'status' => $statusBaru,
            'denda' => $denda,
            'tgl_kembali' => $tglSekarangStr 
        ]);

        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stok');
        }

        DB::commit();

        $tglIndo = date('d/m/Y', strtotime($tglSekarangStr));
        
        if ($denda > 0) {
            $pesan = "Pengembalian berhasil dikonfirmasi pada {$tglIndo}. Terlambat {$terlambat} hari (Denda: Rp " . number_format($denda, 0, ',', '.') . ").";
        } else {
            $pesan = "Pengembalian berhasil dikonfirmasi pada {$tglIndo}. Buku dikembalikan tepat waktu.";
        }

        return redirect()->back()->with('success', $pesan);

    } catch (\Exception $e) {
        DB::rollback();
        
        return redirect()->back()->with('error', 'Terjadi kesalahan sistem saat memproses pengembalian: ' . $e->getMessage());
    }
}

    /**
     * Manajemen Denda
     */
    public function denda()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])
            ->where('denda', '>', 0)
            ->latest()
            ->get();

        return view('petugas.denda', compact('peminjamans'));
    }

    public function konfirmasiLunas($id)
    {
        $item = Peminjaman::findOrFail($id);
        $item->update([
            'status' => 'DIKEMBALIKAN',
         // 'denda' => 0 
        ]);
        return redirect()->back()->with('success', 'Pembayaran denda berhasil dikonfirmasi!');
    }

    /**
     * CRUD Buku
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
        $request->validate(['judul' => 'required', 'penulis' => 'required', 'stok' => 'required|numeric']);
        $data = $request->all();
        if ($request->hasFile('cover')) {
            $data['cover'] = time() . '_' . $request->file('cover')->getClientOriginalName();
            $request->file('cover')->storeAs('public/covers', $data['cover']);
        }
        Buku::create($data);
        return redirect()->route('petugas.buku')->with('success', 'Buku ditambahkan!');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('petugas.edit-buku', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $data = $request->all();
        if ($request->hasFile('cover')) {
            if ($buku->cover) Storage::delete('public/covers/' . $buku->cover);
            $data['cover'] = time() . '_' . $request->file('cover')->getClientOriginalName();
            $request->file('cover')->storeAs('public/covers', $data['cover']);
        }
        $buku->update($data);
        return redirect()->route('petugas.buku')->with('success', 'Buku diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        if ($buku->cover) Storage::delete('public/covers/' . $buku->cover);
        $buku->delete();
        return redirect()->back()->with('success', 'Buku dihapus!');
    }
}