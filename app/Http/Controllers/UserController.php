<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
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

    public function update(UserRequest $request, $id)
    {

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
