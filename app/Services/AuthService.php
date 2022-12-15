<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Jobs\CreateTeamJob;

class AuthService
{
    public function userRegistration($request)
    {
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        CreateTeamJob::dispatch($user->id)->onQueue('createTeam');

        return [    
            'status' => true,
            'data' => $user
        ];
    }

    public function userLogIn($request)
    {
        $user = User::where('email', $request->email)->first();

        return [
            'status' => true,
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ];
    }
}
