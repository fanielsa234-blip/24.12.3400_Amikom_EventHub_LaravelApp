<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin; // <--- 1. Import IsAdmin di atas

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 2. Daftarkan alias 'admin' di sini
        $middleware->alias([
            'admin' => IsAdmin::class,
            'organizer' => \App\Http\Middleware\IsOrganizer::class,
        ]);
    })

    ->withMiddleware(function (Middleware $middleware) {
    // Mengecualikan route webhook Midtrans dari blokir CSRF
    $middleware->validateCsrfTokens(except: [
        '/midtrans/callback',
    ]);
})
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();