<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IdOrPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permission): Response
    {
        //Retrieve logged user ID and requested user ID
        $requestedUser = $request->route('user');
        $loggedUser = Auth::user();

        //Retrieve logged user permissions
        $permissions = is_array($permission)
                ? $permission
                : explode('|', $permission);

        //Checks if user ID matches or user has permissions
        if($loggedUser->id != $requestedUser->id)
        {
            foreach($permissions as $permission)
            {
                if($loggedUser->hasPermissionTo($permission))
                {
                    return $next($request);
                }
            }
            abort(403);
        }

        return $next($request);
    }
}
