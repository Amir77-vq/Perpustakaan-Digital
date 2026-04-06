<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Nama tabel: pengembalians
        Schema::create('pengembalians', function (Blueprint $table) {
            // Primary Key: pengembalian_id (AI)
            $table->id('pengembalian_id'); 
            
            // Relasi ke tabel peminjamans
            $table->unsignedBigInteger('peminjaman_id');
            
            $table->date('tanggal_kembali');
            $table->integer('terlambat'); 
            $table->integer('denda');     
            
            // Status (INT): 0 = Pending, 1 = Dikembalikan
            $table->integer('status')->default(0); 
            
            $table->timestamps();

            // Definisi Foreign Key agar nyambung ke tabel peminjamans
            $table->foreign('peminjaman_id')
                ->references('id')
                ->on('peminjamans')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};