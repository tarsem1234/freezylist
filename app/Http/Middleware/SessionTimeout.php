<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SessionTimeout.
 */
class SessionTimeout
{
    /**
     * @var Store
     */
    protected $session;

    /**
     * @var mixed
     */
    protected $timeout;

    public function __construct(Store $session)
    {
        $this->session = $session;
        $this->timeout = config('session.timeout');
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (config('session.timeout_status')) {
            $isLoggedIn = $request->path() != '/logout';

            if (! session('lastActivityTime')) {
                $this->session->put('lastActivityTime', time());
            } elseif (time() - $this->session->get('lastActivityTime') > $this->timeout) {
                $this->session->forget('lastActivityTime');
                $cookie = cookie('intend', $isLoggedIn ? url()->current() : 'admin/dashboard');
                $email = $request->user()->email;
                access()->logout();

                return redirect()->route('frontend.auth.login')->withFlashWarning(trans('strings.backend.general.timeout').$this->timeout / 60 .trans('strings.backend.general.minutes'))->withInput(compact('email'))->withCookie($cookie);
            }

            $isLoggedIn ? $this->session->put('lastActivityTime', time()) : $this->session->forget('lastActivityTime');
        }

        return $next($request);
    }
}
