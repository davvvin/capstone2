<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// Import middleware Anda
use App\Http\Middleware\CheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Daftarkan alias middleware Anda di sini
        $middleware->alias([
            'role' => CheckRole::class,
            // Tambahkan alias middleware lain jika ada, contoh:
            // 'auth' => \App\Http\Middleware\Authenticate::class, // Biasanya sudah ada jika Breeze diinstal
        ]);

        // Anda juga bisa menambahkan middleware global atau grup di sini jika perlu
        // $middleware->web(append: [
        //     // MyCustomWebMiddleware::class,
        // ]);

        // $middleware->group('admin', [
        //     // MyAdminGroupMiddleware::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
