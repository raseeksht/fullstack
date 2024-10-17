<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends ApiController
{
    public function login()
    {
        return view("/login");
    }

    public function logout(Request $request)
    {
        // Auth::logout();
        $request->user()->tokens()->delete();

        return $this->ApiResponse(200, "Logged Out", null);
    }

    public function authenticate()
    {
        $validated = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($validated))
        {
            return $this->ApiError(401, 'Invalid Email or Password');
        }
        $token = Auth::user()->createToken('auth_token')->plainTextToken;
        return $this->ApiResponse(200, "Login success", ["token" => $token]);
    }

    public function create(UserRequest $request)
    {
        $validated = $request->validated();
        try
        {
            $user = User::create($validated);

            // Auth::login($user);
            $token = $user->createToken('auth_token')->plainTextToken;
            $user['token'] = $token;
            return $this->ApiResponse(201, "User Registered Successfully", $user);
            //code...
        } catch (\Throwable $th)
        {
            if ($th->getCode() == "23000")
            {
                // return $this->ApiResponse(400, "Email already Registered", null);
                return $this->ApiError(400, "Duplicate email");
            } else
            {
                return $this->ApiError(500, "Failed registering User");
            }
        }








        // return redirect('/');
    }

    public function register()
    {
        return view('register');

    }

}
