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
        $dendaBelumDibayar = Peminjaman::where('denda', '!=', 0)->get()->sum(function ($item) {
            return abs($item->denda);
        });

        $recentActivities = Peminjaman::with(['user', 'buku'])->latest()->limit(10)->get();

        return view('petugas.dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'peminjamanAktif',
            'dendaBelumDibayar',
            'recentActivities'
        ));
    }

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

    // Fungsi buat nampilin daftar pengembalian (Halaman yang tadi Error 500)
    public function pengembalian()
    {
        $pengembalians = Peminjaman::with(['user', 'buku'])
            ->whereIn('status', ['WAITING', 'DIKEMBALIKAN', 'TERLAMBAT', 'DENDA'])
            ->latest('updated_at')
            ->get();

        return view('petugas.pengembalian', compact('pengembalians'));
    }

    // Fungsi konfirmasi pengembalian
    public function konfirmasiPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Ambil data yang sudah dihitung (walaupun minus di DB lu sekarang)
        $denda = $peminjaman->denda;
        $terlambat = $peminjaman->terlambat;
        $tglKembali = $peminjaman->tgl_kembali ?? date('Y-m-d');

        DB::beginTransaction();
        try {
            Pengembalian::updateOrCreate(
                ['peminjaman_id' => $id],
                [
                    'tanggal_kembali' => $tglKembali,
                    'terlambat' => $terlambat,
                    'denda' => $denda,
                    'status' => 1
                ]
            );

            $statusBaru = ($denda != 0) ? 'TERLAMBAT' : 'DIKEMBALIKAN';

            $peminjaman->update([
                'status' => $statusBaru,
                'denda' => $denda,
                'terlambat' => $terlambat
            ]);

            if ($peminjaman->buku) {
                $peminjaman->buku->increment('stok');
            }

            DB::commit();
            return redirect()->back()->with('success', 'Berhasil konfirmasi pengembalian!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function denda()
    {

        $peminjamans = Peminjaman::with(['user', 'buku'])
            ->where('denda', '!=', 0)
            ->latest()
            ->get();

        return view('petugas.denda', compact('peminjamans'));
    }

    public function konfirmasiLunas($id)
    {
        $item = Peminjaman::findOrFail($id);
        $item->update([
            'status' => 'DIKEMBALIKAN',
            'denda' => 0,
            'terlambat' => 0
        ]);
        return redirect()->back()->with('success', 'Pembayaran denda berhasil dikonfirmasi!');
    }

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
        $data = $request->all();

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan file
            $file->storeAs('cover', $filename, 'public');
            $data['cover'] = $filename;
        }

        // Simpan ke Database
        \App\Models\Buku::create($data);

        // PAKSA REDIRECT PAKAI URL ASLI, JANGAN PAKE ROUTE NAME
        return redirect()->route('petugas.buku')->with('success', 'Buku berhasil ditambah!');
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
            if ($buku->cover) {
                Storage::disk('public')->delete('cover/' . $buku->cover);
            }
            $filename = time() . '_' . $request->file('cover')->getClientOriginalName();
            $request->file('cover')->storeAs('cover', $filename, 'public');
            $data['cover'] = $filename;
        }
        $buku->update($data);
        return redirect()->route('petugas.buku')->with('success', 'Buku diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        if ($buku->cover) {
            Storage::disk('public')->delete('cover/' . $buku->cover);
        }
        $buku->delete();
        return redirect()->back()->with('success', 'Buku dihapus!');
    }
}