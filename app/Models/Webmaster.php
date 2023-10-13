<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webmaster extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(OfferSubscription::class, 'webmaster_id', 'id');
    }
}
