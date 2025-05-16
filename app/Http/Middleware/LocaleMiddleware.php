<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && ! Session::has('locale')) {
            Session::put('locale', $request->user()->locale);
        }

        if ($request->has('locale')) {
            Session::put('locale', $request->get('locale'));
        }

        $locale = Session::get('locale');

        if ($locale === null) {
            $locale = config('app.fallback_locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
