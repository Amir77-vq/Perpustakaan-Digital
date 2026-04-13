<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function dashboardIndex()
    {
        $books = Buku::latest()->take(4)->get();
        return view('dashboard', compact('books'));
    }

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
        return view('anggota.detail-buku', compact('book', 'dari'));
    }

    public function ajukan(Request $request, $id)
    {
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