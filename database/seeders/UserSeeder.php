<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin users
        User::factory()->create([
            'name' => 'Admin User 1',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Admin User 2',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Admin User 3',
            'email' => 'admin3@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create regular users
        User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
        User::factory()->create([
            'name' => 'User 2',
            'email' => 'user2@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
        User::factory()->create([
            'name' => 'User 3',
            'email' => 'user3@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create shelter users
        User::factory()->create([
            'name' => 'Shelter User 1',
            'email' => 'shelter1@example.com',
            'password' => Hash::make('password'),
            'role' => 'shelter',
        ]);
        User::factory()->create([
            'name' => 'Shelter User 2',
            'email' => 'shelter2@example.com',
            'password' => Hash::make('password'),
            'role' => 'shelter',
        ]);
        User::factory()->create([
            'name' => 'Shelter User 3',
            'email' => 'shelter3@example.com',
            'password' => Hash::make('password'),
            'role' => 'shelter',
        ]);
    }
}