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
        Schema::create('klasifikasi_surats', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // contoh: 200.12.2.3
            $table->string('nama');           // contoh: tugas3-bidang1
            // $table->string('nama', 1000)->change();
            $table->foreignId('parent_id')->nullable()->constrained('klasifikasi_surats')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klasifikasi_surats');
        // Schema::table('klasifikasi_surats', function (Blueprint $table) {
        //     // Mengembalikan tipe kolom 'nama' ke 255 karakter jika rollback
        //     $table->string('nama', 255)->change();
        // });
    }
};
