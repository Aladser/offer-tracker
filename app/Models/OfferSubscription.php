<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// подписчик
class OfferSubscription extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'follower_id',
    ];

    // оффер
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }

    // вебмастер
    public function follower()
    {
        return $this->belongsTo(Webmaster::class, 'webmaster_id', 'id');
    }

    /** переходы */
    public function clicks()
    {
        return $this->hasMany(OfferClick::class, 'offer_id', 'offer_id');
    }
}
