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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->unique();
            $table->date('tanggal_surat');
            $table->date('tanggal_diterima');
            $table->date('tanggal_kegiatan');
            $table->time('waktu_kegiatan');
            $table->string('instansi_pengirim');
            $table->string('tempat_kegiatan');
            $table->string('perihal');
            // $table->enum('tipe', ['internal', 'external']);
            $table->string('lampiran_path')->nullable(); // Untuk menyimpan path file
            $table->text('keterangan')->nullable();
          
            $table->timestamps();
            $table->boolean('notifikasi_terkirim')->default(false)->after();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');

    }
};
