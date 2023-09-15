<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OfferTheme;

class OfferThemeSeed extends Seeder
{
    public function run()
    {
        OfferTheme::create(['name' => 'спорт']);
        OfferTheme::create(['name' => 'образование']);
        OfferTheme::create(['name' => 'красота']);
    }
}
