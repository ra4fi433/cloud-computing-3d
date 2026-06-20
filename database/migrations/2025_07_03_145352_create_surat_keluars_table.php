<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // Migration untuk membuat tabel surat_keluars
    // Tabel ini menyimpan data surat keluar yang dibuat oleh admin atau superadmin
    public function up(): void
    {
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->id();
            // isian form
            $table->unsignedInteger('nomor_urut')
                ->unique()
                ->after('id')
                ->comment('Nomor urut surat keluar, diisi otomatis')
                ->nullable()
                ->nullOnDelete();
            $table->string('nomor_surat')
                ->unique()
                ->after('nomor_urut')
                ->nullable()
                ->nullOnDelete();
            $table->date('tanggal_surat')->default(now())->after('nomor_surat');
            $table->foreignId('klasifikasi_surat_id')
                ->nullable()
                ->constrained('klasifikasi_surats')
                ->nullOnDelete();
            $table->string('sifat');
            $table->string('perihal');
            $table->string('kepada');
            $table->foreignId('bidang_id')
              ->nullable() // Bisa null jika tidak wajib diisi di awal
              ->constrained('bidangs') // Menghubungkan ke tabel 'bidangs'
              ->onDelete('set null'); // Jika bidang dihapus, set bidang_id di surat_keluar menjadi NULL

            // $table->string('disposisi')->nullable(); // pastikan tabel bidang sudah ada
            $table->text('keterangan')->nullable();
            $table->string('lampiran')->nullable(); // untuk file surat
            $table->longText('isi_surat')->nullable();
            // logic persetujuan
            $table->enum('status_persetujuan', ['draft', 'menunggu_kabid', 'disetujui_kabid', 'disetujui_superadmin'])->default('draft');
            $table->unsignedBigInteger('disetujui_kabid_id')->nullable();
            $table->timestamp('disetujui_kabid_at')->nullable();
            $table->unsignedBigInteger('disetujui_superadmin_id')->nullable();
            $table->timestamp('disetujui_superadmin_at')->nullable();
            // Status tanda tangan oleh Kadis
            $table->enum('kadis_ttd_status', ['belum_ditandatangani', 'elektronik', 'manual'])->default('belum_ditandatangani')->after('status_ttd');
            $table->unsignedBigInteger('kadis_ttd_id')->nullable()->after('kadis_ttd_status');
            $table->timestamp('kadis_ttd_at')->nullable()->after('kadis_ttd_id');

            // Path untuk menyimpan PDF final setelah ditandatangani elektronik
            $table->string('dokumen_final_path')->nullable()->after('kadis_ttd_at');
            

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
