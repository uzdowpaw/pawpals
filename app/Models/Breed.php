<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'size',
        'temperament',
        'life_expectancy',
        'origin',
    ];

    /**
     * Get the dogs for the breed.
     */
    public function dogs()
    {
        return $this->hasMany(Dog::class);
    }
}