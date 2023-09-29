<?php

namespace App\Services;

use App\Models\User;
use App\Models\SystemOption;

class OfferService
{
    public function getStatisticsData(User $user)
    {
        $data['user'] = $user;

        // временные промежутки
        $lastDay = OfferService::getDate('-1 day');
        $lastMonth = OfferService::getDate('-1 month');
        $lastYear = OfferService::getDate('-1 year');
        $allTime = OfferService::getDate();
        $data['times'] = ['lastDay' => $lastDay, 'lastMonth' => $lastMonth, 'lastYear' => $lastYear, 'allTime' => $allTime];

        // статистика офферов
        $data['offersAllTime'] = $this->getOfferStatistics($user);
        $data['offersLastDay'] = $this->getOfferStatistics($user, $lastDay);
        $data['offersLastMonth'] = $this->getOfferStatistics($user, $lastMonth);
        $data['offersLastYear'] = $this->getOfferStatistics($user, $lastYear);
        return $data;
    }
    
    private function getOfferStatistics(User $user, $date = null) {
        // комиссия
        $commision = SystemOption::where('name', 'commission')->first()->value('value')/ 100;

        if ($user->role->name === 'рекламодатель') {
            $totalClicks = 0;
            $totalMoney = 0;
            $advertiserOffers = [];

            if (is_null($date)) {
                foreach ($user->advertiser->offers as $offer) {
                    $clicks = $offer->clicks->count();
                    $price = $offer->price;
                    $money = $clicks * $price;
                    $totalClicks += $clicks;
                    $totalMoney += $money;
                    $advertiserOffers[] = ['id'=>$offer->id, 'name'=>$offer->name, 'clicks'=>$clicks, 'money'=>$money];
                }
            } else {
                foreach ($user->advertiser->offers as $offer) {
                    $clicks = $offer->clicks->where('created_at', '>', $date)->count();
                    $price = $offer->price;
                    $money = $clicks * $price;
                    $totalClicks += $clicks;
                    $totalMoney += $money;
                    $advertiserOffers[] = ['id'=>$offer->id, 'name'=>$offer->name, 'clicks'=>$clicks, 'money'=>$money];
                }
            }

            return [
                'offers'=>$advertiserOffers, 
                'totalClicks'=>$totalClicks, 
                'totalMoney'=>$totalMoney
            ];
        }
    }

    /** получить текущее время с учетом часового пояса */
    private static function getDate($period = null)
    {
        $date = new \DateTime();
        $timezone = env('TIMEZONE');
        $date->modify("+ $timezone hours");
        if (!is_null($period)) {
            $date->modify($period);
        }
        return $date->format('Y-m-d H:i:s');
    }
}