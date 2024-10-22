<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permission): Response
    {

        // dd(auth()->user()->permissions->pluck('name'));
        // $permission1 = \Spatie\Permission\Models\Permission::where('name', 'createBlog')->first();
        // $permission1->guard_name = 'api';
        // $permission1->save();

        // dd($permission1);
        // $permission1->save();
        // dd(auth()->user()->hasPermissionTo("createBlog"));
        // if (Auth::guard('web')->check())
        // {
        //     // Log or take some action for web guard
        //     return response()->json(['message' => 'Logged in through web guard'], 200);
        // } elseif (Auth::guard('api')->check())
        // {
        //     // Log or take some action for api guard
        //     // return 'Logged in through API guard';
        //     return response()->json(['message' => 'Logged in through api guard'], 200);

        // } else
        // {
        //     // Not authenticated
        //     return response()->json(['message' => 'Npt logged in'], 200);
        //     // return 'Not logged in';
        // }

        //give error "There is no permission named `createBlog` for guard `api`
        if (array_intersect(auth()->user()->getAllPermissions()->pluck('name')->toArray(), $permission))
        {
            return $next($request);
        } else
        {
            throw new AccessDeniedHttpException("You do not have the required permission", null, 403);
        }
    }
}
