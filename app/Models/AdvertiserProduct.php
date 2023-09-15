<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertiserProduct extends Model
{
    use HasFactory;
    public $timestamps = false;

    /** рекламодатель */
    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id', 'id');
    }

    /* оффер */
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }

    /** клики товара рекламшика */
    public function clicks()
    {
        return $this->hasMany(LinkClick::class, 'advertiser_product_id', 'id');
    }
}
