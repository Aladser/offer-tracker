<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\OfferTheme;
use App\Models\Offer;
use App\Models\OfferClick;
use App\Models\OfferSubscription;
use App\Models\FailedOfferClick;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $commission = SystemOptionController::commission();

        switch ($user->role->name) {
            case 'администратор':
                $clicks = OfferClick::join('offers', 'offers.id', '=', 'offer_clicks.offer_id');
                // общий доход системы
                $totalIncome = $clicks
                    ->select(DB::raw('(1-income_part) * price as money'))
                    ->get()
                    ->sum('money');
                
                return view(
                    'pages/dashboard/admin',
                    [
                            'userId' => $user->id,
                            // темы офферов
                            'themes' => OfferTheme::all()->toArray(),
                            //  доход системы
                            'income'=>$totalIncome,
                            // общее число кликов
                            'clicks'=>$clicks->count(),
                            // число подписчиков на офферы
                            'subscriptionCount' => OfferSubscription::all()->count(),
                            // комиссия
                            'commission' => $commission,
                            // число ошибочных реферальных ссылок
                            'failed_references' => FailedOfferClick::all()->count(),
                        ]
                );
            case 'веб-мастер':
                $webmasterId = $user->webmaster->id;
                // активные офферы без учета подписок
                $subscrOffers = OfferSubscription::where('webmaster_id', $webmasterId)->select('offer_id');
                $activeOffers = Offer::where('status', 1)->whereNotIn('id', $subscrOffers);
                
                return view(
                    'pages/dashboard/webmaster',
                    [
                            // подписки пользователя
                            'subscriptions' => OfferSubscription::where('webmaster_id', $webmasterId),
                            // все доступные офферы без подписок пользователя
                            'offers' => $activeOffers,
                            // id пользователя-рекламщика (оптимизация)
                            'userId' => $user->id,
                            // доля оплаты вебмастера
                            'incomePercent' => round((100-$commission)/100, 2),
                        ]
                );
            case 'рекламодатель':
                return view(
                    'pages/dashboard/advertiser',
                    [
                            // рекламодатель
                            'advertiser' => $user->advertiser,
                            // id пользователя-рекламщика (для оптимизации)
                            'userId' => $user->id
                        ]
                );
            default:
                dd('ошибка роли пользователя: ' . $user->role->name);
        }
    }
}
