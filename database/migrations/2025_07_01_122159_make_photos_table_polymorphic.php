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
        Schema::table('photos', function (Blueprint $table) {
            $table->morphs('imageable');

            $table->dropForeign(['dog_id']);
            $table->dropColumn('dog_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropMorphs('imageable');
            $table->boolean('is_main')->default(false);
            $table->foreignId('dog_id')->constrained()->onDelete('cascade');
        });
    }
};
