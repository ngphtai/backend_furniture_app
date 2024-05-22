<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;
use Illuminate\Support\Facades\Log;

class MessageSent extends Notification
{

    private array $data;
    use Queueable;
    /**
     * Create a new notification instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return [OneSignalChannel::class];
    }

    public function toOneSignal()
    {
        $messageData = $this->data['messageData'];
        Log::debug("from Notification: " . $messageData['message']);

        return OneSignalMessage::create()
            ->setSubject("Supporter send you a messenger")
            ->setBody($messageData['message'])
            ->setData('data', $messageData);
    }
}
