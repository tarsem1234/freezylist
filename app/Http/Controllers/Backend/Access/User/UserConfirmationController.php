<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Models\Access\User\User;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Repositories\Backend\Access\User\UserRepository;
use Illuminate\Http\RedirectResponse;

/**
 * Class UserConfirmationController.
 */
class UserConfirmationController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function sendConfirmationEmail(User $user, ManageUserRequest $request): RedirectResponse
    {

        // Shouldn't allow users to confirm their own accounts when the application is set to manual confirmation
        if (config('access.users.requires_approval')) {
            return redirect()->back()->withFlashDanger(trans('alerts.backend.users.cant_resend_confirmation'));
        }
        $username = '';
        if ($user->user_profile()->exists()) {
            $username = getFullName($user);
        } elseif ($user->business_profile()->exists()) {
            $username = getFullName($user);
        }
        $user->notify(new UserNeedsConfirmation($user->confirmation_code, $username));

        return redirect()->back()->withFlashSuccess(trans('alerts.backend.users.confirmation_email'));
    }

    public function confirm(User $user, ManageUserRequest $request): RedirectResponse
    {
        $this->users->confirm($user);

        return redirect()->back()->withFlashSuccess(trans('alerts.backend.users.confirmed'));
    }

    public function unconfirm(User $user, ManageUserRequest $request): RedirectResponse
    {
        $this->users->unconfirm($user);

        return redirect()->back()->withFlashSuccess(trans('alerts.backend.users.unconfirmed'));
    }
}
