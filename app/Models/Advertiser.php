<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Interfaces\OfferTotalValueInterface;

class Advertiser extends Model implements OfferTotalValueInterface
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** офферы */
    public function offers()
    {
        return $this->hasMany(Offer::class, 'advertiser_id', 'id');
    }

    public function offerSubscriptionCount($timePeriod = null) {
        $totalOffers = 0;
        foreach ($this->offers->all() as $offer) {
            $totalOffers += $offer->clickCount($timePeriod);
        }
        return $totalOffers;
    }

    public function offerMoney($timePeriod = null) {
        $totalIncome = 0;
        foreach ($this->offers->all() as $offer) {
            $totalIncome += $offer->clickCount($timePeriod) * $offer->price;
        }
        return $totalIncome;
    }

    /** используется в контроллере */
    public static function findAdvertiser($name)
    {
        $table = DB::table('advertisers')->join('users', 'users.id', '=', 'advertisers.user_id');
        return $table->where('name', $name)->first()->id;
    }
}
