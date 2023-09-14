<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;
use App\Models\OfferTheme;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // роли
        UserRole::create(['name' => 'администратор']);
        UserRole::create(['name' => 'рекламодатель']);
        UserRole::create(['name' => 'веб-мастер']);

        // админ
        // пароль AAAAaaaa1111
        User::create([
            'name' => "Admin",
            'email' => "aladser@mail.ru",
            'password' => '$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',
            'role_id' => 1,
        ]);

        // темы офферов
        OfferTheme::create(['name' => 'спорт']);
        OfferTheme::create(['name' => 'образование']);
        OfferTheme::create(['name' => 'красота']);
    }
}
