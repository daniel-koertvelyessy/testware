<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Session\Store;

class SessionExpired
{
    protected $session;

    protected $timeout = 1200;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function handle($request, Closure $next)
    {
        $isLoggedIn = $request->path() != '/';
        if (! session('lastActivityTime')) {
            $this->session->put('lastActivityTime', time());
        } elseif (time() - $this->session->get('lastActivityTime') > $this->timeout) {
            $this->session->forget('lastActivityTime');
            $cookie = cookie('intend', $isLoggedIn ? url()->current() : '/');
            auth()->logout();
        }
        $isLoggedIn ? $this->session->put('lastActivityTime', time()) : $this->session->forget('lastActivityTime');

        return $next($request);
    }
}
