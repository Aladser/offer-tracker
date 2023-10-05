<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Advertiser;
use App\Models\Offer;
use App\Models\OfferSubscription;
use App\Models\OfferTheme;

class OfferController extends Controller
{
    /** Показать форму создания нового оффера */
    public function create()
    {
        return view('pages/add-offer', ['themes' => OfferTheme::all()]);
    }

    /** Сохраните вновь созданный ресурс в хранилище */
    public function store(Request $request)
    {
        $data = $request->all();
        // поиск имени
        if ($this->hasOffer($data['name'])) {
            return ['result' => 0, 'error' => 'Название оффера уже занято'];
        } else {
            // поиск рекламщика
            $advertiserId = $this->findAdvertiser($data['user']); 
            if (!$advertiserId) {
                return ['result' => 0, 'error' => "Пользователь {$data['user']} не существует"];
            } else {
                return ['result' => $this->add($data, $advertiserId), 'offerName' => $data['name']];
            }
        }
    }


    private function add($data, $advertiserId)
    {
        $offer = new Offer();
        $offer->name = $data['name'];
        $offer->URL = $data['url'];
        $offer->price = $data['price'];
        $offer->theme_id = OfferTheme::where('name', $data['theme'])->first()->id;
        $offer->advertiser_id = $advertiserId;
        
        return $offer->save() ? 1 : 0;
    }
    
    public function destroy($id)
    {
        return ['result' => Offer::find($id)->delete() ? 1 : 0];
    }

    /** установить статус */
    public function status(Request $request)
    {
        $status = $request->all()['status']; 
        $id = $request->all()['id'];
        $offer = Offer::find($id);
        $offer->status = $status === 'true' ? 1 : 0;
        return $offer->save();
    }

    /** подписка на оффер */
    public function subscribe(Request $request)
    {
        $offerId = $request->all()['offerId'];
        $webmasterId = $request->user()->webmaster->id;

        $offerSubscription = new OfferSubscription();
        $offerSubscription->offer_id = $offerId;
        $offerSubscription->webmaster_id = $webmasterId;
        $offerSubscription->refcode = "$webmasterId@$offerId";
        $rslt = $offerSubscription->save();
        return ['result' => $rslt ? $offerSubscription->refcode : 0];
    }

    /** отписка от оффера */
    public function unsubscribe(Request $request)
    {
        $offerId = $request->all()['offerId'];
        $webmasterId = $request->user()->webmaster->id;
        $rslt = OfferSubscription::where('webmaster_id', $webmasterId)->where('offer_id', $offerId)->delete();
        return ['result' => $rslt];
    }

    /** поиск рекламодателя по имени */
    private function findAdvertiser($name)
    {
        $user = User::where('name', $name);
        return !is_null($user) ? User::where('name', $name)->first()->value('id') : false;
    }

    /** поиск оффера по имени  */
    private function hasOffer($name)
    {
        return !is_null(Offer::where('name', $name)->first());
    }
}
