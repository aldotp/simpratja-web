<?php

namespace App\Http\Middleware;

use App\Response\Response;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class VerifyBearerToken
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return $this->response->responseError('Authorization token not found', 401);
        }


        $token = str_replace('Bearer ', '', $authHeader);

        try {
            $accessSecret = config('jwt.access_secret');
            $decoded = JWT::decode($token, new Key($accessSecret, 'HS256'));
            $payload = (array) $decoded;

            $request->attributes->add(['user_auth' => $payload]);

            return $next($request);

        } catch (\Firebase\JWT\ExpiredException $e) {
            return $this->response->responseError('Token has expired', 401);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            return $this->response->responseError('Invalid token signature', 401);
        } catch (Exception $e) {
            return $this->response->responseError('Invalid token', 401);
        }
    }
}