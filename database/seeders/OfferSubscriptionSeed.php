<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfferSubscription;

class OfferSubscriptionSeed extends Seeder
{
    public function run()
    {
        OfferSubscription::create(['webmaster_id' => 1, 'offer_id' => 1]);
        OfferSubscription::create(['webmaster_id' => 1, 'offer_id' => 4]);
        OfferSubscription::create(['webmaster_id' => 1, 'offer_id' => 5]);

        OfferSubscription::create(['webmaster_id' => 2, 'offer_id' => 1]);
        OfferSubscription::create(['webmaster_id' => 2, 'offer_id' => 2]);

        OfferSubscription::create(['webmaster_id' => 3, 'offer_id' => 1]);
    }
}
