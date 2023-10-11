<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfferTheme;

class OfferThemeSeed extends Seeder
{
    public function run()
    {
        OfferTheme::create(['name' => 'IT']);
        OfferTheme::create(['name' => 'образование']);
        OfferTheme::create(['name' => 'игры']);
    }
}
