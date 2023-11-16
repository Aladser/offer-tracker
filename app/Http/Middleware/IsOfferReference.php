<?php

namespace App\Http\Middleware;

use App\Http\Controllers\FailedOfferClickController;
use App\Http\Controllers\OfferClickController;
use App\Http\Controllers\SystemOptionController;
use App\Models\OfferSubscription;
use App\Services\WebsocketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/** ищет реферальную ссылку в URL главной страницы */
class IsOfferReference
{
    public function handle(Request $request, \Closure $next)
    {
        $params = $request->all();

        if (array_key_exists('ref', $params)) {
            // записывает лог
            $logChannel = Log::build([
                'driver' => 'single',
                'path' => storage_path('logs/offer_click.log'),
              ]);
            // рефкод ссылки
            $refCode = $params['ref'];

            // поиск записи с данным реф.кодом
            $subscription = OfferSubscription::where('refcode', $refCode);

            if (!$subscription->exists()) {
                // лог
                Log::stack(['slack', $logChannel])
                    ->info("переход по ссылке {$request->path()}?ref=$refCode завершился с ошибкой");
                // записать факт отказа реферальной ссылки в БД
                FailedOfferClickController::add("{$request->path()}?ref=$refCode");
                // сообщение вебсокету
                WebsocketService::send(['type' => 'FAILED_OFFER']);

                return redirect('page404');
            } else {
                // данные перехода
                $subscription = $subscription->first();
                // id веб-мастера
                $webmasterId = $subscription->follower->id;
                // имя вебмастера-подписчика
                $webmaster = $subscription->follower->user->name;
                // имя рекламодателя-создателя
                $advertiser = $subscription->offer->advertiser->user->name;
                // id оффера
                $offer = $subscription->offer->id;
                // цена оффера
                $offerPrice = $subscription->offer->price;
                // комиссия системы
                $commission = SystemOptionController::commission();
                // доля стоииости веб-мастера от цены оффера
                $income_part = (100 - $commission) / 100;
                // записать факт перенаправления в БД
                OfferClickController::add($webmasterId, $offer);
                // лог
                Log::stack(['slack', $logChannel])->info("переход по ссылке {$request->path()}?ref=$refCode успешен");
                // сообщение вебсокету о переходе
                WebsocketService::send([
                    'type' => 'CLICK',
                    'advertiser' => $advertiser,
                    'webmaster' => $webmaster,
                    'offer' => $offer,
                    'price' => $offerPrice,
                    'income_part' => $income_part,
                ]);

                // переход по ссылке рекламодателя
                return redirect($subscription->offer->url);
            }
        }

        return $next($request);
    }
}
