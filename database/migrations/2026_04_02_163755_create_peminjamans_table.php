<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id(); 
            $table->string('judul_buku');
            $table->date('tgl_pinjam');
            $table->date('jatuh_tempo');
            
            $table->enum('status', ['MENUNGGU', 'DI SETUJUI', 'DI TOLAK'])->default('MENUNGGU');

            $table->unsignedBigInteger('buku_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};