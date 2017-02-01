<?php

namespace App\Http\Middleware;

use Closure, Auth;
use App\Services\Auth\JwtGuard;

class JwtToken extends AbstractMiddleware
{
    public function handle($request, Closure $next)
    {
        /**
         * @var \App\Services\Auth\JwtGuard
         */
        //$auth = $this->app->make(JwtGuard::class);

        if(!Auth::guard('api')->check())
        {
            /*
            * @TODO Message must be via translation
            */
            return $this->unauthorized("Please login first!");
        }

        return $next($request);
    }
}