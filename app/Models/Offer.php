<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    public $timestamps = false;

    /** тема оффера */
    public function role()
    {
        return $this->belongsTo(OfferTheme::class, 'theme_id', 'id');
    }
}
