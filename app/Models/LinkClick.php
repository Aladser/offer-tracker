<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkClick extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function advertiser()
    {
        return $this->belongsTo(AdvertiserProduct::class, 'advertiser_product_id', 'id');
    }
}
