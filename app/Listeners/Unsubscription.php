<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\WebmasterUnsigned;
use Illuminate\Support\Facades\Log;

/** прослушивает отписки вебмастеров */
class Unsubscription
{
    private $logChannel;

    public function __construct()
    {
        $this->logChannel = Log::build(['driver' => 'single','path' => storage_path('logs/offer_click.log'),]);
    }

    public function handle(WebmasterUnsigned $webmasterUnsigned)
    {
        $info = "Отменена подписка вебмастера {$webmasterUnsigned->webmaster->user->name} на {$webmasterUnsigned->offer->name}(id={$webmasterUnsigned->subscriptionId})";
        Log::stack(['slack', $this->logChannel])->info($info);
        return $info;
    }
}
