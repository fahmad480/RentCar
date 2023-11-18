<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the user is authenticated and has the specified role.
        if (auth()->check() && auth()->user()->hasRole($role)) {
            return $next($request);
        }

        // If the user doesn't have the required role, you can handle the response accordingly.
        abort(403, 'Unauthorized action.');

        // Alternatively, you can redirect the user to a different page.
        // return redirect('home')->with('error', 'You do not have permission to access this page.');

        // You can customize the response as per your application's requirements.
    }
}
