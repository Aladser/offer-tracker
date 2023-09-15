<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdvertiserProduct;

class AdvertiserProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdvertiserProduct::create(['advertiser_id'=>1, 'offer_id'=>1, 'price'=>rand(100, 300), 'clicks' => rand(1, 10)]);
        AdvertiserProduct::create(['status'=> 1, 'advertiser_id'=>1, 'offer_id'=>2, 'price'=>rand(100, 300), 'clicks' => rand(1, 10)]);
        AdvertiserProduct::create(['advertiser_id'=>2, 'offer_id'=>3, 'price'=>rand(100, 300), 'clicks' => rand(1, 10)]);
    }
}
