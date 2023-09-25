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

        $user = User::find(2);
        $offers = $user->offers; 

        // офферы за все время
        echo 'Офферы ' . $user->name . "\n" . StatisticController::getDate() . ":\n";
        foreach ($offers->all() as $offer) {
            $count = $offer->linkCount();
            $money = $offer->money();
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: $count Доход: $money\n";
        }
        echo "Всего переходов: {$user->offerSubscriptionCount()}. Доход: {$user->offerIncome()}\n\n";

        // последний день
        $lastDate = StatisticController::getDate('-1 day');
        echo "$lastDate:\n";
        foreach ($offers->all() as $offer) {
            $count = $offer->linkCount($lastDate);
            $money = $offer->money($lastDate);
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: $count Доход: $money\n";
        }
        echo "Всего переходов: {$user->offerSubscriptionCount($lastDate)}. Доход: {$user->offerIncome($lastDate)}\n\n";

        // последний месяц
        $lastDate = StatisticController::getDate('-1 month');
        echo "$lastDate:\n";
        foreach ($offers->all() as $offer) {
            $count = $offer->linkCount($lastDate);
            $money = $offer->money($lastDate);
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: $count Доход: $money\n";
        }
        echo "Всего переходов: {$user->offerSubscriptionCount($lastDate)}. Доход: {$user->offerIncome($lastDate)}\n\n";

        // последний год
        $lastDate = StatisticController::getDate('-1 year');
        echo "$lastDate:\n";
        foreach ($offers->all() as $offer) {
            $count = $offer->linkCount($lastDate);
            $money = $offer->money($lastDate);
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: $count Доход: $money\n";
        }
        echo "Всего переходов: {$user->offerSubscriptionCount($lastDate)}. Доход: {$user->offerIncome($lastDate)}\n\n";

        $this->assertDatabaseCount('offer_subscriptions', 11);
    }
}
