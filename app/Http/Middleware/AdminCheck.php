<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && Auth::user()->is_admin && Auth::user()->status) {
            return $next($request);
        } elseif (Auth::guard($guard)->check() && Auth::user()->id == 1) {
            return $next($request);
        }
        return redirect('/');
    }
}
