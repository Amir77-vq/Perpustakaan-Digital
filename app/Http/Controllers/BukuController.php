<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function dashboardIndex()
    {
        $statusBermasalah = Peminjaman::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('denda', '!=', 0)
                    ->orWhere(function ($q) {
                        $q->whereIn('status', ['DIPINJAM', 'DI SETUJUI'])
                            ->where('jatuh_tempo', '<', now()->toDateString());
                    });
            })->exists();

        $books = Buku::latest()->take(4)->get();
        return view('dashboard', compact('books', 'statusBermasalah'));
    }

    public function index(Request $request)
    {
        $search = $request->query('search');

        $statusBermasalah = Peminjaman::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('denda', '!=', 0)
                    ->orWhere(function ($q) {
                        $q->whereIn('status', ['DIPINJAM', 'DI SETUJUI'])
                            ->where('jatuh_tempo', '<', now()->toDateString());
                    });
            })->exists();

        if ($search) {
            $books = Buku::where('judul', 'like', '%' . $search . '%')
                ->orWhere('penulis', 'like', '%' . $search . '%')
                ->get();
        } else {
            $books = Buku::all();
        }

        return view('anggota.buku', compact('books', 'statusBermasalah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['judul', 'penulis', 'stok']);

        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->storeAs('cover', $filename, 'public');
            $data['cover'] = $filename;
        }

        Buku::create($data);

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(Request $request, $id)
    {
        $book = Buku::findOrFail($id);
        $dari = $request->query('from', 'buku');

        $statusBermasalah = Peminjaman::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('denda', '!=', 0)
                    ->orWhere(function ($q) {
                        $q->whereIn('status', ['DIPINJAM', 'DI SETUJUI'])
                            ->where('jatuh_tempo', '<', now()->toDateString());
                    });
            })->exists();

        return view('anggota.detail-buku', compact('book', 'dari', 'statusBermasalah'));
    }

    public function ajukan(Request $request, $id)
    {
        $statusBermasalah = Peminjaman::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('denda', '!=', 0)
                    ->orWhere(function ($q) {
                        $q->whereIn('status', ['DIPINJAM', 'DI SETUJUI'])
                            ->where('jatuh_tempo', '<', now()->toDateString());
                    });
            })->exists();

        if ($statusBermasalah) {
            return redirect()->back()->with('error', 'Peminjaman ditolak! Selesaikan denda atau kembalikan buku yang sudah jatuh tempo.');
        }

        $book = Buku::findOrFail($id);
        $dari = $request->query('from', 'buku');

        return view('anggota.ajukan-peminjaman', compact('book', 'dari'));
    }

    public function destroy($id)
    {
        $book = Buku::findOrFail($id);

        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus!');
    }
}