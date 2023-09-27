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
        if (Offer::hasOffer($data['name'])) {
            return ['result' => 0, 'error' => 'Название оффера уже занято'];
        } else {
            // поиск рекламщика
            $advertiserId = Advertiser::findAdvertiser($data['user']); 
            if (is_null($advertiserId)) {
                return ['result' => 0, 'error' => "Пользователь {$data['user']} не существует"];
            } else {
                return ['result' => Offer::add($data, $advertiserId), 'offerName' => $data['name']];
            }
        }
    }

    public function edit($id)
    {
        return 'edit';
    }

    public function update(Request $request, $id)
    {
        return 'update';
    }

    public function destroy($id)
    {
        return ['response' => Offer::remove($id) ? 1 : 0];
    }

    /** установить статус */
    public function status(Request $request)
    {
        $status = $request->all()['status']; 
        $id = $request->all()['id'];
        return Offer::setStatus($id, $status);
    }

    /** подписка на оффер */
    public function subscribe(Request $request)
    {
        $id = $request->all()['offerId'];
        $user = $request->user()->id;
        return ['result' => Offer::subscribe($id, $user)];
    }

    /** отписка от оффера */
    public function unsubscribe(Request $request)
    {
        $id = $request->all()['offerId'];
        $user = $request->user()->id;
        return ['result' => Offer::unsubscribe($id, $user)];
    }
}
