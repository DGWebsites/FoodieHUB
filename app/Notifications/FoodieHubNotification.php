<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class FoodieHubNotification extends Notification
{
    public function __construct(
        public string $title,
        public string $message,
        public string $notificationType = 'order',
        public ?string $url = null
    ) {
    }


    /*
    |--------------------------------------------------------------------------
    | Notification Channels
    |--------------------------------------------------------------------------
    */

    public function via(object $notifiable): array
    {
        return [
            'database',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Database Notification
    |--------------------------------------------------------------------------
    */

    public function toDatabase(
        object $notifiable
    ): array {
        return [
            'title' => $this->title,

            'message' => $this->message,

            'type' => $this->notificationType,

            'url' => $this->url,

            'created_at' => now()->toDateTimeString(),
        ];
    }
}