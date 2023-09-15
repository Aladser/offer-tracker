<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;
use App\Models\OfferTheme;
use Database\Seeders\UserRoleSeed;
use Database\Seeders\UserSeed;
use Database\Seeders\OfferThemeSeed;
use Database\Seeders\OfferSeed;
use Database\Seeders\AdvertiserProductSeed;
use Database\Seeders\LinkClickSeed;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $userRoleSeed = new UserRoleSeed();
        $userSeed = new UserSeed();
        $offerThemeSeed = new OfferThemeSeed();
        $offerSeed = new OfferSeed();
        $advertiserProductSeed = new AdvertiserProductSeed();
        $linkClickSeed = new LinkClickSeed();

        $userRoleSeed->run();
        $userSeed->run();
        $offerThemeSeed->run();
        $offerSeed->run();
        $advertiserProductSeed->run();
        $linkClickSeed->run();
    }
}
