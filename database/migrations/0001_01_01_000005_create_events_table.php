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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name');
            $table->text('description')->nullable();
            $table->dateTime('event_date');
            $table->string('location');
            $table->string('speaker')->nullable();
            $table->string('poster_url')->nullable(); // URL to the event poster image
            $table->decimal('registration_fee', 10, 2)->default(0.00);
            $table->unsignedInteger('max_participants')->nullable();

            // Foreign key for the user (panitia) who created the event
            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            // onDelete('restrict') prevents deleting a user if they have created events.
            // You might want 'set null' or another strategy depending on requirements.

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
