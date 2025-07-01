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
        'shelter_id',
        'user_id',
        'name',
        'breed',
        'age',
        'size',
        'description',
        'status',
    ];

    /**
     * Get the user that owns the dog.
     */
    public function shelter()
    {
        return $this->belongsTo(User::class, 'shelter_id');
    }

    /**
     * Get the user that adopted the dog.
     */
    public function adopter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the photos for the dog.
     */
    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    /**
     * Get the pet care reminders for the dog.
     */
    public function petCareReminders()
    {
        return $this->hasMany(PetCareReminder::class);
    }

    /**
     * Get the pet care logs for the dog.
     */
    public function petCareLogs()
    {
        return $this->hasMany(PetCareLog::class);
    }

    public function mainPhoto()
    {
        return $this->morphOne(Photo::class, 'imageable')->where('is_main', true);
    }
}
