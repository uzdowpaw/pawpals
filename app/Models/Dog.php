<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'breed',
        'age',
        'size',
        'behavior_description',
    ];

    /**
     * Get the user that owns the dog.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the photos for the dog.
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
