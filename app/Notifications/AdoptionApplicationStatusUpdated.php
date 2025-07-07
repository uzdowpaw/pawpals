<?php

namespace App\Notifications;

use App\Models\AdoptionApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdoptionApplicationStatusUpdated extends Notification
{
    use Queueable;

    protected $application;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(AdoptionApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $dogName = $this->application->shelterDog && $this->application->shelterDog->dog ? $this->application->shelterDog->dog->name : 'Unknown Dog';
        
        $message = 'Your adoption application for ' . $dogName . ' has been ' . $this->application->status . '.';
        
        // Add chat information if application is approved
        if ($this->application->status === 'approved') {
            $message .= ' You can now chat with the shelter in the chat section!';
        }
        
        return [
            'application_id' => $this->application->id,
            'dog_name' => $dogName,
            'status' => $this->application->status,
            'message' => $message,
        ];
    }
}