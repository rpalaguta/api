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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Reference to 'time_slots.id' for time_slot_id
            $table->foreignId('time_slot_id')
                ->constrained()  // Assumes the time_slots table and references the 'id' column
                ->onDelete('cascade');  // If the time slot is deleted, delete the associated appointments

            // Reference to 'users.id' for client_id (nullable)
            $table->foreignId('client_id')
                ->constrained('users', 'id')  // References the 'users.id' column
                ->onDelete('cascade');  // If a user is deleted, delete the associated appointments

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
