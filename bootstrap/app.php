<?php

use App\Http\Middleware\VerifyRole;
use App\Http\Middleware\VerifyBearerToken;
use App\Http\Middleware\VerifyAuth;
use App\Http\Middleware\VerifyLaravelAuth;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => VerifyRole::class,
            'auth' => VerifyBearerToken::class,
            'authv2' => VerifyAuth::class,
            'authv3' => VerifyLaravelAuth::class,
        ]);

            $middleware->validateCsrfTokens(except: [
            'v1/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();