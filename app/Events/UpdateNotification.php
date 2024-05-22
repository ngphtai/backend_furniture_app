<?php

namespace App\Events;

use App\Models\Notifications;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(private Notifications $notification)
    {
        //
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('update-notification'.$this->notification['user_id']),
        ];
    }
    public function broadcastAs()// Broadcast event name
    {
        return 'notification.updated';
    }
    public function broadcastWith() : array // Data to broadcast
    {
        return [
            'uid' => $this->notification['user_id'],
            'id' => $this->notification['id'],
            'message' => $this->notification->toArray()  ,
        ];
    }

}
