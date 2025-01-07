<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Repositories\Frontend\Access\User\UserRepository;
use Illuminate\Http\RedirectResponse;

/**
 * Class ConfirmAccountController.
 */
class ConfirmAccountController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * ConfirmAccountController constructor.
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function confirm($token): RedirectResponse
    {
        $this->user->confirmAccount($token);

        return redirect()->route('frontend.auth.login')->withFlashSuccess(trans('exceptions.frontend.auth.confirmation.success'));
    }

    public function sendConfirmationEmail(User $user): RedirectResponse
    {
        $username = '';
        if ($user->user_profile()->exists()) {
            //firstname and last name not getting directly
            $userProfile = \App\Models\UserProfile::where('user_id', $user->id)->first();

            $username = $userProfile->first_name.' '.$userProfile->last_name;
        } elseif ($user->business_profile()->exists()) {
            $businessProfile = \App\Models\BusinessProfile::where('user_id', $user->id)->first();
            $username = $businessProfile->company_name;
        }
        $user->notify(new UserNeedsConfirmation($user->confirmation_code, $username));

        return redirect()->route('frontend.auth.login')->withFlashSuccess(trans('exceptions.frontend.auth.confirmation.resent'));
    }
}
