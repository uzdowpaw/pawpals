<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MatchNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $matchedUser;
    protected $dog;

    public function __construct($matchedUser, $dog)
    {
        $this->matchedUser = $matchedUser;
        $this->dog = $dog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "It's a match! 💕 You and {$this->matchedUser->name} liked each other's dogs!",
            'matched_user_id' => $this->matchedUser->id,
            'matched_user_name' => $this->matchedUser->name,
            'dog_id' => $this->dog->id,
            'dog_name' => $this->dog->name
        ];
    }
}
