<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ShelterDog as Dog;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShelterDogPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Dog $dog)
    {
        return $user->id === $dog->shelter_id;
    }

    public function delete(User $user, Dog $dog)
    {
        return $user->id === $dog->shelter_id;
    }
}