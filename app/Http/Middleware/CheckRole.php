<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Check if the user is authenticated
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthorized'], 401); // Forbidden response
        }

        // Check if the user has the required role
        if (!$request->user()->hasRole($role)) {
            return response()->json(['error' => 'Forbidden'], 403); // Forbidden response
        }

        return $next($request);
    }
}
