<?php

namespace App\Http\Middleware;

use App\Response\Response;
use Closure;
use Illuminate\Http\Request;

class VerifyAuth
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function handle(Request $request, Closure $next)
    {
        $cookie = $request->cookie('user_session');
        
        if (!$cookie) {
            return $this->response->responseError('Unauthorized - Cookie not found', 401);
        }

        $sessionData = json_decode($cookie, true);
        
        if (!isset($sessionData['id']) || !isset($sessionData['role'])) {
            return $this->response->responseError('Invalid session data', 401);
        }

        $request->attributes->add(['user_auth' => $sessionData]);

        return $next($request);
    }
}