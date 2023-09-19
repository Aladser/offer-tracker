<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRoleSeed extends Seeder
{
    public function run()
    {
        UserRole::create(['name' => 'администратор']);
        UserRole::create(['name' => 'рекламодатель']);
        UserRole::create(['name' => 'веб-мастер']);
    }
}
