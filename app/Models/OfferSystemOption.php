<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferSystemOption extends Model
{
    public $timestamps = false;

    public static function commission()
    {
        return OfferSystemOption::where('name', 'commission')->value('value');
    }
}
