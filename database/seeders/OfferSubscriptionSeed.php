<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfferSubscription;

class OfferSubscriptionSeed extends Seeder
{
    public function run()
    {
        OfferSubscription::create(['follower_id' => 1, 'offer_id' => 3]);
        OfferSubscription::create(['follower_id' => 2, 'offer_id' => 3]);
        OfferSubscription::create(['follower_id' => 3, 'offer_id' => 3]);
        OfferSubscription::create(['follower_id' => 2, 'offer_id' => 5]);
        OfferSubscription::create(['follower_id' => 1, 'offer_id' => 7]);
        OfferSubscription::create(['follower_id' => 2, 'offer_id' => 7]);
        OfferSubscription::create(['follower_id' => 1, 'offer_id' => 8]);
        OfferSubscription::create(['follower_id' => 2, 'offer_id' => 2]);
        OfferSubscription::create(['follower_id' => 3, 'offer_id' => 2]);

        $date = new \DateTime();
        $date->modify('-2 day');
        OfferSubscription::create(['follower_id' => 1, 'offer_id' => 4, 'created_at' => $date->format('Y-m-d H:i:s')]);
        $date->modify('-2 month');
        OfferSubscription::create(['follower_id' => 2, 'offer_id' => 4, 'created_at' => $date->format('Y-m-d H:i:s')]);
    }
}
