<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfferClick;
use App\Http\Controllers\StatisticController;

class OfferClickSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i<2; $i++) {
            OfferClick::create(['offer_id' => 8]);
        }
        for ($i=0; $i<3; $i++) {
            OfferClick::create(['offer_id' => 5]);
        }

        $date = StatisticController::getDate('-3 days');
        OfferClick::create(['offer_id' => 4, 'created_at' => $date]);
        OfferClick::create(['offer_id' => 4, 'created_at' => $date]);
        $date = StatisticController::getDate('-3 month');
        OfferClick::create(['offer_id' => 4, 'created_at' => $date]);
        OfferClick::create(['offer_id' => 4, 'created_at' => $date]);
    }
}
