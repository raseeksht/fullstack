<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function login()
    {
        return view("/login");
    }

    public function logout()
    {
        Auth::logout();

        return redirect("/");
    }

    public function authenticate()
    {
        $validated = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($validated))
        {
            throw ValidationException::withMessages(["loginErr" => "Invalid email or password"]);
        }

        return redirect('/');
    }

    public function create(UserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);

        Auth::login($user);
        return redirect('/');
    }

    public function register()
    {
        return view('register');

    }

}
