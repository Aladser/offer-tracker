<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeed extends Seeder
{
    public function run()
    {
        Offer::create([
            'url'=>'http://127.0.0.1:8000/1',
            'name'=>'Товар 1',
            'theme_id'=>1,
            'advertiser_id' => 1,
            'price' => random_int(100, 200)
        ]);
        Offer::create([
            'url'=>'http://127.0.0.1:8000/2',
            'name'=>'Товар 2',
            'theme_id'=>2,
            'advertiser_id' => 1,
            'price' => random_int(100, 200),
            'status' => 1
        ]);
        Offer::create([
            'url'=>'http://127.0.0.1:8000/3',
            'name'=>'Товар 3',
            'theme_id'=>3,
            'advertiser_id' => 1,
            'price' => random_int(100, 200)
        ]);
        Offer::create([
            'url'=>'http://127.0.0.1:8000/4', 
            'name'=>'Товар 4', 'theme_id'=>1, 
            'advertiser_id' => 2, 
            'price' => random_int(100, 200), 
            'status' => 1
        ]);
        Offer::create([
            'url'=>'http://127.0.0.1:8000/5', 
            'name'=>'Товар 5', 
            'theme_id'=>2, 
            'advertiser_id' => 2, 
            'price' => random_int(100, 200)
        ]);
        Offer::create([
            'url'=>'http://127.0.0.1:8000/6', 
            'name'=>'Товар 6', 
            'theme_id'=>2, 
            'advertiser_id' => 3, 
            'price' => random_int(100, 200), 
            'status' => 1
        ]);
        Offer::create([
            'url'=>'http://127.0.0.1:8000/7', 
            'name'=>'Товар 7', 'theme_id'=>1, 
            'advertiser_id' => 2, 
            'price' => random_int(100, 200), 
            'status' => 0
        ]);
        Offer::create([
            'url'=>'http://127.0.0.1:8000/8', 
            'name'=>'Товар 8', 'theme_id'=>1, 
            'advertiser_id' => 2, 
            'price' => random_int(100, 200), 
            'status' => 1
        ]);
        Offer::create([
            'url'=>'http://127.0.0.1:8000/9', 
            'name'=>'Товар 9', 
            'theme_id'=>1, 
            'advertiser_id' => 2, 
            'price' => random_int(100, 200), 
            'status' => 0
        ]);
    }
}
