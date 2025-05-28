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
        Schema::create('role_user', function (Blueprint $table) {
            $table->id(); // Primary key for the pivot table itself
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // foreignId('user_id') creates an unsignedBigInteger column
            // constrained() automatically sets it as a foreign key referencing the 'id' column on the 'users' table
            // onDelete('cascade') means if a user is deleted, their role assignments are also deleted

            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            // Similar for role_id referencing the 'roles' table

            $table->timestamps(); // Optional: if you want to track when a role was assigned

            // To ensure a user cannot have the same role multiple times
            $table->unique(['user_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};
