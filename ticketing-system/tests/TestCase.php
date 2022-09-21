<?php

namespace Tests;

use App\Models\Developer;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    public function getUser()
    {
        return User::factory()->make()->toArray();

    }
}
