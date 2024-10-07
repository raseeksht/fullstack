<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
// use Illuminate\View\View;

// Route::get('/', function () {
//     if (!Auth::check())
//     {
//         return redirect()->route("login");

//         // return redirect("/login");
//     }
//     return view('home');
// });


Route::get("/", [HomeController::class, "index"]);

Route::get('/about', function () {
    return view('about');
});


Route::get('/contact', function () {
    return view('contact');
});


// Route::get('/login', [AuthController::class, 'login']);


Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login');
    Route::post('/login', 'authenticate');
    Route::get('/register', 'register');
    Route::post('/register', 'createUser');
    Route::get("/logout", "logout");
});





// resourceful route (auto create all the routes)
Route::resource("users", UserController::class);


