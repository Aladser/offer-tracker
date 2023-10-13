<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeed extends Seeder
{
    public function run()
    {
        Offer::create([
            'name'=> 'Github',
            'url' => 'https://github.com/Aladser',
            'theme_id'=>1,
            'advertiser_id' => 1,
            'price' => random_int(10, 50),
            'status' => 1
        ]);
        Offer::create([
            'name'=>'Django',
            'url' => 'https://metanit.com/python/django/3.1.php',
            'theme_id'=>2,
            'advertiser_id' => 2,
            'price' => random_int(10, 50),
            'status' => 1
        ]);
        Offer::create([
            'name'=>'Laravel 8',
            'theme_id'=>3,
            'advertiser_id' => 3,
            'price' => random_int(10, 50)
        ]);
        Offer::create([
            'name'=>'Laravel 10',
            'url' => 'https://laravel.com/docs/10.x',
            'theme_id'=>1,
            'advertiser_id' => 1,
            'price' => random_int(10, 50),
            'status' => 1
        ]);
        Offer::create([
            'name'=>'БЭМ',
            'url' => 'https://ru.bem.info/methodology/quick-start/',
            'theme_id'=>2,
            'advertiser_id' => 1,
            'price' => random_int(10, 50),
            'status' => 0
        ]);
        Offer::create([
            'name'=>'Boostrap',
            'url' => 'https://bootstrap-4.ru/docs/5.3/getting-started/introduction/',
            'theme_id'=>2,
            'advertiser_id' => 2,
            'price' => random_int(10, 50),
            'status' => 1
        ]);
        Offer::create([
            'name'=>'Яндекс',
            'url' => 'https://ya.ru/',
            'theme_id'=>1,
            'advertiser_id' => 2,
            'price' => random_int(10, 50),
            'status' => 0
        ]);
        Offer::create([
            'name'=>'Google',
            'url' => 'https://www.google.com/?hl=RU',
            'theme_id'=>1,
            'advertiser_id' => 3,
            'price' => random_int(10, 50),
            'status' => 1
        ]);
    }
}
