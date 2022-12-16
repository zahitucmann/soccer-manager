<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class UserLoginTest extends TestCase
{
    public function test_user_login()
    {   
        $user = User::create(['name' => 'Test','last_name' => 'User','email' => 'tesdsst@gmail.com','password' => Hash::make('testPass123')]);

        $response = $this->withoutExceptionHandling()->withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->postJson('api/auth/login', ['email' => 'tesdsst@gmail.com','password' => 'testPass123']);
        
        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => "Success",
                'message' => "User Logged In Successfully"
            ]);
    }
}
