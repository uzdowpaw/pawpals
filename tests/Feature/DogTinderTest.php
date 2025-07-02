<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Dog;
use App\Models\DogMatch;

class DogTinderTest extends TestCase
{

    public function test_user_can_like_a_dog()
    {
        // Create a user
        $user = User::factory()->create(['role' => 'user']);

        // Create another user with a dog
        $dogOwner = User::factory()->create(['role' => 'user']);
        $dog = Dog::factory()->create(['user_id' => $dogOwner->id]);

        // Act as the first user and like the dog
        $response = $this->actingAs($user)
            ->post(route('user.dog-tinder.swipe'), [
                'dog_id' => $dog->id,
                'action' => 'like'
            ]);

        // Assert response is successful
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Assert the dog match was created in the database
        $this->assertDatabaseHas('dog_matches', [
            'user_id' => $user->id,
            'dog_id' => $dog->id,
            'interaction_type' => 'like'
        ]);
    }

    public function test_user_can_dislike_a_dog()
    {
        // Create a user
        $user = User::factory()->create(['role' => 'user']);

        // Create another user with a dog
        $dogOwner = User::factory()->create(['role' => 'user']);
        $dog = Dog::factory()->create(['user_id' => $dogOwner->id]);

        // Act as the first user and dislike the dog
        $response = $this->actingAs($user)
            ->post(route('user.dog-tinder.swipe'), [
                'dog_id' => $dog->id,
                'action' => 'dislike'
            ]);

        // Assert response is successful
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        // Assert the dog match was created in the database
        $this->assertDatabaseHas('dog_matches', [
            'user_id' => $user->id,
            'dog_id' => $dog->id,
            'interaction_type' => 'dislike'
        ]);
    }

    public function test_mutual_match_is_detected()
    {
        // Create two users
        $user1 = User::factory()->create(['role' => 'user']);
        $user2 = User::factory()->create(['role' => 'user']);

        // Create a dog for each user
        $dog1 = Dog::factory()->create(['user_id' => $user1->id]);
        $dog2 = Dog::factory()->create(['user_id' => $user2->id]);

        // User 1 likes User 2's dog
        DogMatch::create([
            'user_id' => $user1->id,
            'dog_id' => $dog2->id,
            'interaction_type' => 'like'
        ]);

        // User 2 likes User 1's dog (this should trigger a match)
        $response = $this->actingAs($user2)
            ->post(route('user.dog-tinder.swipe'), [
                'dog_id' => $dog1->id,
                'action' => 'like'
            ]);

        // Assert response indicates a match
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_match' => true,
        ]);

        // Assert both matches exist in the database
        $this->assertDatabaseHas('dog_matches', [
            'user_id' => $user1->id,
            'dog_id' => $dog2->id,
            'interaction_type' => 'like'
        ]);

        $this->assertDatabaseHas('dog_matches', [
            'user_id' => $user2->id,
            'dog_id' => $dog1->id,
            'interaction_type' => 'like'
        ]);
    }
}