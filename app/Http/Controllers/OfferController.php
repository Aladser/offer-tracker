<?php

namespace App\Http\Controllers;

use App\Models\Advertiser;
use App\Models\Offer;
use App\Models\OfferTheme;
use App\Services\WebsocketService;
use Illuminate\Http\Request;

/** контроллер офферов */
class OfferController extends Controller
{
    // Показывает форму создания нового оффера
    public function create()
    {
        return view('pages/add-offer', ['themes' => OfferTheme::all()]);
    }

    // Сохраняет оффер в БД (post-запрос)
    public function store(Request $request)
    {
        $data = $request->all();
        // поиск имени оффера
        if (Offer::where('name', $data['name'])->exists()) {
            return ['result' => 0, 'error' => 'Название оффера уже занято'];
        } else {
            // поиск рекламодателя
            $extendedAdvertisers = Advertiser::join('users', 'users.id', '=', 'advertisers.user_id');
            $advertiserObj = $extendedAdvertisers->where('name', $data['user']);
            if ($advertiserObj->exists()) {
                // добавление оффера
                return [
                    'result' => $this->add($data, $advertiserObj->first()->value('id')),
                    'offerName' => $data['name'],
                ];
            } else {
                return ['result' => 0, 'error' => "Пользователь {$data['user']} не существует"];
            }
        }
    }

    // добавляет оффер в БД
    private function add($data, $advertiserId)
    {
        $offer = new Offer();
        $offer->name = $data['name'];

        $url = $data['url'];
        if (mb_stripos($url, '?')) {
            $url = mb_substr($url, 0, mb_stripos($url, '?'));
        }
        $offer->URL = $url;

        $offer->price = $data['price'];
        $offer->theme_id = OfferTheme::where('name', $data['theme'])->first()->id;
        $offer->advertiser_id = $advertiserId;

        if ($offer->save()) {
            // отправка в вебсокет информации о новом оффере
            $commission = round((100 - SystemOptionController::commission()) / 100, 2);
            $offerData = [
                'type' => 'NEW_OFFER',
                'offer_name' => $offer->name,
                'offer_income' => $offer->price * $commission,
                'offer_theme' => $offer->theme->name,
                'offer_id' => $offer->id,
            ];
            WebsocketService::send($offerData);

            return 1;
        } else {
            return 0;
        }
    }

    // удаляет оффер из БД
    public function destroy($id)
    {
        if (Offer::find($id)->delete()) {
            // отправка сообщения вебсокету об удаленном оффере
            WebsocketService::send(['type' => 'DELETE_OFFER', 'id' => $id]);

            return ['result' => 1];
        } else {
            return ['result' => 0];
        }
    }

    // установить статус
    public function status(Request $request)
    {
        $id = $request->all()['id'];
        $offer = Offer::find($id);
        $offer->status = $request->all()['status'];
        $isChanged = $offer->save();

        // сообщение вебсокету
        if ($isChanged) {
            // включается оффер. Он видим вебмастерами
            if ($offer->status == 1) {
                // список подписчиков оффера. Среди них клиент будет искать себя
                $subscriptions = $offer->links;
                $webmasters = [];
                foreach ($subscriptions as $subscription) {
                    $webmasters[] = [
                        'name' => $subscription->follower->user->name,
                        'refcode' => $subscription->refcode,
                    ];
                }
                // отправка в вебсокет нового видимого оффера
                $commission = round((100 - SystemOptionController::commission()) / 100, 2);
                $offerData = [
                    'type' => 'VISIBLE_OFFER',
                    'offer_name' => $offer->name,
                    'offer_income' => round($offer->price * $commission, 2),
                    'offer_theme' => $offer->theme->name,
                    'offer_id' => $offer->id,
                    'offer_url' => $offer->url,
                    'webmasters' => $webmasters,
                ];
                WebsocketService::send($offerData);
            } else {
                // отправка в вебсокет информации о скрытии оффера
                WebsocketService::send(['type' => 'UNVISIBLE_OFFER', 'id' => $id]);
            }
        }

        return ['result' => $isChanged];
    }
}
