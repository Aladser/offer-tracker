<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\UserRole;
use App\Models\Advertiser;

class AdvertiserTest extends TestCase
{
    public function testFindAdvertiser()
    {
        system('clear');
        if (UserRole::count() === 0) {
            $this->seed();
        }
        var_dump(Advertiser::getAdvertiser('User2'));
        $this->assertDatabaseCount('user_roles', 3);
    }
}
