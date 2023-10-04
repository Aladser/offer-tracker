<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OfferTheme;
use App\Models\Offer;
use App\Models\OfferClick;
use App\Models\OfferSubscription;
use App\Models\SystemOption;
use App\Models\FailedOfferClick;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $commission = SystemOption::commission();

        switch ($request->user()->role->name) {
            case 'администратор':
                $table = OfferClick::join('offers', 'offers.id', '=', 'offer_clicks.offer_id');
                // общее число переходов
                $totalClicks = $table->count();
                // общий доход системы
                $totalIncome = OfferClick::join('offers','offers.id','=','offer_clicks.offer_id')
                    ->select('price', DB::raw('1-income_part as commission'), DB::raw('(1-income_part) * price as money'))
                    ->get()
                    ->sum('money');
                
                return view(
                        'pages/admin', 
                        [
                            'userId' => $request->user()->id,
                            // темы офферов
                            'themes' => OfferTheme::all()->toArray(),
                            //  доход системы
                            'income'=>$totalIncome,
                            // общее число кликов
                            'clicks'=>$totalClicks,
                            // комиссия
                            'commission' => $commission,
                            // число ошибочных реферальных ссылок
                            'failed_references' => FailedOfferClick::all()->count(),
                        ] 
                    );
            case 'веб-мастер':
                $webmasterId = $request->user()->webmaster->id;
                return view(
                        'pages/webmaster',
                        [
                            // подписки пользователя
                            'subscriptions' => OfferSubscription::where('webmaster_id', $webmasterId),
                            // все доступные офферы без подписок пользователя
                            'offers' => Offer::getActiveOffersExceptUserSubscriptions($webmasterId),
                            // id пользователя-рекламщика (оптимизация) 
                            'userId' => $request->user()->id,
                            // доля оплаты вебмастера 
                            'incomePercent' => round((100-$commission)/100, 2),
                        ]
                    );
            case 'рекламодатель':
                return view(
                        'pages/advertiser', 
                        [
                            // рекламодатель
                            'advertiser' => $request->user()->advertiser,
                            // id пользователя-рекламщика (для оптимизации) 
                            'userId' => $request->user()->id
                        ]
                    );
            default:
                dd('ошибка роли пользователя: ' . $request->user()->role->name);
        }
    }
}
