<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TruncateAllTables::class);

        // User::factory(10)->create();

        $this->call(UserSeeder::class);
        $this->call(DogSeeder::class);
        $this->call(BreedSeeder::class);
    }
}
