<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeed extends Seeder
{
    public function run()
    {
        $maxId = User::all()->max('id')+ 1;
        User::create([
            'name' => "User$maxId",
            'email' => "user$maxId@mail.ru",
            'password' => 12345678,
            'role_id' => 1,
        ]);
    }
}
