<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\ChangePasswordRequest;
use App\Repositories\Frontend\Access\User\UserRepository;
use Illuminate\Http\RedirectResponse;

/**
 * Class ChangePasswordController.
 */
class ChangePasswordController extends Controller
{
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

    public function changePassword(ChangePasswordRequest $request): RedirectResponse
    {
        $this->user->changePassword($request->only('old_password', 'password'));

        return redirect()->route('frontend.user.account')->withFlashSuccess(trans('strings.frontend.user.password_updated'));
    }
}
