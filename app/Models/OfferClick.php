<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferClick extends Model
{
    public $timestamps = false;

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }
}
