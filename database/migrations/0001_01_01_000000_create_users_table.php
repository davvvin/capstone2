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
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->boolean('is_active')->default(true); // Kolom tambahan kita
                $table->rememberToken();
                $table->timestamps();
            });
        } else {
            // Jika tabel users sudah ada, periksa apakah kolom 'is_active' sudah ada
            if (!Schema::hasColumn('users', 'is_active')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->boolean('is_active')->default(true)->after('password'); // Tambahkan kolom is_active
                });
            }
            // Anda bisa menambahkan pemeriksaan kolom lain di sini jika diperlukan
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Logika untuk down() bisa lebih kompleks jika Anda hanya ingin meng-drop kolom 'is_active'
        // Namun, untuk kasus umum, jika migrasi ini di-rollback, tabel users akan di-drop.
        // Jika Anda ingin lebih hati-hati, Anda bisa mengomentari Schema::dropIfExists('users');
        // dan hanya meng-drop kolom yang ditambahkan jika itu adalah modifikasi.
        // Untuk Breeze, biasanya drop tabelnya.
        Schema::dropIfExists('users');
    }
};