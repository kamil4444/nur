<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;

class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if (session()->has('jwt')) {
            return $next($request);
        }
        else {
            return redirect()->route('loginview');
        }
    }
}