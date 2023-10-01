<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\OfferService;
use App\Models\User;
use App\Models\Advertiser;
use App\Models\Webmaster;
use App\Models\OfferSubscription;

class LinkClickTest extends TestCase
{
    use RefreshDatabase;

    public function testAdvertiserOfferClicks()
    {
        system('clear');
        $this->seed();
        $offerService = new OfferService();
        $advertiser = Advertiser::find(1);


        echo "статистика офферов рекламщика {$advertiser->user->name}:\n";
        $data = $offerService->getOfferData($advertiser->user);
        foreach ($data['offers'] as $offer) {
            echo "{$offer['name']} посетителей:{$offer['clicks']} потрачено:{$offer['money']}\n";
        }
        echo "Всего: посетителей:{$data['totalClicks']} потрачено:{$data['totalMoney']}\n";


        $this->assertDatabaseCount('offer_subscriptions', 6);
    }

    public function testWebmasterSubscriptionClicks()
    {
        if (User::count() === 0) {
            $this->seed();
        }
        $offerService = new OfferService();
        $webmaster = Webmaster::find(1);

        echo "\nстатистика подписок мастера {$webmaster->user->name}:\n";
        $data = $offerService->getOfferData($webmaster->user);
        foreach ($data['offers'] as $offer) {
            echo "{$offer['name']} посетителей:{$offer['clicks']} получено:{$offer['money']}\n";
        }
        echo "Всего: посетителей:{$data['totalClicks']} получено:{$data['totalMoney']}\n";

        $this->assertDatabaseCount('offer_subscriptions', 6);
    }

    private function getIncome($money, $commission) {
        return $money * (100-$commission)/100;
    }

    public function testSubscriptions()
    {
        if (User::count() === 0) {
            $this->seed();
        }
        $subscriptions = OfferSubscription::join('offers','offer_subscriptions.offer_id', '=', 'offers.id');
        var_dump($subscriptions->get()->toArray());
        echo 'подписок = ' . $subscriptions->count() . "\n";
        echo 'активных подписок = ' . $subscriptions->where('status', 1)->count()."\n";
        $this->assertDatabaseCount('offer_subscriptions', 6);
    }
}
