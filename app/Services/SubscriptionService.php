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
            // событие подписки
            WebmasterSigned::dispatch($offerSubscription);
            
            return ['result' => $offerSubscription->refcode];
        } else {
            return ['result' => 0];
        }
    }

    /** отписка от оффера */
    public function unsubscribe(Request $request)
    {
        $offerId = $request->all()['offerId'];
        $webmasterId = $request->user()->webmaster->id;
        $offerSubscription = OfferSubscription::where('webmaster_id', $webmasterId)->where('offer_id', $offerId)->first();
        $id = $offerSubscription->id;
        $isUnsubscribed = $offerSubscription->delete();

        // событие отписки
        if ($isUnsubscribed) {
            WebmasterUnsigned::dispatch($id);
        } 

        return ['result' => $isUnsubscribed];
    }
}