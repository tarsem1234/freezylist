<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders()
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        // channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo('/');

        $middleware->validateCsrfTokens(except: [
            'xmlfeed',
        ]);

        $middleware->append(\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class);

        $middleware->web(\App\Http\Middleware\LocaleMiddleware::class);

        $middleware->throttleApi('60,1');

        $middleware->group('admin', [
            'auth',
            'access.routeNeedsPermission:view-backend',
            'timeout',
        ]);

        $middleware->alias([
            'CheckUserStatus' => \App\Http\Middleware\CheckUserStatus::class,
            'OnlyUsers' => \App\Http\Middleware\OnlyUsers::class,
            'access.routeNeedsPermission' => \App\Http\Middleware\RouteNeedsPermission::class,
            'access.routeNeedsRole' => \App\Http\Middleware\RouteNeedsRole::class,
            'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
            'checkDeletedUserOffer' => \App\Http\Middleware\CheckDeletedUserHasOffer::class,
            'checkOfferValues' => \App\Http\Middleware\CheckSessionHasOfferValues::class,
            'checkPropertyId' => \App\Http\Middleware\CheckSessionHasOfferPropertyId::class,
            'checkSignatureValues' => \App\Http\Middleware\CheckSessionHasOfferSignature::class,
            'timeout' => \App\Http\Middleware\SessionTimeout::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
