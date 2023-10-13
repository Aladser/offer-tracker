<?php

namespace Database\Seeders;

use App\Models\Advertiser;
use App\Models\OfferTheme;
use App\Models\SystemOption;
use App\Models\UserRole;
use App\Models\Webmaster;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        DB::update('ALTER TABLE user_roles AUTO_INCREMENT = 1');
        SystemOption::create(['name' => 'commission', 'value' => 10]);

        $userSeed = new UserSeed();
        $offerSeed = new OfferSeed();
        $offerSubscriptionSeed = new OfferSubscriptionSeed();
        $offerClickSeeder = new OfferClickSeeder();

        UserRole::create(['name' => 'администратор']);
        UserRole::create(['name' => 'рекламодатель']);
        UserRole::create(['name' => 'веб-мастер']);
        $userSeed->run();

        Advertiser::create(['user_id' => 2]);
        Advertiser::create(['user_id' => 3]);
        Advertiser::create(['user_id' => 4]);

        Webmaster::create(['user_id' => 5]);
        Webmaster::create(['user_id' => 6]);
        Webmaster::create(['user_id' => 7]);

        OfferTheme::create(['name' => 'IT']);
        OfferTheme::create(['name' => 'образование']);
        OfferTheme::create(['name' => 'игры']);
        OfferTheme::create(['name' => 'спорт']);
        OfferTheme::create(['name' => 'отдых']);
        $offerSeed->run();
        $offerSubscriptionSeed->run();
        $offerClickSeeder->run();
    }
}
