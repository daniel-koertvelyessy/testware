<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InstallerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
