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
        $roles = ['advertiser', 'webmaster'];
        foreach ($roles as $role) {
            UserRole::create(['name' => $role]);
        }
    }
}
