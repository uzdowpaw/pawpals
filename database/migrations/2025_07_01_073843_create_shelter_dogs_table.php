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
        Schema::create('shelter_dogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->string('sex');
            $table->foreignId('breed_id')->constrained('breeds');
            $table->text('description');
            $table->foreignId('shelter_id')->constrained('users');
            $table->string('status')->default('available'); // e.g., available, adopted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelter_dogs');
    }
};
