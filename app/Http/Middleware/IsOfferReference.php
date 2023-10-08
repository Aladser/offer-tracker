<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\OfferClickController;
use App\Http\Controllers\FailedOfferClickController;
use App\Http\Controllers\SystemOptionController;
use App\Models\OfferSubscription;
use App\Services\WebsocketService;

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
            
            // поиск записи с данным реф.кодом
            $subscription = OfferSubscription::where('refcode', $refCode)->first();
            
            if (is_null($subscription)) {
                // лог
                Log::stack(['slack', $logChannel])->info("переход по ссылке {$request->path()}?ref=$refCode завершился с ошибкой");
                // записать факт отказа реферальной ссылки в БД
                FailedOfferClickController::add("{$request->path()}?ref=$refCode");
                // сообщение вебсокету
                WebsocketService::send(['type' => 'FAILED_OFFER',]);

                return redirect('page404');
            } else {
                $webmasterId = $subscription->follower->id;
                $webmaster = $subscription->follower->user->name;
                $advertiser = $subscription->offer->advertiser->user->name; 
                $offer = $subscription->offer->id;
                $offerPrice = $subscription->offer->price;
                $commission = SystemOptionController::commission();
                $income_part = (100 - $commission) / 100;

                // записать факт перенаправления в БД
                OfferClickController::add($webmasterId, $offer);
                // лог
                Log::stack(['slack', $logChannel])->info("переход по ссылке {$request->path()}?ref=$refCode успешен");
                // сообщение вебсокету
                WebsocketService::send([
                    'type' => 'CLICK',
                    'advertiser' => $advertiser,
                    'webmaster' => $webmaster,
                    'offer' => $offer,
                    'price' => $offerPrice,
                    'income_part' => $income_part
                ]);

                return redirect($subscription->offer->url);
            }
        }
        
        return $next($request);
    }
}
