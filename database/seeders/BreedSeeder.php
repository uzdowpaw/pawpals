<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $breedsPath = base_path('examples/breeds');
        if (File::exists($breedsPath)) {
            $breeds = File::lines($breedsPath)->map(function ($line) {
                // Remove leading/trailing whitespace and any potential list markers like '- '
                $cleanedLine = trim(str_replace(['-', '\t'], '', $line));
                return $cleanedLine;
            })->filter(function ($line) {
                return !empty($line);
            })->unique()->sort()->values();

            foreach ($breeds as $breedName) {
                DB::table('breeds')->insertOrIgnore([
                    'name' => $breedName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
