<?php

namespace App\Services;

use App\Models\User;

/** Статистика офферов пользователя */
class OfferStatistics
{
    /** получить данные офферов рекламодателя или веб-мастера за разные временные промежутки */
    public function getStatisticsData(User $user)
    {
        $data['user'] = $user;

        // временные промежутки
        $lastDay = OfferStatistics::getDate('-1 day');
        $lastMonth = OfferStatistics::getDate('-1 month');
        $lastYear = OfferStatistics::getDate('-1 year');
        $allTime = OfferStatistics::getDate();
        $data['times'] = [
            'lastDay' => $lastDay,
            'lastMonth' => $lastMonth,
            'lastYear' => $lastYear,
            'allTime' => $allTime,
        ];

        // статистика офферов
        $data['offersAllTime'] = $this->getOfferData($user);
        $data['offersLastDay'] = $this->getOfferData($user, $lastDay);
        $data['offersLastMonth'] = $this->getOfferData($user, $lastMonth);
        $data['offersLastYear'] = $this->getOfferData($user, $lastYear);

        return $data;
    }

    /** получить данные офферов рекламодателя или веб-мастера */
    public function getOfferData(User $user, $date = null)
    {
        $totalClicks = 0;
        $totalMoney = 0;
        $offers = [];
        // рекламодатель
        if ($user->role->name === 'рекламодатель') {
            $advertiserOffers = $user->advertiser->offers;
            foreach ($advertiserOffers as $offer) {
                // число переходов по ссылкам на оффер
                if (is_null($date)) {
                    $clickCount = $offer->clicks->count();
                } else {
                    $clickCount = $offer->clicks->where('created_at', '>', $date)->count();
                }
                // расходы за переходы
                $price = $offer->price;
                $money = $clickCount * $price;

                $totalClicks += $clickCount;
                $totalMoney += $money;
                $offers[] = ['id' => $offer->id, 'name' => $offer->name, 'clicks' => $clickCount, 'money' => $money];
            }
            // веб-мастер
        } elseif ($user->role->name === 'веб-мастер') {
            $subscriptions = $user->webmaster->subscriptions;
            foreach ($subscriptions as $subscription) {
                $offer = $subscription->offer;
                // число переходов по ссылкам на оффер
                if (is_null($date)) {
                    $clicks = $offer->clicks->where('webmaster_id', $user->webmaster->id);
                } else {
                    $clicks = $offer->clicks
                        ->where('webmaster_id', $user->webmaster->id)
                        ->where('created_at', '>', $date);
                }
                $clickCount = $clicks->count();
                // доходы за переходы
                $income = 0;
                foreach ($clicks as $click) {
                    $income += $click->income_part * $offer->price;
                }

                $totalClicks += $clickCount;
                $totalMoney += $income;
                $offers[] = ['id' => $offer->id, 'name' => $offer->name, 'clicks' => $clickCount, 'money' => $income];
            }
        } else {
            return null;
        }

        return [
            'offers' => $offers,
            'totalClicks' => $totalClicks,
            'totalMoney' => $totalMoney,
        ];
    }

    /** получить текущее время с учетом часового пояса и сдвигом */
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
