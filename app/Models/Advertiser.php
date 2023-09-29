<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Advertiser extends Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'advertiser_id', 'id');
    }

    public static function findAdvertiser($name)
    {
        $user = User::where('name', $name);
        return !is_null($user) ? User::where('name', $name)->first()->value('id') : false;
    }
}
