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
    }
}
