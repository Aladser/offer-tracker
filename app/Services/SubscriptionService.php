<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\OfferSubscription;

class SubscriptionService
{
    /** подписка на оффер */
    public function subscribe(Request $request)
    {
        $offerId = $request->all()['offerId'];
        $webmasterId = $request->user()->webmaster->id;

        $offerSubscription = new OfferSubscription();
        $offerSubscription->offer_id = $offerId;
        $offerSubscription->webmaster_id = $webmasterId;
        $offerSubscription->refcode = "$webmasterId@$offerId";
        $isSubscribed = $offerSubscription->save();

        if($isSubscribed) {
            $advertiserName = $offerSubscription->offer->advertiser->user->name;
            $offer = $offerSubscription->offer->id;

            \Ratchet\Client\connect(env('WEBSOCKET_ADDR'))->then(function($conn) use ($advertiserName, $offer) {
                $conn->send(json_encode(['type' => 'SUBSCRIBE', 'advertiser' => $advertiserName, 'offer' => $offer]));
                $conn->close();
            });
            
            return ['result' => $offerSubscription->refcode, 'advertiser' => $advertiserName, 'offer' => $offer];
        } else {
            return ['result' => 0];
        }
    }

    /** отписка от оффера */
    public function unsubscribe(Request $request)
    {
        $webmasterId = $request->user()->webmaster->id;
        $offerId = $request->all()['offerId'];
        $offerSubscription = OfferSubscription::where('webmaster_id', $webmasterId)->where('offer_id', $offerId)->first();

        $advertiserName = $offerSubscription->offer->advertiser->user->name;
        $offer = $offerSubscription->offer->id;
        $isUnsubscribed = $offerSubscription->delete();

        if ($isUnsubscribed) {
            \Ratchet\Client\connect(env('WEBSOCKET_ADDR'))->then(function($conn) use ($advertiserName, $offer) {
                $conn->send(json_encode(['type' => 'UNSUBSCRIBE', 'advertiser' => $advertiserName, 'offer' => $offer]));
                $conn->close();
            });

            return ['result' => 1, 'advertiser' => $advertiserName, 'offer' => $offer];
        } else {
            return ['result' => 0];
        }
    }
}