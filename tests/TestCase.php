<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function seedTest()
    {
        if (User::count() === 0) {
            $this->seed();
        }
    }
}
