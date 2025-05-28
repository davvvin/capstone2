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
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Member registering
            $table->foreignId('event_id')->constrained()->onDelete('cascade'); // Event being registered for

            $table->string('registration_code')->unique()->nullable(); // Unique code for QR, generated after payment
            $table->string('qr_code_url')->nullable(); // URL or path to the generated QR code image

            $table->enum('payment_status', ['pending', 'awaiting_verification', 'verified', 'rejected'])
                  ->default('pending');
            $table->string('proof_of_payment_url')->nullable(); // URL/path to uploaded payment proof
            $table->foreignId('payment_verified_by')->nullable()->constrained('users')->onDelete('set null'); // Tim Keuangan
            $table->timestamp('payment_verified_at')->nullable();
            $table->text('payment_rejection_reason')->nullable();

            $table->boolean('is_attended')->default(false);
            $table->timestamp('scanned_at')->nullable();
            $table->foreignId('scanned_by')->nullable()->constrained('users')->onDelete('set null'); // Panitia who scanned

            $table->timestamps();

            // A user can only register for a specific event once
            $table->unique(['user_id', 'event_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
