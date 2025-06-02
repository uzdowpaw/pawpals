<?php

namespace Database\Factories;

use App\Models\Dog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
class DogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $this->faker->randomElement(['Buddy', 'Max', 'Charlie', 'Bella', 'Lucy', 'Daisy', 'Molly', 'Bailey', 'Maggie', 'Sophie']),
            'breed' => $this->faker->randomElement(['Labrador Retriever', 'German Shepherd', 'Golden Retriever', 'French Bulldog', 'Bulldog', 'Poodle', 'Beagle', 'Rottweiler', 'Siberian Husky', 'Dachshund']),
            'age' => $this->faker->numberBetween(1, 15),
            'size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'behavior_description' => $this->faker->sentence(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Dog $dog) {
            $numPhotos = $this->faker->numberBetween(1, 3);
            for ($i = 0; $i < $numPhotos; $i++) {
                // Generate a placeholder image and store it
                $filename = 'img/pjeski/default.jpg';

                $isMain = ($i === 0); // Set the first photo as main

                $dog->photos()->create([
                    'path' => $filename,
                    'is_main' => $isMain,
                ]);
            }
        });
    }
}