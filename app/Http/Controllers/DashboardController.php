<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OfferTheme;
use App\Models\Offer;
use App\Models\OfferClick;
use App\Models\OfferSubscription;
use App\Models\SystemOption;

class DashboardController extends Controller
{
    /** Обработать входящий запрос
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $commission = SystemOption::commission();

        switch ($request->user()->role->name) {
            case 'администратор':
                $table = OfferClick::join('offers', 'offers.id', '=', 'offer_clicks.offer_id');
                $totalIncome = $table->sum(DB::raw('price * income_part'));
                $totalClicks = $table->count();
                
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
                            'commission' => $commission
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
