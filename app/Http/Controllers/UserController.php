<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view("user.index", ["users" => $users]);
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        // dd($user);
        return view("user.show", ["user" => $user]);
    }

    public function update($id)
    {
        $validated = request()->validate([
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email'],
        ]);
        $user = User::findOrFail($id);

        $user->name = request()->name;
        $user->email = request()->email;
        $user->save();
        return redirect("/users/$id");
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect("/users");
    }
}
