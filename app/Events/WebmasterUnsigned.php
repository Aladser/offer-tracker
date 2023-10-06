<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Webmaster;
use App\Models\Offer;


class WebmasterUnsigned implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $subscriptionId;
    public Webmaster $webmaster;
    public Offer $offer;

    public function __construct(int $id, Webmaster $webmaster, Offer $offer)
    {
        $this->subscriptionId = $id;
        $this->webmaster = $webmaster;
        $this->offer = $offer;
    }

    public function broadcastOn()
    {
        return new PrivateChannel($this->offer->advertiser->id);
    }
}
