<?php

namespace App\Http\Middleware;

use Closure;
use App\Response\Response;

class VerifyAdmin
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $payload = $request->get('user_auth');

        if (isset($payload['role_id']) && $payload['role_id'] == 2) {
            return $next($request);
        }

        return $this->response->responseError('Unauthorized role', 403);
    }
}
