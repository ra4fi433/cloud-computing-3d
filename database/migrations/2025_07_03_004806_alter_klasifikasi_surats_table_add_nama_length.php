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
        Schema::table('klasifikasi_surats', function (Blueprint $table) {
            // Mengubah tipe kolom 'nama' menjadi lebih panjang (misal: 1000 karakter)
            $table->string('nama', 1000)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('klasifikasi_surats', function (Blueprint $table) {
            // Mengembalikan tipe kolom 'nama' ke 255 karakter jika rollback
            $table->string('nama', 255)->change();
        });
    }
};
