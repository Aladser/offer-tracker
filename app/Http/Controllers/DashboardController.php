<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OfferTheme;
use App\Models\Offer;
use App\Models\OfferSubscription;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
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
                        ['userId' => $request->user()->id, 'themes' => OfferTheme::all()->toArray()] 
                    );
            case 'веб-мастер':
                $userId = $request->user()->id;
                return view(
                        'pages/webmaster',
                        [
                            'subscriptions' => OfferSubscription::where('follower_id', $userId),
                            'offers' => Offer::getActiveOffersWithoutUser($userId)
                        ]
                    );
            case 'рекламодатель':
                return view(
                        'pages/advertiser', 
                        ['advertiser' => $request->user()->advertiser, 'userId' => $request->user()->id] 
                    );
            default:
                dd('ошибка роли пользователя: ' . $request->user()->role->name);
        }
    }
}
