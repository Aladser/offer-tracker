<?php

namespace App\Services;

use App\Models\OfferSubscription;
use Illuminate\Http\Request;

/** Управление подписками веб-мастеров на офферы */
class SubscriptionService
{
    /** принимает запросы от клиентов */
    public function index(Request $request)
    {
        $offer = $request->all()['id'];
        $webmaster = $request->user()->webmaster->id;
        if ($request->all()['status'] == 1) {
            return $this->subscribe($offer, $webmaster);
        } else {
            return $this->unsubscribe($offer, $webmaster);
        }
    }

    /** подписаться на оффер */
    private function subscribe($offerId, $webmasterId)
    {
        $offerSubscription = new OfferSubscription();
        $offerSubscription->offer_id = $offerId;
        $offerSubscription->webmaster_id = $webmasterId;
        $offerSubscription->refcode = "$webmasterId@$offerId";
        $isSubscribed = $offerSubscription->save();

        if ($isSubscribed) {
            $advertiserName = $offerSubscription->offer->advertiser->user->name;
            $offer = $offerSubscription->offer;

            $data = [
                'type' => 'SUBSCRIBE',
                'advertiser' => $advertiserName,
                'offer_id' => $offer->id,
                'offer_name' => $offer->name,
                'offer_webmaster' => $offerSubscription->follower->user->name,
                'offer_theme' => $offer->theme->name,
                'offer_url' => $offer->url,
                'offer_refcode' => $offerSubscription->refcode,
            ];
            WebsocketService::send($data);

            return ['result' => $offerSubscription->refcode, 'advertiser' => $advertiserName, 'offer' => $offer];
        } else {
            return ['result' => 0];
        }
    }

    /** отписаться от оффера */
    private function unsubscribe($offerId, $webmasterId)
    {
        $offerSubscription = OfferSubscription::where('webmaster_id', $webmasterId)
            ->where('offer_id', $offerId)->first();
        $advertiserName = $offerSubscription->offer->advertiser->user->name;
        $offer = $offerSubscription->offer;
        $webmaster = $offerSubscription->follower;

        $isUnsubscribed = $offerSubscription->delete();

        if ($isUnsubscribed) {
            $data = [
                'type' => 'UNSUBSCRIBE',
                'advertiser' => $advertiserName,
                'webmaster' => $webmaster->user->name,
                'offer_id' => $offer->id,
            ];
            WebsocketService::send($data);

            return ['result' => 1, 'advertiser' => $advertiserName, 'offer' => $offer->id];
        } else {
            return ['result' => 0];
        }
    }
}
