<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dog_id',
        'shelter_id',
        'status',
        'message',
        'dog_type',  // Added to distinguish between Dog and ShelterDog
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dog()
    {
        // If dog_type is set to 'shelter_dog', return ShelterDog model
        if ($this->dog_type === 'shelter_dog') {
            return $this->belongsTo(ShelterDog::class, 'dog_id');
        }
        
        // Default to Dog model
        return $this->belongsTo(Dog::class);
    }

    public function shelter()
    {
        return $this->belongsTo(User::class, 'shelter_id');
    }
}
