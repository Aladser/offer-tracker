<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    public function run()
    {
        // пароль AAAAaaaa1111
        $maxId = User::all()->max('id') + 1;
        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.ru',
            'password' => '$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',
            'role_id' => 1,
        ]);

        for ($i = 1; $i < 4; ++$i) {
            User::create([
                'name' => "advertiser$i",
                'email' => "advertiser$i@mail.ru",
                'password' => '$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',
                'role_id' => 2,
            ]);
        }

        for ($i = 1; $i < 4; ++$i) {
            User::create([
                'name' => "webmaster$i",
                'email' => "webmaster$i@mail.ru",
                'password' => '$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',
                'role_id' => 3,
            ]);
        }
    }
}
