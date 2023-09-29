<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OfferService;
use App\Models\OfferSubscription;
use App\Models\User;
use App\Models\SystemOption;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        // временыые промежутки
        $lastDay = StatisticController::getDate('-1 day');
        $lastMonth = StatisticController::getDate('-1 month');
        $lastYear = StatisticController::getDate('-1 year');
        $allTime = StatisticController::getDate();
        $times = ['lastDay' => $lastDay, 'lastMonth' => $lastMonth, 'lastYear' => $lastYear, 'allTime' => $allTime];
        // комиссия
        $commision = SystemOption::where('name', 'commission')->first()->value('value')/ 100;

        if ($request->user()->role->name === 'рекламодатель') {
            $totalClicks = 0;
            $totalMoney = 0;
            $advertiserOffers = [];

            foreach ($request->user()->advertiser->offers as $offer) {
                $clicks = $offer->clicks->count();
                $price = $offer->price;
                $money = $clicks * $price;
                $totalClicks += $clicks;
                $totalMoney += $money;
                $advertiserOffers[] = ['id'=>$offer->id, 'name'=>$offer->name, 'clicks'=>$clicks, 'money'=>$money];
            }

            $data = [
                'user' => $request->user(),
                'times' => $times, 
                'offers'=>$advertiserOffers, 
                'totalClicks'=>$totalClicks, 
                'totalMoney'=>$totalMoney
            ];
            return view('pages/statistics', $data);
        } else if($request->user()->role->name === 'веб-мастер') {
            return view('pages/statistics', ['user' => $request->user(), 'times' => $times] );
        } else {
            return redirect('/dashboard');
        }
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
