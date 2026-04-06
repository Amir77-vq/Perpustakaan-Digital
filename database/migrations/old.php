<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            // Menambahkan kolom cover setelah kolom penulis
            // Kita pakai nullable() supaya buku lama yang belum punya cover nggak error
            $table->string('cover')->nullable()->after('penulis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            // Menghapus kolom cover jika migration di-rollback
            $table->dropColumn('cover');
        });
    }
};

//

//<?php

//use Illuminate\Database\Migrations\Migration;
//use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            // Menambahkan kolom cover setelah kolom penulis
            // Kita pakai nullable() supaya buku lama yang belum punya cover nggak error
            $table->string('cover')->nullable()->after('penulis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            // Menghapus kolom cover jika migration di-rollback
            $table->dropColumn('cover');
        });
    }
};