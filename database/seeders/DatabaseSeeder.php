<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserRoleSeed;
use Database\Seeders\UserSeed;
use Database\Seeders\OfferThemeSeed;
use Database\Seeders\OfferSeed;
use Database\Seeders\OfferSubscriptionSeed;
use Database\Seeders\AdvertiserProductSeed;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $userRoleSeed = new UserRoleSeed();
        $userSeed = new UserSeed();
        $offerThemeSeed = new OfferThemeSeed();
        $offerSeed = new OfferSeed();
        $advertiserProductSeed = new AdvertiserProductSeed();
        $offerSubscriptionSeed = new OfferSubscriptionSeed();

        $userRoleSeed->run();
        $userSeed->run();
        $offerThemeSeed->run();
        $offerSeed->run();
        $advertiserProductSeed->run();
        $offerSubscriptionSeed->run();
    }
}
