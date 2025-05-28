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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id(); // Primary Key
            // Foreign key to the specific event registration this certificate is for
            $table->foreignId('event_registration_id')->constrained()->onDelete('cascade');

            $table->string('certificate_url'); // Placeholder URL as requested
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('restrict'); // Panitia who uploaded
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
