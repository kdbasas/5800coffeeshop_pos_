<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateEmployee
{
    public function handle($request, Closure $next, $guard = 'employee')
    {
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('employee.login'); // Adjust this to your employee login route
        }

        return $next($request);
    }
}

