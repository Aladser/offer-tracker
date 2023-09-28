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

    /** подписки */
    public function links()
    {
        return $this->hasMany(OfferSubscription::class, 'offer_id', 'id');
    }

    /** переходы */
    public function clicks()
    {
        return $this->hasMany(OfferClick::class, 'offer_id', 'id');
    }

    /** число переходов новее текущей даты */
    public function linkCount($timePeriod = null)
    {
        if (is_null($timePeriod)) {
            return $this->links->count();
        } else {
            return $this->links->where('created_at', '>', $timePeriod)->count();
        }
    }

    /** число переходов новее текущей даты */
    public function money($timePeriod = null)
    {
        if (is_null($timePeriod)) {
            return $this->links->count() * $this->price;
        } else {
            return $this->links->where('created_at', '>', $timePeriod)->count() * $this->price;
        }
    }

    /** показать активные подписки */
    public static function getActiveOffers()
    {
        return Offer::where('status', 1)->get();
    }

    /** показать активные подписки без подписок конкретного пользователя */
    public static function getActiveOffersExceptUserSubscriptions($userId)
    {
        $subscrOffers = OfferSubscription::where('follower_id', $userId)->select('offer_id');
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

    public static function subscribe($offerId, $userId)
    {
        $offerSubscription = new OfferSubscription();
        $offerSubscription->follower_id = $userId;
        $offerSubscription->offer_id = $offerId;
        $rslt = $offerSubscription->save();
        return $rslt ? 1 : 0;
    }

    public static function unsubscribe($offerId, $userId)
    {
        $rslt = OfferSubscription::where('follower_id', $userId)->where('offer_id', $offerId)->delete();
        return $rslt;
    }
}
