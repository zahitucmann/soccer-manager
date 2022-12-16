<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLogInRequest;
class AuthController extends BaseController
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }
   
    public function register(UserRegisterRequest $request)
    {
        $result = $this->authService->userRegistration($request);
        
        if ($result) {
            return $this->successResponse($result, 'User created successfully');
        }

        return $this->errorResponse('Error', 500);
    }

    public function login(UserLogInRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->errorResponse('Email & Password does not match with our record.', 401);
        }

        $result = $this->authService->userLogIn($request);
        
        if ($result) {
            return $this->successResponse($result, 'User Logged In Successfully');
        }

        return $this->errorResponse('Error', 500);
    }
}
