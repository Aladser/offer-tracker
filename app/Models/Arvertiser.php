<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arvertiser extends Model
{
    use HasFactory;
    public $timestamps = false;

    /** офферы */
    public function offers()
    {
        return $this->hasMany(Offer::class, 'advertiser_id', 'id');
    }

    /** обще число подписок на офферы */
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
