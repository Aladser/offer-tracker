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

    public function advertiser()
    {
        return $this->belongsTo(User::class, 'advertiser_id', 'id');
    }

    public function links()
    {
        return $this->hasMany(OfferSubscription::class, 'offer_id', 'id');
    }

    public static function add($data)
    {
        // поиск товара
        $isOffer = !is_null(Offer::where('name', $data['name'])->first());
        if ($isOffer) {
            return ['result' => 0, 'error' => 'оффер уже существует'];
        } else {
            $isURL = !is_null(Offer::where('URL', $data['url'])->first());
            if ($isURL) {
                return ['result' => 0, 'error' => 'URL занят'];
            } else {
                $offer = new Offer();
                $offer->name = $data['name'];
                $offer->theme_id = OfferTheme::where('name', $data['theme'])->first()->id;
                $offer->URL = $data['url'];
                $isAdded = $offer->save();
                return [
                    'result' => $isAdded,
                    'row' => [
                        'id' => $offer->id,
                        'name' => $offer->name,
                        'theme' => $offer->theme->name,
                        'URL' => $offer->URL
                        ]
                ];
            }
        }
    }
}
