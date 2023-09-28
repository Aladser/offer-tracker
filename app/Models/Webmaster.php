<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Interfaces\OfferTotalValueInterface;

class Webmaster extends Model implements OfferTotalValueInterface
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(OfferSubscription::class, 'follower_id', 'id');
    }

    public function offerClickCount($timePeriod = null) {
        
    }

    public function offerMoney($timePeriod = null) {

    }
}
