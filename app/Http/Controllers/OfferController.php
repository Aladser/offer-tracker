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

    /** Сохранить оффер в БД 
     * Для простоты реалзиации кода реализую через собственный класс запросов в БД, так как через бродкаст нужно много настраивать
    */
    public function store($data)
    {
        $isOffer = $this->dbQuery->query("select * from offers where name = '$data->name'");
        // поиск имени оффера
        if ($isOffer) {
            $description = "$data->name: название оффера уже занято";
            WebsocketService::send([
                'type' => 'ADDED_NEW_OFFER', 
                'result' => 0, 
                'description' => $description
            ]);
            return $description;
        } else {
            $advertiser = $this->dbQuery->query(
                "select advertisers.id as id from advertisers join users on advertisers.user_id = users.id where name = '$data->advertiser'"
            );
            // добавление оффера, если существует рекламодатель
            if ($advertiser) {
                $url = $data->url;
                if (mb_stripos($url, '?')) {
                    $url = mb_substr($url, 0, mb_stripos($url, '?'));
                }
                $advertiserId = $advertiser['id'];
                $theme = $this->dbQuery->queryPrepared('select id from offer_themes where name = :name', ['name' => $data->theme]);
                $themeId = $theme['id']; 
                $sql = "insert into offers(name, URL, price, theme_id, advertiser_id) values('$data->name', '$url', $data->price, $themeId, $advertiserId)";
                $isAdded = $this->dbQuery->exec($sql) == 1;

                if ($isAdded) {
                    // отправка в вебсокет информации о новом оффере
                    $commission = intval($this->dbQuery->query('select value from system_options where name=\'commission\'')['value']);
                    $commission = round((100 - $commission) / 100, 2);
                    $offerId = $this->dbQuery->query("select id from offers where name = '$data->name'")['id'];

                    $offerData = [
                        'type' => 'NEW_OFFER',
                        'offer_name' => $data->name,
                        'offer_income' => $data->price * $commission,
                        'offer_theme' => $data->theme,
                        'offer_id' => $offerId,
                    ];
                    WebsocketService::send($offerData);
                    WebsocketService::send([
                        'type'=>'ADDED_NEW_OFFER', 
                        'result'=>1, 
                        'offer_name'=>$data->name
                    ]);
                    return "оффер $data->name добавлен";
                } else {
                    $description = "Серверная ошибка добавления оффера";
                    WebsocketService::send([
                        'type'=>'ADDED_NEW_OFFER', 
                        'result'=>0, 
                        'description'=>$description
                    ]);
                    return $description;
                }
            } else {
                $description = "Рекламодатель $data->advertiser не существует";
                WebsocketService::send([
                    'type' => 'ADDED_NEW_OFFER', 
                    'result' => 0, 
                    'description' => $description
                ]);
                return $description;
            }
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
