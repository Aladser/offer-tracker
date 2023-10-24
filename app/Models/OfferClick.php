<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// переход по ссылке
class OfferClick extends Model
{
    public $timestamps = false;

    // оффер
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }

    // подписка
    public function subscription()
    {
        return $this->belongsTo(OfferSubscription::class, 'webmaster_id', 'id');
    }

    // вебмастер
    public function webmaster()
    {
        return $this->belongsTo(Webmaster::class, 'webmaster_id', 'id');
    }
}
