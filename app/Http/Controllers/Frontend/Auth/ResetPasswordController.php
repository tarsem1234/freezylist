<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Access\User\UserRepository;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Class ResetPasswordController.
 */
class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * ChangePasswordController constructor.
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(?string $token = null)
    {

        if (! $token) {
            return redirect()->route('frontend.auth.password.email');
        }

        $user = $this->user->findByPasswordResetToken($token);

        if ($user && app()->make('auth.password.broker')->tokenExists($user, $token)) {
            return view('frontend.auth.passwords.reset')
                ->with('token', $token)
                ->with('email', $user->email);
        }

        return redirect()->route('frontend.auth.password.email')
            ->withFlashDanger(trans('exceptions.frontend.auth.password.reset_problem'));
    }

    /**
     * Get the response for a successful password reset.
     */
    protected function sendResetResponse(Request $request, string $response): RedirectResponse
    {
        return redirect()->route(homeRoute())->withFlashSuccess(trans($response));
    }
}
