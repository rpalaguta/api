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
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();

            // Reference to 'users.id' for psychologist
            $table->foreignId('psychologist_id')
                ->constrained('users', 'id')  // Explicitly specify the referenced table and column
                ->onDelete('cascade');  // Deletes the time slots when the psychologist is deleted

            $table->timestamp('start_time');
            $table->timestamp('end_time');

            // Reference to 'users.id' for client (nullable)
            $table->foreignId('client_id')
                ->nullable()  // Allows null client_id
                ->constrained('users', 'id')  // Explicitly specify the referenced table and column
                ->onDelete('set null');  // If client is deleted, set client_id to null

            $table->timestamps();

            // Add a unique constraint for the combination of psychologist_id, start_time, and end_time
            $table->unique(['psychologist_id', 'start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
