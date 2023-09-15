<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferTheme extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function offers()
    {
        return $this->hasMany(Offer::class, 'theme', 'id');
    }
}
