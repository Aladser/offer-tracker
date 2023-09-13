<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        UserRole::create(['name' => 'advertiser']);
        UserRole::create(['name' => 'webmaster']);
        // пользователи
        $maxId = User::all()->max('id')+ 1;
        User::create([
            'name' => "User$maxId",
            'email' => "user$maxId@mail.ru",
            'password' => 12345678,
            'role_id' => 1,
        ]);
    }
}
