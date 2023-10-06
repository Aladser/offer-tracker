<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebmasterUnsigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
