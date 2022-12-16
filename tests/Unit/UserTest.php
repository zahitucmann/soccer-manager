<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_user_fullName()
    {
        $user = new User([
            'name' => 'Jordan',
            'last_name' => 'Robert',
            'email' => 'jordan.robert@test.com'
        ]);

        $this->assertEquals('Jordan Robert', $user->fullName());
    }
}
