<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// вебмастер
class Webmaster extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
    ];

    // пользователь
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // подписки
    public function subscriptions()
    {
        return $this->hasMany(OfferSubscription::class, 'webmaster_id', 'id');
    }
}
