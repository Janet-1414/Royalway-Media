<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // The readership beacon must work on cached pages with a stale token.
        // It only counts a view, is throttled, and changes nothing else.
        $middleware->validateCsrfTokens(except: [
            'resources/*/view',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
