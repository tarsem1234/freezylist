<?php

namespace App\Repositories\Backend\History\Facades;

use Illuminate\Support\Facades\Facade;

class History extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'history';
    }
}
