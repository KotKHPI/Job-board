<?php

namespace Tests;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function user() : User {
        return User::factory()->create();
    }

    public function userIsEmployer() : Employer {
        return Employer::factory()->create([
            'user_id' => $this->user()->id
        ]);
    }
}
