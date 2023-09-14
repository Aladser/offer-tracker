<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
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
    }
}
