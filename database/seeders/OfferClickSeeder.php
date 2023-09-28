<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfferClick;

class OfferClickSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i<5; $i++) {
            OfferClick::create(['offer_id' => 4]);
        }
        for ($i=0; $i<4; $i++) {
            OfferClick::create(['offer_id' => 5]);
        }
        for ($i=0; $i<3; $i++) {
            OfferClick::create(['offer_id' => 8]);
        }

    }
}
