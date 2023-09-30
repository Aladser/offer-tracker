<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\OfferSubscription;

/** проверка наличия реферальной ссылки */
class IsOfferReference
{
    public function handle(Request $request, Closure $next)
    {
        $params = $request->all();
        if (array_key_exists('ref', $params)) {
            $refCode = $params['ref'];
            $reference = OfferSubscription::where('refcode', $refCode)->first();
            if (is_null($reference)) {
                return redirect('page404');
            } else {
                return redirect($reference->offer->url);
            }
        }
        return $next($request);
    }
}
