<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    /** тема оффера */
    public function theme()
    {
        return $this->belongsTo(OfferTheme::class, 'theme_id', 'id');
    }

    /** создатель оффера */
    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id', 'id');
    }

    /** подписки */
    public function links()
    {
        return $this->hasMany(OfferSubscription::class, 'offer_id', 'id');
    }

    public static function getOfferName($name)
    {
        return Offer::where('name', $name)->first();
    }

    public static function add($data, $userId)
    {
        $offer = new Offer();
        $offer->name = $data['name'];
        $offer->URL = $data['url'];
        $offer->price = $data['price'];
        $offer->theme_id = OfferTheme::where('name', $data['theme'])->first()->id;
        $offer->advertiser_id = $userId;
        
        return $offer->save() ? 1 : 0;
    }

    public static function remove($id)
    {
        return Offer::find($id)->delete();
    }

    public static function setStatus($id, $status)
    {   
        $offer = Offer::find($id);
        $offer->status = $status === 'true' ? 1 : 0;
        return $offer->save();
    }
}
