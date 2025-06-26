<?php

namespace Database\Seeders;

use App\Models\Dog;
use Illuminate\Database\Seeder;

class DogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::where('role', 'user')->get();

        foreach ($users as $user) {
            Dog::factory(rand(1, 3))->create(['user_id' => $user->id]);
        }
    }
}