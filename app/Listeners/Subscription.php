<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\WebmasterSigned;
use Illuminate\Support\Facades\Log;

class Subscription
{
    private $logChannel;

    public function __construct()
    {
        $this->logChannel = Log::build(['driver' => 'single','path' => storage_path('logs/offer_click.log'),]);
    }

    public function handle(WebmasterSigned $webmasterSigned)
    {
        $info = "Вебмастер {$webmasterSigned->subscription->follower->user->name} подписалcя на {$webmasterSigned->subscription->offer->name} (id={$webmasterSigned->subscription->id})";
        Log::stack(['slack', $this->logChannel])->info($info);
        return $info;
    }
}
