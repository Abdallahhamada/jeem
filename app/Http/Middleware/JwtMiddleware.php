<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use JWTAuth;
use Auth;
use Session;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware
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
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                Session::flush();
                return response()->json(['status' => 'Token is Invalid'], 400);
            } 
            else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                Session::flush();
                return response()->json(['status' => 'Token is Expired'], 400);
            } 
            else {
                return response()->json(['status' => 'Authorization Token not found'], 400);
            }
        }
        return $next($request);
    }
}
