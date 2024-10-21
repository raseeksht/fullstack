<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/test', function (Request $request) {
    return "hello";
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'authenticate');
    Route::post('/register', 'create');
    Route::get("/logout", "logout")->middleware("auth:api");
});
auth()->loginUsingId(11);

Route::middleware("auth:api")->controller(BlogController::class)->group(function () {
    Route::get("/blogs", "index");
    Route::get("/blogs/{id}", "show");
    Route::post("/blogs/", "store")->middleware("checkRole:author");

    // either editor or admin or the creator himself can edit and delete
    // Route::patch("/blogs/{id}", "update")->middleware("checkRole:editor,admin");
    Route::delete("/blogs/{blog}", "destroy")->can("delete", 'blog');


    // using policy
    Route::patch("/blogs/{blog}", "update")->can("update", "blog");


});


Route::middleware(["auth:api", "checkRole:admin"])->resource("roles", RoleController::class);

// Route::middleware("auth:api")->controller(RoleController::class)->group(function () {

//     Route::get("/roles", "index");
// });