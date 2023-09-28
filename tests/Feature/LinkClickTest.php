<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Offer;
use App\Models\OfferClick;
use App\Models\OfferSubscription;
use App\Models\Advertiser;
use App\Models\Webmaster;

class LinkClickTest extends TestCase
{
    use RefreshDatabase;

    public function testAdvertiserOfferClicks()
    {
        if (User::count() === 0) {
            $this->seed();
        }

        $advertiser = Advertiser::find(1);
        echo "клики и расходы рекламщика {$advertiser->user->name}:\n";

        foreach ($advertiser->offers as $offer) {
            echo "{$offer->name}. цена:{$offer->price} переходов:{$offer->clicks->count()} сумма:";
            echo $offer->clicks->count() * $offer->price . "\n";
        }
        $table = OfferClick::join('offers','offers.id','=','offer_clicks.offer_id');
        echo "Итог. переходов:{$table->where('advertiser_id', 1)->count()} сумма:";
        echo $table->sum('price')."\n";

        $this->assertDatabaseCount('offer_subscriptions', 6);
    }

    public function testWebmasterSubscriptionClicks()
    {
        if (User::count() === 0) {
            $this->seed();
        }

        $webmaster = Webmaster::find(1);
        echo "клики и расходы мастера {$webmaster->user->name}:\n";

        foreach ($webmaster->subscriptions as $subscription) {
            $offer = $subscription->offer;
            echo "{$offer->name}. цена:{$offer->price} переходов:{$offer->clicks->count()} сумма:";
            echo $offer->clicks->count() * $offer->price . "\n";
        }

        var_dump(OfferClick::selectRaw("offer_id, sum(offer_id) as count"))->groupBy('offer_id')->get();

        $this->assertDatabaseCount('offer_subscriptions', 6);
    }
}
