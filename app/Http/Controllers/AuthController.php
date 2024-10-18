<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends ApiController
{
    // public function login()
    // {
    //     return view("/login");
    // }

    public function logout(Request $request)
    {
        // Auth::logout();
        $request->user()->tokens()->delete();

        return $this->SuccessResponse(null, 200, "Logged Out");
    }

    public function authenticate()
    {
        $validated = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($validated))
        {
            return $this->ErrorResponse(401, 'Invalid Email or Password');
        }
        $token = Auth::user()->createToken('auth')->accessToken;
        return $this->SuccessResponse(["token" => $token], 200, "Login success");
    }

    public function create(UserRequest $request)
    {
        $validated = $request->validated();
        try
        {
            $user = User::create($validated);

            // Auth::login($user);
            $token = $user->createToken('authToken')->accessToken;
            $user['token'] = $token;
            return $this->SuccessResponse($user, 201, "User Registered Successfully");
            //code...
        } catch (\Throwable $th)
        {
            if ($th->getCode() == "23000")
            {
                // return $this->ApiResponse(400, "Email already Registered", null);
                return $this->ErrorResponse(400, "Duplicate email");
            } else
            {
                return $this->ErrorResponse(500, "Failed registering User " . $th->getMessage());
            }
        }
    }

    // public function register()
    // {
    //     return view('register');

    // }

}
