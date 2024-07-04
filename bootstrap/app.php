<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        // using: function (Router $router) {

        //     $router->middleware('web')
        //         ->group(base_path('routes/web.php'));

        //     $router->middleware(['web', 'auth', 'role:1'])
        //         ->prefix('SuperAdmin')
        //         ->as('SuperAdmin.')
        //         ->group(base_path('routes/SuperAdmin.php'));

        //     $router->middleware(['web', 'auth', 'role:2'])
        //         ->prefix('Administrador')
        //         ->as('Administrador.')
        //         ->group(base_path('routes/Administrador.php'));

        //     $router->middleware(['web', 'auth', 'role:3'])
        //         ->prefix('Usuario')
        //         ->as('Usuario.')
        //         ->group(base_path('routes/Usuario.php'));
        // }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'web' =>  \App\Http\Middleware\HandleFlashValidationErrors::class,
        ]);
    })->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
