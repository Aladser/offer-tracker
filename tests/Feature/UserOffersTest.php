<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\UserRole;
use App\Models\User;
use App\Models\OfferTheme;
use App\Models\Offer;
use App\Models\OfferSubscription;
use App\Http\Controllers\StatisticController;

class UserOffersTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUserOffers() {
        $this->seed();

        $advertiser_id = 2;
        $offers = User::find($advertiser_id)->offers; 

        // офферы за все время
        $totalOffers = 0;
        $totalMoney = 0;
        echo 'Офферы ' . User::find($advertiser_id)->name . "\n" . StatisticController::getDate() . ":\n";
        foreach ($offers->all() as $offer) {
            $count = $offer->linkCount();
            $money = $offer->money();
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: $count Доход: $money\n";
            $totalOffers += $count;
            $totalMoney += $money;
        }
        echo "Всего переходов: $totalOffers. Доход: $totalMoney\n\n";

        $totalOffers = 0;
        $totalMoney = 0;
        $lastDate = StatisticController::getDate('-1 day');
        echo "$lastDate:\n";
        foreach ($offers->all() as $offer) {
            $count = $offer->linkCount($lastDate);
            $money = $offer->money($lastDate);
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: $count Доход: $money\n";
            $totalOffers += $count;
            $totalMoney += $money;
        }
        echo "Всего переходов: $totalOffers. Доход: $totalMoney\n\n";

        $totalOffers = 0;
        $totalMoney = 0;
        $lastDate = StatisticController::getDate('-1 month');
        echo "$lastDate:\n";
        foreach ($offers->all() as $offer) {
            $count = $offer->linkCount($lastDate);
            $money = $offer->money($lastDate);
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: $count Доход: $money\n";
            $totalOffers += $count;
            $totalMoney += $money;
        }
        echo "Всего переходов: $totalOffers. Доход: $totalMoney\n\n";

        $totalOffers = 0;
        $totalMoney = 0;
        $lastDate = StatisticController::getDate('-1 year');
        echo "$lastDate:\n";
        foreach ($offers->all() as $offer) {
            $count = $offer->linkCount($lastDate);
            $money = $offer->money($lastDate);
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: $count Доход: $money\n";
            $totalOffers += $count;
            $totalMoney += $money;
        }
        echo "Всего переходов: $totalOffers. Доход: $totalMoney\n\n";

        $this->assertDatabaseCount('offer_subscriptions', 11);
    }
}
