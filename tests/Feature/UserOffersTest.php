<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Offer;
use App\Models\OfferSubscription;
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

    // активные подписки без подписок конкретного пользователя 
    public function testGetActiveOffers()
    {
        $subscrOffers = OfferSubscription::where('follower_id',3)->select('offer_id');
        echo " Все активные офферы:\n";
        $offers = Offer::where('status', 1);
        foreach ($offers->get() as $offer) {
            echo "имя:{$offer->name} статус:{$offer->status} цена:{$offer->price} тема:{$offer->theme->name}\n";
        }
        echo " Активные офферы без User3:\n";
        $offers = Offer::where('status', 1)->whereNotIn('id', $subscrOffers);
        foreach ($offers->get() as $offer) {
            echo "имя:{$offer->name} статус:{$offer->status} цена:{$offer->price} тема:{$offer->theme->name}\n";
        }
        echo " Подписки User3:\n";
        foreach (OfferSubscription::where('follower_id',3)->get() as $subscription) {
            $status = $subscription->offer->status ? 'активна' : 'неактивна';
            echo "Подписка на {$subscription->offer->name} пользователя {$subscription->follower->name} $status \n";
        }
        $this->assertDatabaseCount('offer_subscriptions', 11);
    }
}
