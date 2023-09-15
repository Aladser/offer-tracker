<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeed extends Seeder
{
    public function run()
    {
        Offer::create(['name'=>'Товар 1', 'theme_id'=>1, 'URL'=>'url1']);
        Offer::where('name', 'Товар 1')->update(['description' => 'Место для описания']);
    }
}
