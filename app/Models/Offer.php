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
        // поиск имени
        $isNameExisted = !is_null(Offer::where('name', $data['name'])->first());
        if ($isNameExisted) {
            return ['result' => 0, 'error' => 'Название оффера занято'];
        } else {
            // поиск пользователя
            $userId = User::where('name', $data['user'])->value('id');
            if (is_null($userId)) {
                return ['result' => 0, 'error' => "Ошибкa: пользователь {$data['user']} не существует"];
            } else {
                // добавление нового оффера
                $offer = new Offer();
                $offer->name = $data['name'];
                $offer->URL = $data['url'];
                $offer->price = $data['price'];
                $offer->theme_id = OfferTheme::where('name', $data['theme'])->first()->id;
                $offer->advertiser_id = $userId;
                $isAdded = $offer->save();
                return [
                    'result' => $isAdded,
                    'row' => [
                        'id' => $offer->id,
                        'name' => $offer->name,
                        'URL' => $offer->URL,
                        'price' => $offer->price,
                        'theme' => $offer->theme->name,
                        'user' => $offer->advertiser->name,
                        ]
                ];
            }
        } 
    }
}
