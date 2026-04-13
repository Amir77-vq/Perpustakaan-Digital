<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';
    protected $primaryKey = 'pengembalian_id';

    protected $fillable = [
        'peminjaman_id', 
        'tanggal_kembali', 
        'terlambat', 
        'denda', 
        'status'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id', 'id');
    }

    public function user()
{
    return $this->peminjaman->user ?? null;
}

public function buku()
{
    return $this->peminjaman->buku ?? null;
}
}