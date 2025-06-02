<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DogMatch extends Model
{
    protected $fillable = [
        'user_id',
        'dog_id',
        'interaction_type'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dog(): BelongsTo
    {
        return $this->belongsTo(Dog::class);
    }

    public static function checkMutualMatch($userId1, $userId2)
    {
        // Check if user1 liked user2's dog and user2 liked user1's dog
        $user1Dogs = Dog::where('user_id', $userId1)->pluck('id');
        $user2Dogs = Dog::where('user_id', $userId2)->pluck('id');

        $user1LikedUser2Dog = self::where('user_id', $userId1)
            ->whereIn('dog_id', $user2Dogs)
            ->where('interaction_type', 'like')
            ->exists();

        $user2LikedUser1Dog = self::where('user_id', $userId2)
            ->whereIn('dog_id', $user1Dogs)
            ->where('interaction_type', 'like')
            ->exists();

        return $user1LikedUser2Dog && $user2LikedUser1Dog;
    }
}
