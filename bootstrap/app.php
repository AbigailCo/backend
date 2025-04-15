<?php

use App\Http\Middleware\EnsureEmailIsVerified;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        //auth: __DIR__ . '/../routes/auth.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->api(prepend: [
            //\Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // \Illuminate\Http\Middleware\HandleCors::class, 
            HandleCors::class,

        ]);

        $middleware->validateCsrfTokens(except: [
            '/register',
            '/login',
            '/forgot-password',
            '/reset-password',
            '/verify-email/*',
            '/email/verification-notification',
            '/logout'
        ]);

        $middleware->alias([
            'verified' => EnsureEmailIsVerified::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        // Podés configurar manejo de errores personalizados acá
    })
    ->create();
