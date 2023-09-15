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
        AdvertiserProduct::create(['status'=>1, 'advertiser_id'=>1, 'offer_id'=>1, 'price'=>100, 'clicks' => 5]);
    }
}
