<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  string|null  $guard
     */
    public function handle(Request $request, Closure $next): Response
    {
        //check the value of status,If status is zero means user has deactivate in that case just logout that user and redirect to login screen
        $getUser = \App\Models\Access\User\User::where('id', Auth::id())->first();
        if (empty($getUser->status)) {
            Auth::logout();

            return redirect()->to('/login');
        }

        return $next($request);
    }
}
