<?php

namespace App\Providers;

use App\Services\OfferStatistics;
use Illuminate\Support\ServiceProvider;

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
    }
}
