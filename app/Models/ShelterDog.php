<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShelterDog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'sex',
        'breed_id',
        'description',
        'main_photo_path',
        'shelter_id',
        'status',
        'dog_id',
    ];

    public function shelter()
    {
        return $this->belongsTo(User::class, 'shelter_id');
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    public function dog()
    {
        return $this->belongsTo(Dog::class);
    }
}
