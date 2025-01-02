<?php

namespace App\Listeners\Frontend\Auth;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;

/**
 * Class UserEventListener.
 */
class UserEventListener
{
    public function onLoggedIn($event)
    {
        Log::info('User Logged In: '.$event->user->full_name);
    }

    public function onLoggedOut($event)
    {
        Log::info('User Logged Out: '.$event->user->full_name);
    }

    public function onRegistered($event)
    {
        Log::info('User Registered: '.$event->user->full_name);
    }

    public function onConfirmed($event)
    {
        Log::info('User Confirmed: '.$event->user->full_name);
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            \App\Events\Frontend\Auth\UserLoggedIn::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onLoggedIn'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserLoggedOut::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onLoggedOut'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserRegistered::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onRegistered'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserConfirmed::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onConfirmed'
        );
    }
}
