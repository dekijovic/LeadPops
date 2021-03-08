<?php

namespace App\Http\Middleware;

use App\Service\JWT;
use Closure;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class JwtAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $auth = $request->header('Authorization');
        if(JWT::INVALID === (new JWT())->validate($auth)){
//            throw new ValidationException('Your request is not authorized', 403);
            return response(['message' => 'Your request is not authorized']);
        }
        else if(JWT::EXPIRED === (new JWT())->validate($auth)){
            // throw new ValidationException('Your request is expired', 403);
            return response(['message' => 'Your request is expired']);
        }
        return $next($request);
    }
}
