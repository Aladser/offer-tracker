<?php

namespace App\Http\Controllers;

use App\Models\Advertiser;
use App\Models\Offer;
use App\Models\OfferTheme;
use App\Services\WebsocketService;
use Illuminate\Http\Request;
use App\DBQueryClass;

class OfferController extends Controller
{
    private $dbQuery;

    public function __construct(Type $var = null) {
        $this->dbQuery = new DBQueryClass(env('DB_HOST'), env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'));
    }

    /** Показать форму создания нового оффера */
    public function create()
    {
        return view('pages/add-offer', ['themes' => OfferTheme::all()]);
    }

    /** Сохраните оффер в БД 
     * Для простоты реалзиации кода реализую через собственный класс запросов в БД, так как через бродкаст нужно много настраивать
    */
    public function store($data)
    {
        $isOffer = $this->dbQuery->queryPrepared('select * from offers where name = :name', ['name' => $data->name]);
        // поиск имени оффера
        if ($isOffer) {
            return ['result' => 0, 'error' => 'Название оффера уже занято'];
        } else {
            $advertiser = $this->dbQuery->queryPrepared(
                'select advertisers.id as id from advertisers join users on advertisers.user_id = users.id where name = :name',
                ['name' => $data->user]
            );
            // добавление оффера, если существует рекламодатель
            if ($advertiser) {
                $url = $data['url'];
                if (mb_stripos($url, '?')) {
                    $url = mb_substr($url, 0, mb_stripos($url, '?'));
                }
                $advertiserId = 

                return [
                    'result' => 
                        $this->dbQuery->executeProcedure("insert into offers(name, URL, price, theme_id, advertiser_id) ".
                        "values($data->name, $url, $data->price, $theme_id)"),
                    'offerName' => $data->name,
                ];
            } else {
                return ['result' => 0, 'error' => "Рекламодатель $data->user не существует"];
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
        $offer->URL = $url;
        $offer->price = $data['price'];
        $offer->theme_id = OfferTheme::where('name', $data['theme'])->first()->id;
        $offer->advertiser_id = $advertiserId;

        $iAdded = $offer->save();
        if ($iAdded) {
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

    /** установить статус */
    public function status(Request $request)
    {
        $id = $request->all()['id'];
        $offer = Offer::find($id);
        $offer->status = $request->all()['status'];
        $isChanged = $offer->save();

        // сообщение вебсокету
        if ($isChanged) {
            if ($offer->status == 1) {
                // список подписчиков оффера
                $subscriptions = $offer->links;
                $webmasters = [];
                foreach ($subscriptions as $subscription) {
                    $webmasters[] = [
                        'name' => $subscription->follower->user->name,
                        'refcode' => $subscription->refcode,
                    ];
                }
                // отправка в вебсокет информации о новом оффере
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
                WebsocketService::send(['type' => 'UNVISIBLE_OFFER', 'id' => $id]);
            }
        }

        return ['result' => $isChanged];
    }
}
