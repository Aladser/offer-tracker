<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\UserRole;
use App\Models\User;
use App\Models\Advertiser;

class AdvertiserTest extends TestCase
{
    public function testGetAdvertiser()
    {
        system('clear');
        if (UserRole::count() === 0) {
            $this->seed();
        }
        
        echo Advertiser::find(1)->user . "\n";
        echo User::find(1)->advertiser;
        $this->assertDatabaseCount('user_roles', 3);
    }
}
