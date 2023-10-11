<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertiser;
use App\Models\Offer;
use App\Models\OfferTheme;
use App\Services\WebsocketService;

class OfferController extends Controller
{
    /** Показать форму создания нового оффера */
    public function create()
    {
        return view('pages/add-offer', ['themes' => OfferTheme::all()]);
    }

    /** Сохраните оффер в БД */
    public function store(Request $request)
    {
        $data = $request->all();
        // поиск имени оффера
        if (Offer::where('name', $data['name'])->exists()) {
            return ['result' => 0, 'error' => 'Название оффера уже занято'];
        } else {
            // поиск рекламодателя
            $extendedAdvertisers = Advertiser::join('users', 'users.id','=','advertisers.user_id');
            $advertiserObj = $extendedAdvertisers->where('name', $data['user']);
            if ($advertiserObj->exists()) {
                // добавление оффера
                return ['result' => $this->add($data, $advertiserObj->first()->value('id')), 'offerName' => $data['name']];
            } else {
                return ['result' => 0, 'error' => "Пользователь {$data['user']} не существует"];
            }
        }
    }

    private function add($data, $advertiserId)
    {
        $offer = new Offer();
        $offer->name = $data['name'];
        $url = $data['url'];
        if (mb_stripos($url, '?')) {
            $url = mb_substr($url, 0, mb_stripos($url, '?'));
        }
        $offer->URL =  $url;
        $offer->price = $data['price'];
        $offer->theme_id = OfferTheme::where('name', $data['theme'])->first()->id;
        $offer->advertiser_id = $advertiserId;

        $iAdded = $offer->save();
        if ($iAdded) {
            // отправка в вебсокет информации о новом оффере
            $commission = round(((100 - SystemOptionController::commission()) / 100), 2);
            $offerData = [
                'type' => 'NEW_OFFER',
                'offer_name' => $offer->name,
                'offer_income' => $offer->price*$commission,
                'offer_theme' => $offer->theme->name,
                'offer_id' => $offer->id,
            ];
            WebsocketService::send($offerData);

            return 1;
        }  else {
            return 0;
        }
    }
    
    public function destroy($id)
    {
        if (Offer::find($id)->delete()) {
            // отправка сообщения вебсокету об удаленном оффере 
            WebsocketService::send(['type'=>'DELETE_OFFER', 'id' => $id]);

            return ['result' => 1];
        } else {
            return ['result' => 0];
        }
    }

    /** установить статус */
    public function status(Request $request)
    {
        $status = $request->all()['status'];
        $id = $request->all()['id'];
        $offer = Offer::find($id);
        $offer->status = $status === 'true' ? 1 : 0;
        $isChanged = $offer->save();
        
        // сообщение вебсокету
        if ($isChanged) {
            if ($offer->status === 1) {
                $this->sendWebsocketMessage($offer);
            } else {
                WebsocketService::send(['type'=>'DELETE_OFFER', 'id' => $id]);
            }
        }

        return $isChanged;
    }

    private function sendWebsocketMessage($offer)
    {
        // список подписчиков оффера 
        $subscriptions = $offer->links;
        $webmasters = [];
        foreach ($subscriptions as $subscription) {
            $webmasters[] = [
                'name'=>$subscription->follower->user->name, 
                'refcode'=>$subscription->refcode
            ];
        }
        // отправка в вебсокет информации о новом оффере
        $commission = round(((100 - SystemOptionController::commission()) / 100), 2);
        $offerData = [
            'type' => 'NEW_OFFER',
            'offer_name' => $offer->name,
            'offer_income' => $offer->price*$commission,
            'offer_theme' => $offer->theme->name,
            'offer_id' => $offer->id,
            'offer_url' => $offer->url,
            'webmasters' => $webmasters,
        ];
        WebsocketService::send($offerData);
    }
}
