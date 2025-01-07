<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RouteNeedsRole.
 */
class RouteNeedsPermission
{
    public function handle(Request $request, Closure $next, $permission, bool $needsAll = false): Response
    {
        /*
         * Permission array
         */
        if (strpos($permission, ';') !== false) {
            $permissions = explode(';', $permission);
            $access = access()->allowMultiple($permissions, ($needsAll === 'true' ? true : false));
        } else {
            /**
             * Single permission.
             */
            $access = access()->allow($permission);
        }

        if (! $access) {
            return redirect()
                ->route(homeRoute())
                ->withFlashDanger(trans('auth.general_error'));
        }

        return $next($request);
    }
}
