<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\OfferSubscription;
use App\Events\WebmasterSigned;
use App\Events\WebmasterUnsigned;

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
            WebmasterSigned::dispatch($offerSubscription); // событие подписки
            
            return ['result' => $offerSubscription->refcode];
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

        $subscriptionId = $offerSubscription->id;
        $webmaster = $offerSubscription->follower;
        $offer = $offerSubscription->offer;

        $isUnsubscribed = $offerSubscription->delete();

        if ($isUnsubscribed) {
            WebmasterUnsigned::dispatch($subscriptionId, $webmaster, $offer); // событие отписки
        } 

        return ['result' => $isUnsubscribed];
    }
}