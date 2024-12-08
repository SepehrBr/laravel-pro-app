<?php

namespace App\Notifications;

use App\Notifications\Channels\Ghasedak;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActiveCodeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $code, public $phoneNumber)
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [
            Ghasedak::class
        ];
    }

    public function ghasedakSms($notifiable)
    {
        return [
            'message' => "code: {$this->code}",
            'phone' => $this->phoneNumber
        ];
    }
}
