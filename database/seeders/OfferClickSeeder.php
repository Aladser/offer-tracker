<?php

namespace Database\Seeders;

use App\Models\OfferClick;
use App\Services\OfferStatistics;
use Illuminate\Database\Seeder;

class OfferClickSeeder extends Seeder
{
    public function run()
    {
        OfferClick::create(['offer_id' => 2, 'webmaster_id' => 1]);
        OfferClick::create(['offer_id' => 2, 'webmaster_id' => 2]);

        OfferClick::create(['offer_id' => 3, 'webmaster_id' => 1]);
        OfferClick::create(['offer_id' => 3, 'webmaster_id' => 2]);
        OfferClick::create(['offer_id' => 3, 'webmaster_id' => 3]);

        $date = OfferStatistics::getDate('-3 days');
        OfferClick::create(['offer_id' => 1, 'created_at' => $date, 'webmaster_id' => 1]);

        $date = OfferStatistics::getDate('-3 month');
        OfferClick::create(['offer_id' => 1, 'created_at' => $date, 'webmaster_id' => 2]);

        OfferClick::create(['offer_id' => 4, 'webmaster_id' => 1]);
        OfferClick::create(['offer_id' => 4, 'webmaster_id' => 3]);

        $date = OfferStatistics::getDate('-2 month');
        OfferClick::create(['offer_id' => 1, 'webmaster_id' => 1, 'created_at' => $date]);
        $date = OfferStatistics::getDate('-2 year');
        OfferClick::create(['offer_id' => 1, 'webmaster_id' => 1, 'created_at' => $date]);
    }
}
