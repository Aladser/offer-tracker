<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserRole;
use Database\Seeders\UserRoleSeed;
use Database\Seeders\UserSeed;

class DBTest extends TestCase
{
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_addUser()
    {
        DB::table('users')->truncate();
        //$this->seed(UserRoleSeed::class);
        for ($i=0; $i<10; $i++) {
            $this->seed(UserSeed::class);
        }

        foreach (User::all()->toArray() as $el) {
            echo "{$el['name']} {$el['email']}\n";
        }
    }
}
