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
        switch ($request->user()->role->name) {
            case 'администратор':
                $table = DB::table('offer_clicks')->join('offers', 'offers.id', '=', 'offer_clicks.offer_id');
                $totalIncome = $table->sum('price');
                $totalClicks = $table->count();
                $commission = SystemOption::commission();

                return view(
                        'pages/admin', 
                        [
                            // id пользователя-рекламщика 
                            'userId' => $request->user()->id,
                            // все темы офферов 
                            'themes' => OfferTheme::all()->toArray(),
                            // доход системы
                            'income' => ['income'=>$totalIncome, 'clicks'=>$totalClicks, 'commission' => $commission],
                        ] 
                    );
            case 'веб-мастер':
                $userId = $request->user()->id;
                return view(
                        'pages/webmaster',
                        [
                            // подписки пользователя
                            'subscriptions' => OfferSubscription::where('follower_id', $userId),
                            // все доступные офферы без подписок пользователя
                            'offers' => Offer::getActiveOffersExceptUserSubscriptions($userId)
                        ]
                    );
            case 'рекламодатель':
                return view(
                        'pages/advertiser', 
                        [
                            // рекламодатель
                            'advertiser' => $request->user()->advertiser,
                            // id пользователя-рекламщика (оптимизация) 
                            'userId' => $request->user()->id
                        ] 
                    );
            default:
                dd('ошибка роли пользователя: ' . $request->user()->role->name);
        }
    }
}
