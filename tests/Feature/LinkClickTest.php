<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Advertiser;
use App\Models\Webmaster;
use App\Models\SystemOption;

class LinkClickTest extends TestCase
{
    use RefreshDatabase;

    public function testAdvertiserOfferClicks()
    {
        if (User::count() === 0) {
            $this->seed();
        }

        $advertiser = Advertiser::find(1);
        $commission = SystemOption::where('name', 'commission')->first()->value('value');
        echo "  Комиссия $commission%\n";
        echo "  Клики и расходы рекламщика {$advertiser->user->name}:\n";
        $totalClicks = 0;
        $totalMoney = 0;

        $advertiserOffers = [];

        foreach ($advertiser->offers as $offer) {
            $clicks = $offer->clicks->count();
            $price = $offer->price;
            $money = $clicks * $price;
            $totalClicks += $clicks;
            $totalMoney += $money;
            $advertiserOffers[] = ['name'=>$offer->name, 'clicks'=>$clicks, 'money'=>$money];
        }

        foreach ($advertiserOffers as $offer) {
            echo "name:".$offer['name']." clicks:".$offer['clicks']." money:".$offer['money']."\n";
        }
        echo " Итог. переходов:$totalClicks сумма:$totalMoney\n";

        $this->assertDatabaseCount('offer_subscriptions', 6);
    }

    public function testWebmasterSubscriptionClicks()
    {
        if (User::count() === 0) {
            $this->seed();
        }

        $webmaster = Webmaster::find(1);
        echo "\n  Клики и доходы мастера {$webmaster->user->name}:\n";
        $subscriptions = $webmaster->subscriptions;
        $commission = SystemOption::where('name', 'commission')->first()->value('value');
        $counts = 0;
        $totalExpense = 0;
        $totalIncome = 0;

        foreach ($subscriptions as $subscription) {
            $offer = $subscription->offer;
            $clicks = $offer->clicks->count();
            $sum = $offer->clicks->count() * $offer->price;
            $income = $this->getIncome($sum, $commission);

            echo "{$offer->name}. цена:{$offer->price} переходов:{$offer->clicks->count()} сумма:";
            echo "$income ($sum)\n";
            $counts += $clicks;
            $totalExpense += $sum;
            $totalIncome += $income;
        }

        echo " Итог. переходов:$counts заработано:$totalIncome (потратили $totalExpense)\n";

        $this->assertDatabaseCount('offer_subscriptions', 6);
    }

    private function getIncome($money, $commission) {
        return $money * (100-$commission)/100;
    }
}
