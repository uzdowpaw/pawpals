<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dog_id',
        'path',
        'is_main',
    ];

    /**
     * Get the dog that owns the photo.
     */
    public function dog()
    {
        return $this->belongsTo(Dog::class);
    }
}