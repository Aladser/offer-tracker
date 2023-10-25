<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// рекламодатель
class Advertiser extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
    ];

    // данные пользователя
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // офферы
    public function offers()
    {
        return $this->hasMany(Offer::class, 'advertiser_id', 'id');
    }
}
