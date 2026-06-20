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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // $table->string('name');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
             $table->foreignId('bidang_id')
                  ->nullable() // Gunakan nullable() jika user seperti Superadmin tidak perlu bidang tertentu
                  ->constrained('bidangs')
                  ->onDelete('set null'); // Jika bidang dihapus, set bidang_id di user menjadi NULL

            $table->unsignedBigInteger('role_id')->nullable(); // ✅ Kolom role_id
            $table->rememberToken();
            $table->softDeletes(); // Add soft deletes column 'deleted_at'
            $table->timestamps();

        // ✅ Foreign key setelah kolom dibuat
        $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            // $table->string('disposisi')->nullable(); // Bidang atau disposisi
            // $table->softDeletes(); // Untuk soft delete
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            // $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('bidang_id');
        });
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropSoftDeletes();
        });
    //     Schema::table('users', function (Blueprint $table) {
    //     $table->dropForeign(['role_id']);
    //     $table->dropColumn('role_id');
    // });
    }
};
