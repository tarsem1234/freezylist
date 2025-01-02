<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \Anhskohbo\NoCaptcha\NoCaptchaServiceProvider::class,
        \Arcanedev\LogViewer\LogViewerServiceProvider::class,
        \Spatie\Html\HtmlServiceProvider::class,
        \Anhskohbo\NoCaptcha\NoCaptchaServiceProvider::class,
        \Creativeorange\Gravatar\GravatarServiceProvider::class,
        \Laravel\Socialite\SocialiteServiceProvider::class,
        \Yajra\Datatables\DatatablesServiceProvider::class,
        \Stevebauman\Location\LocationServiceProvider::class,
        \Barryvdh\Snappy\ServiceProvider::class,
    ])
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        // channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo('/login');
        $middleware->redirectUsersTo('/');

        $middleware->validateCsrfTokens(except: [
            'xmlfeed',
        ]);

        $middleware->web(\App\Http\Middleware\LocaleMiddleware::class);

        $middleware->throttleApi();

        $middleware->group('admin', [
            'auth',
            'access.routeNeedsPermission:view-backend',
            'timeout',
        ]);

        $middleware->alias([
            'OnlyUsers' => \App\Http\Middleware\OnlyUsers::class,
            'access.routeNeedsPermission' => \App\Http\Middleware\RouteNeedsPermission::class,
            'access.routeNeedsRole' => \App\Http\Middleware\RouteNeedsRole::class,
            'checkDeletedUserOffer' => \App\Http\Middleware\CheckDeletedUserHasOffer::class,
            'checkOfferValues' => \App\Http\Middleware\CheckSessionHasOfferValues::class,
            'checkPropertyId' => \App\Http\Middleware\CheckSessionHasOfferPropertyId::class,
            'checkSignatureValues' => \App\Http\Middleware\CheckSessionHasOfferSignature::class,
            'timeout' => \App\Http\Middleware\SessionTimeout::class,
        ]);

        $middleware->priority([
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\Authenticate::class,
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Auth\Middleware\Authorize::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
