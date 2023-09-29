<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    /** тема оффера */
    public function theme()
    {
        return $this->belongsTo(OfferTheme::class, 'theme_id', 'id');
    }

    /** создатель оффера */
    public function advertiser()
    {
        return $this->belongsTo(Advertiser::class, 'advertiser_id', 'id');
    }

    /** подписано вебмастеров */
    public function links()
    {
        return $this->hasMany(OfferSubscription::class, 'offer_id', 'id');
    }

    /** переходы посетителей */
    public function clicks()
    {
        return $this->hasMany(OfferClick::class, 'offer_id', 'id');
    }
    
    /** показать активные подписки */
    public static function getActiveOffers()
    {
        return Offer::where('status', 1)->get();
    }

    /** показать активные подписки без подписок конкретного пользователя */
    public static function getActiveOffersExceptUserSubscriptions($webmasterId)
    {
        $subscrOffers = OfferSubscription::where('webmaster_id', $webmasterId)->select('offer_id');
        $activeOffers = Offer::where('status', 1)->whereNotIn('id', $subscrOffers);
        return $activeOffers;
    }

    public static function hasOffer($name)
    {
        return !is_null(Offer::where('name', $name)->first());
    }

    public static function add($data, $advertiserId)
    {
        $offer = new Offer();
        $offer->name = $data['name'];
        $offer->URL = $data['url'];
        $offer->price = $data['price'];
        $offer->theme_id = OfferTheme::where('name', $data['theme'])->first()->id;
        $offer->advertiser_id = $advertiserId;
        
        return $offer->save() ? 1 : 0;
    }

    public static function remove($id)
    {
        return Offer::find($id)->delete();
    }

    /** установить активность */
    public static function setStatus($id, $status)
    {   
        $offer = Offer::find($id);
        $offer->status = $status === 'true' ? 1 : 0;
        return $offer->save();
    }

    /** подписаться на оффер */
    public static function subscribe($offerId, $webmasterId)
    {
        $offerSubscription = new OfferSubscription();
        $offerSubscription->offer_id = $offerId;
        $offerSubscription->webmaster_id = $webmasterId;
        $offerSubscription->refcode = "$webmasterId@$offerId";
        $rslt = $offerSubscription->save();
        return $rslt ? $offerSubscription->refcode : 0;
    }

    /** отписаться от оффера */
    public static function unsubscribe($offerId, $webmasterId)
    {
        $rslt = OfferSubscription::where('webmaster_id', $webmasterId)->where('offer_id', $offerId)->delete();
        return $rslt;
    }
}
