<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman; // 1. Pastikan model Peminjaman dipanggil di sini
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil 8 buku untuk bagian rekomendasi
        $books = Buku::take(8)->get();

        // 2. Ambil data peminjaman terakhir (limit 5 data terbaru)
        // Pastikan di Model Peminjaman sudah ada relasi ke Buku
        $recentLoans = Peminjaman::with('buku')->latest()->take(5)->get();

        // 3. Kirim kedua variabel ($books dan $recentLoans) ke view
        return view('dashboard', compact('books', 'recentLoans'));
    }
}