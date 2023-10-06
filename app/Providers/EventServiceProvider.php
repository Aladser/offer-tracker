<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\WebmasterSigned;
use App\Events\WebmasterUnsigned;
use App\Listeners\Subscription;
use App\Listeners\Unsubscription;

class EventServiceProvider extends ServiceProvider
{
    /** Сопоставления прослушивателей событий для приложения.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        WebmasterSigned::class => [
            Subscription::class,
        ],
        WebmasterUnsigned::class => [
            Unsubscription::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
