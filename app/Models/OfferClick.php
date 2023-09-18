<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferClick extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(AdvertiserProduct::class, 'advertiser_product_id', 'id');
    }

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id', 'id');
    }
}
