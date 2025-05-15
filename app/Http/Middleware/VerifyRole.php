<?php

namespace App\Http\Middleware;

use Closure;
use App\Response\Response;
use Exception;

class VerifyRole
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
     * @param  mixed ...$allowedRoles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$allowedRoles)
    {
        try {
            $payload = $request->attributes->get('user_auth');

            if (!$payload || !isset($payload['role'])) {
                return $this->response->responseError('invalid role', 401);
            }

            if (!in_array($payload['role'], $allowedRoles)) {
                return $this->response->responseError('forbidden', 403);
            }

            return $next($request);
        } catch (Exception $e) {
            return $this->response->responseError('Error processing role validation: ' . $e->getMessage(), 401);
        }
    }
}