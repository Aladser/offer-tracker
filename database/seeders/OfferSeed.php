<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeed extends Seeder
{
    public function run()
    {
        Offer::create(['name'=>'Товар 1', 'theme_id'=>1, 'URL'=>'url1']);
        Offer::where('name', 'Товар 1')->update(['description' => 'что-то про спорт']);
        Offer::create(['name'=>'Товар 2', 'theme_id'=>2, 'URL'=>'url2']);
        Offer::where('name', 'Товар 2')->update(['description' => 'что-то про образование']);
        Offer::create(['name'=>'Товар 3', 'theme_id'=>3, 'URL'=>'url3']);
        Offer::where('name', 'Товар 3')->update(['description' => 'что-то про природу']);
    }
}
