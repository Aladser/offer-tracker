<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfferClick;
use App\Http\Controllers\StatisticController;

class OfferClickSeeder extends Seeder
{
    public function run()
    {
        OfferClick::create(['offer_id' => 2, 'webmaster_id' => 1]);
        OfferClick::create(['offer_id' => 2, 'webmaster_id' => 2]);

        OfferClick::create(['offer_id' => 3, 'webmaster_id' => 1]);
        OfferClick::create(['offer_id' => 3, 'webmaster_id' => 2]);
        OfferClick::create(['offer_id' => 3, 'webmaster_id' => 3]);

        $date = StatisticController::getDate('-3 days');
        OfferClick::create(['offer_id' => 1, 'created_at' => $date, 'webmaster_id' => 1]);

        $date = StatisticController::getDate('-3 month');
        OfferClick::create(['offer_id' => 1, 'created_at' => $date, 'webmaster_id' => 2]);

        OfferClick::create(['offer_id' => 4, 'webmaster_id' => 1]);
        OfferClick::create(['offer_id' => 4, 'webmaster_id' => 3]);
    }
}
