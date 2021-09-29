<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if (Auth::guard()->check())
                dd('redirectTo');
//            if(!Auth::user())
//                $request->session()->flash('expired','the session has expired!');
//
////            return route('auth.expired');
            return route('login');
        }
    }
}
