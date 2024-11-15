<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\CheckRole;
use App\Mail\ContactMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/test', function (Request $request) {
    return "hello";
})->middleware(['auth:api', "role:admin"]);

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'authenticate');
    Route::post('/register', 'create');
    Route::get("/logout", "logout")->middleware("auth:api");
});

Route::post('password/email', [AuthController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [AuthController::class, 'reset']);

Route::middleware("auth:api")->controller(BlogController::class)->group(function () {
    $missingBlogResponse = function () {
        return response()->json([
            "success" => false,
            "message" => "Blog does not exist ",
            "statusCode" => 404
        ], 404);
    };
    Route::get("/blogs", "index");
    Route::get("/blogs/{id}", "show");
    // Route::post("/blogs/", "store")->middleware("role:admin"); //with roles
    Route::post("/blogs/", "store")->middleware("checkPermission:createBlog"); //with permission
    // Route::post("/blogs/", "store")->middleware("role_or_permission:dance"); //with role or permission

    // either editor or admin or the creator himself can edit and delete
    // Route::patch("/blogs/{id}", "update")->middleware("checkRole:editor,admin");
    Route::delete("/blogs/{blog}", "destroy")->can("delete", 'blog')->missing($missingBlogResponse);


    // using policy
    Route::patch("/blogs/{blog}", "update")->can("update", "blog")->missing($missingBlogResponse);


});


Route::middleware(["auth:api"])->resource("comments", CommentController::class);

// Route::middleware("auth:api")->controller(RoleController::class)->group(function () {

//     Route::get("/roles", "index");
// });

Route::post("/sendmail", function (Request $request) {
    $validated = $request->validate([
        "name" => "required|min:5",
        "email" => "required",
        "subject" => "required|min:5",
        "message" => "required|min:20"
    ]);
    logger('from /sendmail');
    Mail::to("admin@admin.com")->queue(
        new ContactMail(($validated))
        // new PasswordResetEmail(['token' => $token, 'email' => $request->email])
    );
    return response()->json(["message" => "Email Sent Successfully"], 200);
});

Route::get("/users/{user}", function (User $user) {
    return response()->json(["user" => $user], 200);
})->missing(function () {
    return response()->json(["message" => "user Does not exists"], 404);
});
