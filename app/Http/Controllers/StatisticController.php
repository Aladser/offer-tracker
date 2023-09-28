<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfferSubscription;
use App\Models\User;
use App\Models\SystemOption;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $lastDay = StatisticController::getDate('-1 day');
        $lastMonth = StatisticController::getDate('-1 month');
        $lastYear = StatisticController::getDate('-1 year');
        $allTime = StatisticController::getDate();
        $times = ['lastDay' => $lastDay, 'lastMonth' => $lastMonth, 'lastYear' => $lastYear, 'allTime' => $allTime];

        $commision = SystemOption::where('name', 'commission')->first()->value('value')/ 100;

        if ($request->user()->role->name === 'рекламодатель') {
            $offers = $request->user()->advertiser->offers;
            //dd($request->user()->advertiser->offers->toArray());
            return view('pages/statistics', ['user' => $request->user(), 'times' => $times] );
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
