<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferSubscription extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'follower_id',
    ];
    
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }

    public function follower()
    {
        return $this->belongsTo(Webmaster::class, 'webmaster_id', 'id');
    }
}
