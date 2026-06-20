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
        Schema::create('document_bidang', function (Blueprint $table) {
            $table->foreignId('document_id')->constrained('documents')->onDelete('cascade');
            $table->foreignId('bidang_id')->constrained('bidangs')->onDelete('cascade');
            // Membuat primary key gabungan untuk memastikan tidak ada duplikasi
            $table->primary(['document_id', 'bidang_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_bidang');
    }
};
