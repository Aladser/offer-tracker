<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfferSubscription;

class OfferSubscriptionSeed extends Seeder
{
    public function run()
    {
        OfferSubscription::create(['webmaster_id' => 1, 'offer_id' => 1, 'redirect-url'=>'http://127.0.0.1:8000/redirect/1/1']);
        OfferSubscription::create(['webmaster_id' => 1, 'offer_id' => 4, 'redirect-url'=>'http://127.0.0.1:8000/redirect/1/4']);
        OfferSubscription::create(['webmaster_id' => 1, 'offer_id' => 5, 'redirect-url'=>'http://127.0.0.1:8000/redirect/1/5']);

        OfferSubscription::create(['webmaster_id' => 2, 'offer_id' => 1, 'redirect-url'=>'http://127.0.0.1:8000/redirect/2/1']);
        OfferSubscription::create(['webmaster_id' => 2, 'offer_id' => 2, 'redirect-url'=>'http://127.0.0.1:8000/redirect/2/2']);

        OfferSubscription::create(['webmaster_id' => 3, 'offer_id' => 1, 'redirect-url'=>'http://127.0.0.1:8000/redirect/3/1']);
    }
}
