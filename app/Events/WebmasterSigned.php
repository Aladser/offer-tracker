<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\OfferSubscription;

/** событие подписки вебмастера */
class WebmasterSigned implements ShouldBroadcast
{
    public OfferSubscription $subscription;

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(OfferSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function broadcastOn()
    {
        return new PrivateChannel($this->subscription->offer->advertiser->id);
    }
}
