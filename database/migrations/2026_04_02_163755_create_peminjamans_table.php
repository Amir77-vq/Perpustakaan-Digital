<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('buku_id')->nullable();
            $table->string('judul_buku');
            $table->date('tgl_pinjam');
            $table->date('jatuh_tempo');
            
            $table->string('status')->default('PENDING'); 
            
            $table->integer('denda')->default(0); 

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('buku_id')->references('id')->on('bukus')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};