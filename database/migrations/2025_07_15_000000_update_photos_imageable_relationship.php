<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // This migration fixes the issue with photos that were created before the polymorphic relationship
        // was introduced. It updates the imageable_id and imageable_type columns for existing photos.
        
        // Since we've already run the migration that drops the dog_id column,
        // we need to fix the photos that don't have an imageable_type set
        // This is a common issue when migrating from a direct relationship to a polymorphic one
        
        // Get all shelter dogs
        $shelterDogs = DB::table('shelter_dogs')->get();
        
        foreach ($shelterDogs as $dog) {
            // For each dog, find photos that might be related to it
            // We'll use the main_photo_path to match photos
            if ($dog->main_photo_path) {
                // Find photos with matching path
                $photos = DB::table('photos')
                    ->where('path', $dog->main_photo_path)
                    ->whereNull('imageable_type')
                    ->get();
                
                foreach ($photos as $photo) {
                    // Update the photo to use the ShelterDog model as the imageable type
                    DB::table('photos')
                        ->where('id', $photo->id)
                        ->update([
                            'imageable_type' => 'App\\Models\\ShelterDog',
                            'imageable_id' => $dog->id,
                        ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not reversible as we don't know which photos were updated
    }
};