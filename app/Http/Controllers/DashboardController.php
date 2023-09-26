<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfferTheme;
use App\Models\Offer;
use App\Models\OfferSubscription;

class DashboardController extends Controller
{
    /** Обработать входящий запрос
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $url = null;
        switch ($request->user()->role->name) {
            case 'администратор':
                return view(
                        'pages/admin', 
                        [
                            // id пользователя-рекламщика 
                            'userId' => $request->user()->id,
                            // все темы офферов 
                            'themes' => OfferTheme::all()->toArray()
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
                            'offers' => Offer::getActiveOffersExceptUser($userId)
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
