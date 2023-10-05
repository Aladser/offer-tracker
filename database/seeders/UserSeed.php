<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeed extends Seeder
{
    public function run()
    {
        // пароль AAAAaaaa1111
        $maxId = User::all()->max('id')+ 1;
        User::create([
            'name' => "admin",
            'email' => "admin@mail.ru",
            'password' => '$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',
            'role_id' => 1,
        ]);
        

        $maxId++;
        User::create([
            'name' => "advertiser",
            'email' => "advertiser@mail.ru",
            'password' => '$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',
            'role_id' => 2,
        ]);

        $maxId++;
        User::create([
            'name' => "User$maxId",
            'email' => "user$maxId@mail.ru",
            'password' => '$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',
            'role_id' => 2,
            'status' => 0
        ]);

        
        $maxId++;
        User::create([
            'name' => "User$maxId",
            'email' => "user$maxId@mail.ru",
            'password' => '$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',
            'role_id' => 2,
            'status' => 0,
        ]);
        $maxId++;
        User::create([
            'name' => "webmaster",
            'email' => "webmaster@mail.ru",
            'password' => '$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',
            'role_id' => 3,
        ]);


        $maxId++;
        User::create([
            'name' => "User$maxId",
            'email' => "user$maxId@mail.ru",
            'password' => '$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',
            'role_id' => 3,
        ]);
        $maxId++;
        User::create([
            'name' => "User$maxId",
            'email' => "user$maxId@mail.ru",
            'password' => '$2y$10$PTy20SmgowBKIDav9AwsBOp5p0a90mWw4FILg5EiNNs79./j4D6lS',
            'role_id' => 3,
        ]);
    }
}
