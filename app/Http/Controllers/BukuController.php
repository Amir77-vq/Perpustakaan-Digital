<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Tampilan Dashboard: Hanya ambil 4 buku terbaru agar layout tetap rapi.
     */
    public function dashboardIndex()
    {
        $books = Buku::latest()->take(4)->get();
        return view('dashboard', compact('books'));
    }

    /**
     * Halaman Daftar Buku (Anggota): Tampil semua buku + Fitur Search.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        if ($search) {
            $books = Buku::where('judul', 'like', '%' . $search . '%')
                        ->orWhere('penulis', 'like', '%' . $search . '%')
                        ->get();
        } else {
            $books = Buku::all(); 
        }

        return view('anggota.buku', compact('books')); 
    }

    /**
     * Method untuk Simpan Buku Baru (Petugas)
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'   => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'stok'    => 'required|integer',
            'cover'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        // Proses upload cover jika ada file yang diunggah
        if ($request->hasFile('cover')) {
            // File masuk ke: storage/app/public/cover
            $path = $request->file('cover')->store('cover', 'public');
            $data['cover'] = $path; 
        }

        Buku::create($data);

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Halaman Detail Buku
     */
    public function show(Request $request, $id)
    {
        $book = Buku::findOrFail($id);
        $dari = $request->query('from', 'buku'); 
        return view('anggota.detail-buku', compact('book', 'dari'));
    }

    /**
     * Halaman Pengajuan Peminjaman
     */
    public function ajukan(Request $request, $id)
    {
        $book = Buku::findOrFail($id);
        $dari = $request->query('from', 'buku');
        return view('anggota.ajukan-peminjaman', compact('book', 'dari'));
    }

    /**
     * Method untuk Hapus Buku (Jika dibutuhkan di panel petugas)
     */
    public function destroy($id)
    {
        $book = Buku::findOrFail($id);
        
        // Hapus file cover dari storage jika ada sebelum data di DB dihapus
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus!');
    }
}