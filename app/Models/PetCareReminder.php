<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PetCareReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dog_id',
        'title',
        'description',
        'type',
        'reminder_date',
        'frequency',
        'is_completed',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'reminder_date' => 'datetime',
        'completed_at' => 'datetime',
        'is_completed' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dog(): BelongsTo
    {
        return $this->belongsTo(Dog::class);
    }

    public function careLogs(): HasMany
    {
        return $this->hasMany(PetCareLog::class, 'reminder_id');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('reminder_date', '>=', now())
                    ->where('is_completed', false)
                    ->orderBy('reminder_date', 'asc');
    }

    public function scopeOverdue($query)
    {
        return $query->where('reminder_date', '<', now())
                    ->where('is_completed', false)
                    ->orderBy('reminder_date', 'asc');
    }

    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true)
                    ->orderBy('completed_at', 'desc');
    }

    public function markAsCompleted($notes = null)
    {
        $this->update([
            'is_completed' => true,
            'completed_at' => now(),
            'notes' => $notes,
        ]);
    }

    public function isOverdue(): bool
    {
        return !$this->is_completed && $this->reminder_date < now();
    }
}