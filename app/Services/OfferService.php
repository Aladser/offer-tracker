<?php

namespace App\Services;

use App\Models\User;
use App\Models\SystemOption;

class OfferService
{
    private $commission;

    public function __construct()
    {
        // комиссия системы
        $this->commission = SystemOption::where('name', 'commission')->first()->value('value');
    }

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
        $data['offersAllTime'] = $this->getOfferData($user);
        $data['offersLastDay'] = $this->getOfferData($user, $lastDay);
        $data['offersLastMonth'] = $this->getOfferData($user, $lastMonth);
        $data['offersLastYear'] = $this->getOfferData($user, $lastYear);
        return $data;
    }

    public function getOfferData(User $user, $date = null) {
        $totalClicks = 0;
        $totalMoney = 0;
        $advertiserOffers = [];

        if ($user->role->name === 'рекламодатель') {
            $offers = $user->advertiser->offers;
            if (is_null($date)) {
                foreach ($offers as $offer) {
                    $clicks = $offer->clicks->count();
                    $price = $offer->price;
                    $money = $clicks * $price;
                    $totalClicks += $clicks;
                    $totalMoney += $money;
                    $advertiserOffers[] = ['id'=>$offer->id, 'name'=>$offer->name, 'clicks'=>$clicks, 'money'=>$money];
                }
            } else {
                foreach ($offers as $offer) {
                    $clicks = $offer->clicks->where('created_at', '>', $date)->count();
                    $price = $offer->price;
                    $money = $clicks * $price;
                    $totalClicks += $clicks;
                    $totalMoney += $money;
                    $advertiserOffers[] = ['id'=>$offer->id, 'name'=>$offer->name, 'clicks'=>$clicks, 'money'=>$money];
                }
            }
        } else {
            $subscriptions = $user->webmaster->subscriptions;
            if (is_null($date)) {
                foreach ($subscriptions as $subscription) {
                    $offer = $subscription->offer; // оффер
                    $clicks = $offer->clicks->count(); // число посетителей

                    $sum = $clicks * $offer->price;  // расходы рекламщика
                    $income = $this->getIncome($sum, $this->commission); // доходы вебмастера

                    $totalClicks += $clicks;
                    $totalMoney += $income;
                    $advertiserOffers[] = ['id'=>$offer->id, 'name'=>$offer->name, 'clicks'=>$clicks, 'money'=>$income];
                }
            } else {
                foreach ($subscriptions as $subscription) {
                    $offer = $subscription->offer;
                    $clicks = $offer->clicks->where('created_at', '>', $date)->count();
                    $sum = $offer->clicks->count() * $offer->price;
                    $income = $this->getIncome($sum, $this->commission);
                    
                    $totalClicks += $clicks;
                    $totalMoney += $income;
                    $advertiserOffers[] = ['id'=>$offer->id, 'name'=>$offer->name, 'clicks'=>$clicks, 'money'=>$income];
                }
            }
        }

        return [
            'offers'=>$advertiserOffers, 
            'totalClicks'=>$totalClicks, 
            'totalMoney'=>$totalMoney
        ];
    }

    /** получить текущее время с учетом часового пояса */
    public static function getDate($period = null)
    {
        $date = new \DateTime();
        $timezone = env('TIMEZONE');
        $date->modify("+ $timezone hours");
        if (!is_null($period)) {
            $date->modify($period);
        }
        return $date->format('Y-m-d H:i:s');
    }

    /** доход-процент вебмастера */
    private function getIncome($money) {
        return round($money * (100-$this->commission)/100, 2);
    }
}