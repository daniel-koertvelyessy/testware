<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {


//        if(!Auth::user())
//        {
//            return redirect()->route('logout'); // add your desire URL in redirect function
//        }

        if (Auth::guard($guard)->check()) {
            return redirect()->route('auth.expired');
        }

        return $next($request);

    }
}
