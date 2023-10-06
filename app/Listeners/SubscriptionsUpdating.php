<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\WebmasterSigned;

class SubscriptionsUpdating
{
    public function __construct()
    {
        //
    }

    /** Обработать событие.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(WebmasterSigned $webmasterSigned)
    {
        dd($webmasterSigned);
    }
}
