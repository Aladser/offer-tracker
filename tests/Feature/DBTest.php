<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserRole;
use App\Models\OfferTheme;
use App\Models\Offer;
use Database\Seeders\UserRoleSeed;
use Database\Seeders\UserSeed;

class DBTest extends TestCase
{
    public function test_getUsers()
    {
        //system('clear');
        //$this->seed(UserRoleSeed::class);

        for ($i=0; $i<10; $i++) {
            $this->seed(UserSeed::class);
        }
        $users = User::all();
        foreach ($users as $user) {
            echo "имя: {$user->name}, роль: {$user->role->name}, email: {$user->email}\n";
        }

        $this->assertDatabaseCount('users', 10);
        User::truncate();
    }
}
