<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LinkClick;

class LinkClickSeed extends Seeder
{
    public function run()
    {
        LinkClick::create(['advertiser_product_id' => 1]);
    }
}
