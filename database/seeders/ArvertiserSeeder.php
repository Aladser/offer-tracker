<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Advertiser;

class ArvertiserSeeder extends Seeder
{
    public function run()
    {
        Advertiser::create(['user_id' => 1]);
        Advertiser::create(['user_id' => 2]);
        Advertiser::create(['user_id' => 3]);
    }
}
