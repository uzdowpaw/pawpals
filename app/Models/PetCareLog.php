<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetCareLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dog_id',
        'reminder_id',
        'activity_type',
        'title',
        'description',
        'performed_at',
        'notes',
        'metadata',
    ];

    protected $casts = [
        'performed_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dog(): BelongsTo
    {
        return $this->belongsTo(Dog::class);
    }

    public function reminder(): BelongsTo
    {
        return $this->belongsTo(PetCareReminder::class, 'reminder_id');
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('performed_at', '>=', now()->subDays($days))
                    ->orderBy('performed_at', 'desc');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('activity_type', $type);
    }
}