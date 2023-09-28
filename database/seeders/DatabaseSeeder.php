<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Database\Seeders\UserRoleSeed;
use Database\Seeders\UserSeed;
use Database\Seeders\OfferThemeSeed;
use Database\Seeders\OfferSeed;
use Database\Seeders\OfferSubscriptionSeed;
use Database\Seeders\OfferClickSeeder;
use App\Models\SystemOption;
use App\Models\Advertiser;
use App\Models\Webmaster;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::update('ALTER TABLE user_roles AUTO_INCREMENT = 1');

        $userRoleSeed = new UserRoleSeed();
        $userSeed = new UserSeed();
        
        $offerThemeSeed = new OfferThemeSeed();
        $offerSeed = new OfferSeed();
        $offerSubscriptionSeed = new OfferSubscriptionSeed();
        $offerClickSeeder = new OfferClickSeeder();

        $userRoleSeed->run();
        $userSeed->run();
        Advertiser::create(['user_id' => 2]);
        Advertiser::create(['user_id' => 3]);
        Advertiser::create(['user_id' => 4]);
        Webmaster::create(['user_id' => 5]);
        Webmaster::create(['user_id' => 6]);
        Webmaster::create(['user_id' => 7]);

        $offerThemeSeed->run();
        $offerSeed->run();
        $offerSubscriptionSeed->run();
        $offerClickSeeder->run();

        SystemOption::create(['name' => 'commission', 'value' => 25]);
    }
}
