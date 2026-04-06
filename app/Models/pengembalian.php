<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalians';
    
    // Kasih tau Laravel kalau PK-nya beda
    protected $primaryKey = 'pengembalian_id';

    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali',
        'terlambat',
        'denda',
        'status',
    ];

    // Relasi ke Peminjaman (Penting buat ambil Nama User & Judul Buku di Blade)
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'id');
    }
}