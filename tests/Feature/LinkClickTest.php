<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Offer;
use App\Models\OfferSubscription;
use App\Models\Advertiser;
use App\Models\Webmaster;

class LinkClickTest extends TestCase
{
    use RefreshDatabase;

    public function testAdvertiserOffers()
    {
        if (User::count() === 0) {
            $this->seed();
        }

        echo "  офферы рекламщиков\n";
        for ($i=1; $i<4; $i++) {
            $advertiser = Advertiser::find($i);
            echo $advertiser->user->name . ': ' . $advertiser->offers->count() . " оффера\n";
        }
        echo "  расходы рекламщиков\n";
        

        $this->assertDatabaseCount('offer_subscriptions', 6);
    }

    public function testMasterSubscriptions()
    {
        if (User::count() === 0) {
            $this->seed();
        }

        echo "офферы вебмастеров\n";
        for ($i=1; $i<4; $i++) {
            $webmaster = Webmaster::find($i);
            echo $webmaster->user->name . ': ' . $webmaster->subscriptions->count() . " подписок\n";
        }

        $this->assertDatabaseCount('offer_subscriptions', 6);
    }
}
