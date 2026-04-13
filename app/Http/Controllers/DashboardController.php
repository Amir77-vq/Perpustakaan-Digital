<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        // JIKA YANG LOGIN KEPALA
        if ($role == 'kepala') {
            $totalBuku = Buku::count();
            $totalAnggota = User::where('role', 'user')->count();
            $peminjamanAktif = Peminjaman::where('status', 'DIPINJAM')->count();
            
            // Perbaikan: Definisi variabel denda supaya tidak error di compact
            $dendaBelumDibayar = Peminjaman::where('status', 'WAITING')->sum('denda');
            $totalDenda = Peminjaman::where('status', 'KEMBALI')->sum('denda');
            
            $recentActivities = Peminjaman::with(['user', 'buku'])
                                ->latest('updated_at')
                                ->take(5)
                                ->get();

            return view('kepala.dashboard', compact(
                'totalBuku', 
                'totalAnggota', 
                'peminjamanAktif', 
                'dendaBelumDibayar', // Sekarang variabel ini sudah ada
                'recentActivities'
            ));
        }

        // JIKA LOGIN SEBAGAI USER/PETUGAS
        $books = Buku::latest()->take(8)->get();
        
        // Ambil riwayat pinjam
        $recentLoans = Peminjaman::with('buku')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->take(5)
                        ->get();

        return view('dashboard', compact('books', 'recentLoans'));
    }
}