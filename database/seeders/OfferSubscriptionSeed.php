<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfferSubscription;

class OfferSubscriptionSeed extends Seeder
{
    public function run()
    {
        OfferSubscription::create(['follower_id' => 1, 'advertiser_product_id' => 1]);
        OfferSubscription::create(['follower_id' => 2, 'advertiser_product_id' => 1]);
        OfferSubscription::create(['follower_id' => 3, 'advertiser_product_id' => 2]);
        OfferSubscription::create(['follower_id' => 1, 'advertiser_product_id' => 1]);
        OfferSubscription::create(['follower_id' => 2, 'advertiser_product_id' => 2]);
        OfferSubscription::create(['follower_id' => 3, 'advertiser_product_id' => 3]);
    }
}
