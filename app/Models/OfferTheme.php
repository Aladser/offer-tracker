<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// тема оффера
class OfferTheme extends Model
{
    use HasFactory;
    public $timestamps = false;

    // офферы
    public function offers()
    {
        return $this->hasMany(Offer::class, 'theme_id', 'id');
    }
}
