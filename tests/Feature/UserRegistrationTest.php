<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_register()
    {
        $response = $this->withoutExceptionHandling()->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->postJson('api/auth/register',['name' => 'Test','last_name' => 'User','email' => 'tesdsst@gmail.com','password' => 'testPass123']);
        
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => "Success",
                'message' => "User created successfully"
            ]);
    }
}
