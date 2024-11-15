<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Jobs\UserCreated;
use App\Mail\PasswordResetEmail;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Str;


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
        $roles = Auth::user()->roles->pluck('name');
        $permissions = Auth::user()->getAllPermissions()->pluck('name');
        return $this->SuccessResponse(["token" => $token, 'roles' => $roles, 'permissions' => $permissions, 'user' => Auth::user()], 200, "Login success");
    }

    public function create(UserRequest $request)
    {
        $validated = $request->validated();
        try
        {
            $user = User::create($validated);

            // Auth::login($user);
            $token = $user->createToken('authToken')->accessToken;
            // dd(Auth::guard('api')->login($user));

            $user['token'] = $token;
            $user['guard'] = Auth::getDefaultDriver();

            UserCreated::dispatch($user);

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

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users']);
        $token = Str::random(60);


        $forgotPasswordRecord = DB::table('password_reset_tokens')->where('email', $request->email)->first();
        if ($forgotPasswordRecord)
        {
            // dd(now());
            if ((time() - strtotime($forgotPasswordRecord->created_at)) < 120)
            {
                return $this->ErrorResponse(400, "Reset after 2 minutes");
            } else
            {
                DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->update(['token' => $token, 'created_at' => now()]);
            }
        } else
        {
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
            ]);
        }

        Mail::to($request->email)->queue(
            new PasswordResetEmail(['token' => $token, 'email' => $request->email])
        );

        return response()->json(['message' => 'Reset link sent.']);
    }

    public function reset(Request $request)
    {
        // dd(request()->all());
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
            'token' => 'required',
        ]);
        // dd($request->all());
        $passwordReset = DB::table('password_reset_tokens')->where('email', $request->email)->where('token', $request->token)->first();
        if ($passwordReset)
        {
            $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
            $passwordReset = DB::table('password_reset_tokens')->where('email', $request->email)->where('token', $request->token)->delete();
            return $this->SuccessResponse(null, 200, "password reset success");


        } else
        {
            return $this->ErrorResponse(400, "Couldn't reset password. token mismatch or not found");
        }

    }

}
