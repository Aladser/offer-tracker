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
        // рекламодатель
        if ($user->role->name === 'рекламодатель') {
            $offers = $user->advertiser->offers;
            foreach ($offers as $offer) {
                // число подписок вебмастеров
                if (is_null($date)) {
                    $clicks = $offer->clicks->count();
                } else {
                    $clicks = $offer->clicks->where('created_at', '>', $date)->count();
                }
                // доход за переходы
                $price = $offer->price;
                $money = $clicks * $price;

                $totalClicks += $clicks;
                $totalMoney += $money;
                $advertiserOffers[] = ['id'=>$offer->id, 'name'=>$offer->name, 'clicks'=>$clicks, 'money'=>$money];
            }
        // веб-мастер
        } else if ($user->role->name === 'веб-мастер'){
            $subscriptions = $user->webmaster->subscriptions;
            foreach ($subscriptions as $subscription) {
                $offer = $subscription->offer;
                // число посещений
                if (is_null($date)) {
                    $clicks = $subscription->clicks->where('webmaster_id', $user->webmaster->id);
                } else {
                    $clicks = $offer->clicks->where('webmaster_id', $user->webmaster->id)->where('created_at', '>', $date);
                }
                $clickCount = $clicks->count();

                $income = 0;
                foreach ($clicks as $click) {
                    $income += $click->income_part * $offer->price;
                } 

                $totalClicks += $clickCount;
                $totalMoney += $income;
                $advertiserOffers[] = ['id'=>$offer->id, 'name'=>$offer->name, 'clicks'=>$clickCount, 'money'=>$income];
            }
        } else {
            return null;
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
}