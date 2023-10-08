<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\OfferClickController;
use App\Http\Controllers\FailedOfferClickController;
use App\Models\OfferSubscription;
use function Ratchet\Client\connect;

/** отлавливает реферальную ссылку */
class IsOfferReference
{
    public function handle(Request $request, Closure $next)
    {
        $params = $request->all();

        if (array_key_exists('ref', $params)) {
            // запись лога
            $logChannel = Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/offer_click.log'),
              ]);

            $refCode = $params['ref'];
            
            $subscription = OfferSubscription::where('refcode', $refCode)->first();
            if (is_null($subscription)) {
                Log::stack(['slack', $logChannel])->info("переход по ссылке {$request->path()}?ref=$refCode завершился с ошибкой");
                FailedOfferClickController::add("{$request->path()}?ref=$refCode");
                return redirect('page404');
            } else {
                // зафиксировать факт перенаправления
                OfferClickController::add($subscription->follower->id, $subscription->offer->id);
                Log::stack(['slack', $logChannel])->info("переход по ссылке {$request->path()}?ref=$refCode успешен");
                
                return redirect($subscription->offer->url);
            }
        }
        return $next($request);
    }
}
