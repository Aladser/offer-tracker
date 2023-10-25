<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ошибочный переходов по реферальной ссылке
class FailedOfferClick extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'url',
    ];
}
