<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $bukus = Buku::all();
        return view('anggota.dashboard', compact('bukus'));
    }

    public function peminjaman()
    {
        $peminjamans = Peminjaman::where('user_id', auth()->id())
            ->whereIn('status', ['PENDING', 'DIPINJAM', 'WAITING'])
            ->latest()
            ->get();

        return view('anggota.peminjaman', compact('peminjamans'));
    }
}

