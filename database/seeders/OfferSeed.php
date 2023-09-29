<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeed extends Seeder
{
    public function run()
    {
        Offer::create([
            'name'=>'Оффер 1',
            'theme_id'=>1,
            'advertiser_id' => 1,
            'price' => random_int(1, 10),
            'status' => 1
        ]);
        Offer::create([
            'name'=>'Оффер 2',
            'theme_id'=>2,
            'advertiser_id' => 2,
            'price' => random_int(1, 10),
            'status' => 1
        ]);
        Offer::create([
            'name'=>'Оффер 3',
            'theme_id'=>3,
            'advertiser_id' => 3,
            'price' => random_int(1, 10)
        ]);
        Offer::create([
            'name'=>'Оффер 4', 'theme_id'=>1, 
            'advertiser_id' => 1, 
            'price' => random_int(1, 10), 
            'status' => 1
        ]);
        Offer::create([
            'name'=>'Оффер 5', 
            'theme_id'=>2, 
            'advertiser_id' => 1, 
            'price' => random_int(1, 10),
        ]);
        Offer::create([
            'name'=>'Оффер 6', 
            'theme_id'=>2, 
            'advertiser_id' => 2, 
            'price' => random_int(1, 10), 
            'status' => 1
        ]);
        Offer::create([
            'name'=>'Оффер 7', 'theme_id'=>1, 
            'advertiser_id' => 2, 
            'price' => random_int(1, 10), 
            'status' => 0
        ]);
        Offer::create([
            'name'=>'Оффер 8', 'theme_id'=>1, 
            'advertiser_id' => 3, 
            'price' => random_int(1, 10), 
            'status' => 1
        ]);
    }
}
