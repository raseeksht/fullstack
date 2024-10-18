<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\User;
use App\Policies\BlogPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Passport::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::policy(Blog::class, BlogPolicy::class);

        Paginator::useBootstrapFive();
        Gate::define("edit-blog", function (User $user, Blog $blog) {
            if ($blog->user_id == $user->id)
            {
                // owner
                return true;
            }
            $usrRole = $user->roles->pluck("title")->toArray();
            if (array_intersect(['admin', 'editor'], $usrRole))
            {
                return true;
            }
            return false;
        });
    }
}
