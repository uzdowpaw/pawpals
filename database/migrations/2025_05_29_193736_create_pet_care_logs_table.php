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
        Schema::create('pet_care_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('dog_id')->constrained()->onDelete('cascade');
            $table->foreignId('reminder_id')->nullable()->constrained('pet_care_reminders')->onDelete('set null');
            $table->string('activity_type');
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('performed_at');
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // For storing additional data like weight, temperature, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_care_logs');
    }
};