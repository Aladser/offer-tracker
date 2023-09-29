<?php

namespace App\Services;

use App\Models\User;
use App\Models\SystemOption;

class OfferService
{
    public function getStatistics(User $user) {
        // комиссия
        $commision = SystemOption::where('name', 'commission')->first()->value('value')/ 100;

        if ($user->role->name === 'рекламодатель') {
            $totalClicks = 0;
            $totalMoney = 0;
            $advertiserOffers = [];

            foreach ($user->advertiser->offers as $offer) {
                $clicks = $offer->clicks->count();
                $price = $offer->price;
                $money = $clicks * $price;
                $totalClicks += $clicks;
                $totalMoney += $money;
                $advertiserOffers[] = ['id'=>$offer->id, 'name'=>$offer->name, 'clicks'=>$clicks, 'money'=>$money];
            }

            return [
                'offers'=>$advertiserOffers, 
                'totalClicks'=>$totalClicks, 
                'totalMoney'=>$totalMoney
            ];
        }
    }
}