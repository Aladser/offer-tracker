<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfferClick;

class OfferClickSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OfferClick::create(['follower_id' => 1, 'advertiser_product_id' => 1]);
        OfferClick::create(['follower_id' => 2, 'advertiser_product_id' => 1]);
        OfferClick::create(['follower_id' => 3, 'advertiser_product_id' => 2]);
        OfferClick::create(['follower_id' => 1, 'advertiser_product_id' => 1]);
        OfferClick::create(['follower_id' => 2, 'advertiser_product_id' => 2]);
        OfferClick::create(['follower_id' => 3, 'advertiser_product_id' => 3]);
    }
}
