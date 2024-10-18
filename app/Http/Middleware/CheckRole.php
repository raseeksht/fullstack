<?php

namespace App\Http\Middleware;

use App\Models\Blog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    private function errorResponse($statusCode, $errorMessage)
    {
        return response()->json([
            "success" => false,
            "statusCode" => $statusCode,
            "message" => $errorMessage

        ], $statusCode);
    }
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check())
        {
            return $this->errorResponse(403, "Login Required");
        }
        $userRoles = auth()->user()->roles;
        $userRolesArr = auth()->user()->roles->pluck("title")->toArray();

        // cheking if the user has any one of the required role to access 
        if (array_intersect($roles, $userRolesArr))
        {
            return $next($request);
        }


        // cheking if the requesting usr is the owener of the blog
        $blogId = $request->route("id");

        if ($blogId)
        {
            // here http method must be patch or delete
            $blog = Blog::find($blogId);
            if (!$blog)
            {
                return $this->errorResponse(404, "Blog Doesn't exists");

            }
            if ($blog->user_id == auth()->user()->id)
            {
                // user who is requesting is the owner of the blog
                return $next($request);

            }
        }


        return $this->errorResponse(403, "Access Denied! You do not have the required role to access this");

    }
}
