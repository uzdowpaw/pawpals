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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dog()
    {
        return $this->belongsTo(Dog::class);
    }

    public function shelter()
    {
        return $this->belongsTo(User::class, 'shelter_id');
    }
}
