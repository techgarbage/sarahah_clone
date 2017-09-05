<?php

namespace App\Http\Middleware;

use App\Lib\ResultCode;
use App\Lib\Utils;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateMiddleware
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
            $user = JWTAuth::toUser($request->input('token'));
        } catch (JWTException $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return Utils::resultForResponse(ResultCode::ERROR_AUTHENTICATE, [], 'token_expired');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return Utils::resultForResponse(ResultCode::ERROR_AUTHENTICATE, [], 'token_invalid');
            } else {
                return Utils::resultForResponse(ResultCode::ERROR_AUTHENTICATE, [], 'token_required');
            }
        }

        return $next($request);
    }
}
