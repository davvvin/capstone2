<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            // Kolom ini akan menyimpan tipe sertifikat ('url' atau 'file')
            $table->enum('certificate_type', ['url', 'file'])->default('url')->after('certificate_url');
        });
    }

    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn('certificate_type');
        });
    }
};
