<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Services\OfferService;
use App\Models\User;
use App\Models\Advertiser;
use App\Models\Webmaster;
use App\Models\OfferClick;
use App\Models\SystemOption;

class ClickTest extends TestCase
{
    use RefreshDatabase;

    public function testAdvertiserOfferClicks()
    {
        system('clear');
        $this->seedTest();

        $offerService = new OfferService();
        $advertiser = Advertiser::find(1);


        echo "офферы рекламщика {$advertiser->user->name}:\n";
        $data = $offerService->getOfferData($advertiser->user);
        foreach ($data['offers'] as $offer) {
            echo "{$offer['name']} посетителей:{$offer['clicks']} потрачено:{$offer['money']}\n";
        }
        echo "Всего: посетителей:{$data['totalClicks']} потрачено:{$data['totalMoney']}\n";


        $this->assertDatabaseCount('offer_subscriptions', 6);
    }

    public function testWebmasterSubscriptionClicks()
    {
        $this->seedTest();

        $totalClicks = 0;
        $totalMoney = 0;
        $offerService = new OfferService();
        $webmaster = Webmaster::find(1);
        $this->commission = SystemOption::where('name', 'commission')->first()->value('value');

        echo "\nпереходы вебмастера {$webmaster->user->name}:\n";
        foreach ($webmaster->subscriptions as $subscription) {
            $offer = $subscription->offer;
            // число посещений
            $clicks = $subscription->clicks->where('webmaster_id', $webmaster->id);

            $clickCount = $clicks->count();
            $income = 0;
            foreach ($clicks as $click) {
                $income += $click->income_part * $offer->price;
            }
            
            $totalClicks += $clickCount;
            $totalMoney += $income;
            echo " name:{$offer->name} clicks:{$clickCount} money:{$income}\n";
        }
        echo "Всего: переходов {$totalClicks} деньги {$totalMoney}\n";

        $this->assertDatabaseCount('offer_subscriptions', 6);
    }

    public function testCommissions()
    {
        //select name, income_part, price, (1-income_part) * price as commission from offer_clicks join offers on offers.id = offer_clicks.offer_id ;
        $this->seedTest();

        $extendedClicks = OfferClick::join('offers','offers.id','=','offer_clicks.offer_id');
        $table = $extendedClicks->select('price', DB::raw('1-income_part as commission'), DB::raw('(1-income_part) * price as money'));

        echo "\nКомиссии\n";
        foreach ($table->get()->toArray() as $click) {
            echo "цена:{$click['price']} комиссия:{$click['commission']} деньги:{$click['money']}\n";
        }
        echo "Всего денег: {$table->get()->sum('money')}\n";

        $this->assertDatabaseCount('offer_subscriptions', 6);
    }
}
