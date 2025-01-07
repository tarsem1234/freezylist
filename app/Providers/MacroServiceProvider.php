<?php

namespace App\Providers;

use App\Helpers\Macros\Macros;
use Spatie\Html\HtmlServiceProvider;

/**
 * Class MacroServiceProvider.
 */
class MacroServiceProvider extends HtmlServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        parent::register();

        // $this->app->singleton('form', function ($app) {
        //     $form = new Macros($app['html'], $app['url'], $app['view'], $app['session.store']->token());

        //     return $form->setSessionStore($app['session.store']);
        // });
    }
}
