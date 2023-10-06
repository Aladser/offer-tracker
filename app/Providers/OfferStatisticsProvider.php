<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\OfferStatistics;

class OfferStatisticsProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Connection::class, function ($app) {
            return new OfferStatistics();
        });
    }

    public function boot()
    {
        //
    }
}
