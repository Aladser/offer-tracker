<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\OfferService;

class OfferServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Connection::class, function ($app) {
            return new OfferService();
        });
    }

    public function boot()
    {
        //
    }
}
