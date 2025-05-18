<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyLaravelAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('web')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized',
                'code' => 401,
                'status' => 'failed'
            ], 401);
        }

        $request->attributes->add([
            'user_auth' => $user,
        ]);

        return $next($request);
    }
}
