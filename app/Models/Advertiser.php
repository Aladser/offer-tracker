<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Advertiser extends Model
{
    use HasFactory;
    public $timestamps = false;

    public static function findAdvertiser($name)
    {
        $table = DB::table('advertisers')->join('users', 'users.id', '=', 'advertisers.user_id');
        return $table->where('name', $name)->first()->id;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** офферы */
    public function offers()
    {
        return $this->hasMany(Offer::class, 'advertiser_id', 'id');
    }

    /** общеt число подписок на офферы */
    public function offerSubscriptionCount($timePeriod = null) {
        $totalOffers = 0;
        foreach ($this->offers->all() as $offer) {
            $totalOffers += $offer->linkCount($timePeriod);
        }
        return $totalOffers;
    }

    /** доход от подписок */
    public function offerIncome($timePeriod = null) {
        $totalIncome = 0;
        foreach ($this->offers->all() as $offer) {
            $totalIncome += $offer->linkCount($timePeriod) * $offer->price;
        }
        return $totalIncome;
    }
}
