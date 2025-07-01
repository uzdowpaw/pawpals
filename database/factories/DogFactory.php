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
            'shelter_id' => \App\Models\User::factory()->create(['role' => 'shelter'])->id,
            'name' => $this->faker->randomElement(['Buddy', 'Max', 'Charlie', 'Bella', 'Lucy', 'Daisy', 'Molly', 'Bailey', 'Maggie', 'Sophie']),
            'breed' => $this->faker->randomElement(['Labrador Retriever', 'German Shepherd', 'Golden Retriever', 'French Bulldog', 'Bulldog', 'Poodle', 'Beagle', 'Rottweiler', 'Siberian Husky', 'Dachshund']),
            'age' => $this->faker->numberBetween(1, 15),
            'size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'description' => $this->faker->sentence(),

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
                // Ensure the photos directory exists in storage
                if (!Storage::disk('public')->exists('photos')) {
                    Storage::disk('public')->makeDirectory('photos');
                }

                // Copy the default image to the storage/app/public/photos directory if it doesn't exist
                $defaultImageName = 'default_factory_dog.jpg';
                $storagePath = 'photos/' . $defaultImageName;
                if (!Storage::disk('public')->exists($storagePath)) {
                    // Assuming default.jpg is in public/img/pjeski/
                    $sourcePath = public_path('img/pjeski/default.jpg');
                    if (file_exists($sourcePath)) {
                        Storage::disk('public')->put($storagePath, file_get_contents($sourcePath));
                    }
                }

                $isMain = ($i === 0); // Set the first photo as main

                $dog->photos()->create([
                    'path' => $storagePath, // Store the path relative to storage/app/public
                    'is_main' => $isMain,
                ]);
            }
        });
    }
}
