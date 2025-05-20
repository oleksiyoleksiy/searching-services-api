<?php

use App\Enums\TokenAbility;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\OptionalAuthMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['auth:sanctum', 'can:provider', 'ability:' . TokenAbility::ACCESS_API->value])
                ->prefix('api/provider')
                ->as('provider.')
                ->group(__DIR__ . '/../routes/provider.php');

            Route::middleware(['auth:sanctum', 'can:admin', 'ability:' . TokenAbility::ACCESS_API->value])
                ->prefix('api/admin')
                ->as('admin.')
                ->group(__DIR__ . '/../routes/admin.php');
        },
    )
    ->withBroadcasting(
        __DIR__ . '/../routes/channels.php',
        ['prefix' => 'api', 'middleware' => ['auth:sanctum']],
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'ability' => CheckForAnyAbility::class,
            'auth.optional' => OptionalAuthMiddleware::class,
            'guest' => GuestMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
