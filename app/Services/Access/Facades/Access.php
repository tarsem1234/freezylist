<?php

namespace App\Services\Access\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Access.
 */
class Access extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'access';
    }
}
