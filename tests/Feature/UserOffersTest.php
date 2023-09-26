<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Http\Controllers\StatisticController;

class UserOffersTest extends TestCase
{
    use RefreshDatabase;

    private function getUserOffers($advertiser, $lastDate = null)
    {
        echo is_null($lastDate) ? StatisticController::getDate()."\n" : "$lastDate:\n";
        foreach ($advertiser->offers->all() as $offer) {
            $count = $offer->linkCount($lastDate);
            $money = $offer->money($lastDate);
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: $count Доход: $money\n";
        }
        echo "Всего переходов: {$advertiser->offerSubscriptionCount($lastDate)}. Доход: {$advertiser->offerIncome($lastDate)}\n\n";
    }

    public function testGetUserOffers() {
        if (User::count() === 0) {
            $this->seed();
        }

        $advertiser = User::find(2)->advertiser; 
        $this::getUserOffers($advertiser);
        $this::getUserOffers($advertiser, StatisticController::getDate('-1 day'));
        $this::getUserOffers($advertiser, StatisticController::getDate('-1 month'));
        $this::getUserOffers($advertiser, StatisticController::getDate('-1 year'));

        $this->assertDatabaseCount('offer_subscriptions', 11);
    }
}
