<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\OfferSubscription;
use App\Models\OfferClick;

/** отлавливает реферальную ссылку */
class IsOfferReference
{
    public function handle(Request $request, Closure $next)
    {
        $params = $request->all();
        if (array_key_exists('ref', $params)) {
            $refCode = $params['ref'];
            $subscription = OfferSubscription::where('refcode', $refCode)->first();
            if (is_null($subscription)) {
                return redirect('page404');
            } else {
                // зафиксировать факт перенаправления
                OfferClick::add($subscription->follower->id, $subscription->offer->id);
                return redirect($subscription->offer->url);
            }
        }
        return $next($request);
    }
}
