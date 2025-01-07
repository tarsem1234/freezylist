<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionHasOfferValues
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Session::get('OFFER')) {
            return redirect()->route('frontend.recieved.offers');
        }

        return $next($request);
    }
}
