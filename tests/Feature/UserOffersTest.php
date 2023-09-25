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
        $offers = User::find(2)->offers; 

        // офферы за все время
        echo 'Офферы ' . User::find($advertiser_id)->name . "\n" . StatisticController::getDate() . ":\n";
        foreach ($offers->all() as $offer) {
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: {$offer->links->count()} Доход:"
                . $offer->links->count() * $offer->price . "\n";
        }
        $data = DB::table('offer_subscriptions')->join('offers', 'offers.id', '=', 'offer_subscriptions.offer_id');
        echo "Подписчиков: {$data->where('advertiser_id', $advertiser_id)->get()->count()}. Сумма: {$data->get()->sum('price')}\n\n";

        // офферы за последний день
        $lastDate = StatisticController::getDate('-1 day');
        echo "$lastDate:\n";
        foreach ($offers->all() as $offer) {
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: {$offer->links->where('created_at', '>', $lastDate)->count()} Доход:"
                . $offer->links->where('created_at', '>', $lastDate)->count() * $offer->price . "\n";
        }
        $data = DB::table('offer_subscriptions')->join('offers', 'offers.id', '=', 'offer_subscriptions.offer_id');
        echo "Подписчиков: {$data->where('advertiser_id', $advertiser_id)->where('created_at', '>', $lastDate)->count()}. Сумма: {$data->where('created_at', '>', $lastDate)->sum('price')}\n\n";

        // офферы за последний месяц
        $lastDate = StatisticController::getDate('-1 month');
        echo "$lastDate\n";
        foreach ($offers->all() as $offer) {
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: {$offer->links->where('created_at', '>', $lastDate)->count()} Доход:"
                . $offer->links->where('created_at', '>', $lastDate)->count() * $offer->price . "\n";
        }
        $data = DB::table('offer_subscriptions')->join('offers', 'offers.id', '=', 'offer_subscriptions.offer_id');
        echo "Подписчиков: {$data->where('advertiser_id', $advertiser_id)->where('created_at', '>', $lastDate)->count()}. Сумма: {$data->where('created_at', '>', $lastDate)->sum('price')}\n\n";

        // офферы за последний год
        $lastDate = StatisticController::getDate('-1 year');
        echo "$lastDate:\n";
        foreach ($offers->all() as $offer) {
            echo "$offer->id $offer->name. Цена: $offer->price Переходы: {$offer->links->where('created_at', '>', $lastDate)->count()} Доход:"
                . $offer->links->where('created_at', '>', $lastDate)->count() * $offer->price . "\n";
        }
        $data = DB::table('offer_subscriptions')->join('offers', 'offers.id', '=', 'offer_subscriptions.offer_id');
        echo "Подписчиков: {$data->where('advertiser_id', $advertiser_id)->where('created_at', '>', $lastDate)->count()}. Сумма: {$data->where('created_at', '>', $lastDate)->sum('price')}\n\n";

        $this->assertDatabaseCount('offer_subscriptions', 11);
    }
}
