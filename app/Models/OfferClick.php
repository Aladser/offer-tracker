<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferClick extends Model
{
    public $timestamps = false;

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }

    public function subscription()
    {
        return $this->belongsTo(OfferSubscription::class, 'webmaster_id', 'id');
    }

    public function webmaster()
    {
        return $this->belongsTo(Webmaster::class, 'webmaster_id', 'id');
    }
}
