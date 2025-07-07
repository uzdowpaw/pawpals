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
        Schema::table('shelter_dogs', function (Blueprint $table) {
            $table->foreignId('dog_id')->nullable()->constrained('dogs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shelter_dogs', function (Blueprint $table) {
            $table->dropForeign(['dog_id']);
            $table->dropColumn('dog_id');
        });
    }
};
