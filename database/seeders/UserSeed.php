<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    // пароль для пользователей
    public const PASSWORD = '_strongpassword_';

    public function run()
    {
        $hash_password = Hash::make(self::PASSWORD);

        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.ru',
            'password' => $hash_password,
            'role_id' => 1,
        ]);

        for ($i = 1; $i < 4; ++$i) {
            User::create([
                'name' => "advertiser$i",
                'email' => "advertiser$i@mail.ru",
                'password' => $hash_password,
                'role_id' => 2,
            ]);
            User::create([
                'name' => "webmaster$i",
                'email' => "webmaster$i@mail.ru",
                'password' => $hash_password,
                'role_id' => 3,
            ]);
        }
    }
}
