<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role, $guard = null)
    {
        $guard = $guard ?: 'web';
        if (Auth::guard($guard)->check() && Auth::guard($guard)->user()->user_role === $role) {
            return $next($request);
        }
        abort(403, 'Unauthorized');
    }
}