<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\OfferSubscription;
use App\Models\OfferClick;

/** отлавливает реферальную ссылку */
class IsOfferReference
{
    public function handle(Request $request, Closure $next)
    {
        $params = $request->all();

        if (array_key_exists('ref', $params)) {
            $logChannel = Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/offer_click.log'),
              ]);

            $refCode = $params['ref'];
            $subscription = OfferSubscription::where('refcode', $refCode)->first();
            if (is_null($subscription)) {
                Log::stack(['slack', $logChannel])->info("переход по ссылке {$request->path()}?ref=$refCode завершился с ошибкой");
                return redirect('page404');
            } else {
                // зафиксировать факт перенаправления
                OfferClick::add($subscription->follower->id, $subscription->offer->id);
                Log::stack(['slack', $logChannel])->info("переход по ссылке {$request->path()}?ref=$refCode успешен");
                return redirect($subscription->offer->url);
            }
        }
        return $next($request);
    }
}