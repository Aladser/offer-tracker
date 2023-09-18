<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertiserProduct extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id', 'id');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }

    public function links()
    {
        return $this->hasMany(OfferClick::class, 'advertiser_product_id', 'id');
    }
}
