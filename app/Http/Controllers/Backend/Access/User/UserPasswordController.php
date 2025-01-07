<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserPasswordRequest;
use App\Models\Access\User\User;
use App\Repositories\Backend\Access\User\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class UserPasswordController.
 */
class UserPasswordController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function edit(User $user, ManageUserRequest $request): View
    {
        $admin = false;
        $business = false;
        if ($user->hasRole(config('constant.user_type.3')) && ! ($user->hasRole(config('constant.user_type.2')))) {

        }
        if ($user->hasRole(config('constant.user_type.2')) && ! $user->hasRole(config('constant.user_type.3'))) {
            $business = true;
        }
        if ($user->hasRole(config('constant.user_type.2')) && $user->hasRole(config('constant.user_type.3'))) {
            $admin = true;
        }

        return view('backend.access.change-password',
            compact('admin', 'business'))
            ->with('user', $user);
    }

    public function update(User $user, UpdateUserPasswordRequest $request): RedirectResponse
    {
        $this->users->updatePassword($user, $request->only('password'));

        if ($user->hasRole(config('constant.user_type.3')) && ! ($user->hasRole(config('constant.user_type.2'))) && ! $user->hasRole(config('constant.user_type.4'))) {
            return redirect()->route('admin.access.user.index')->withFlashSuccess(trans('alerts.backend.users.updated_password'));
        }
        if ($user->hasRole(config('constant.user_type.2')) && ! $user->hasRole(config('constant.user_type.3')) && ! $user->hasRole(config('constant.user_type.4'))) {
            return redirect()->route('admin.access.business.index')->withFlashSuccess(trans('alerts.backend.users.updated_password'));
        }
        if ($user->hasRole(config('constant.user_type.4')) && ! $user->hasRole(config('constant.user_type.2')) && ! $user->hasRole(config('constant.user_type.3'))) {
            return redirect()->route('admin.access.support.index')->withFlashSuccess(trans('alerts.backend.users.updated_password'));
        }
        if ($user->hasRole(config('constant.user_type.2')) && $user->hasRole(config('constant.user_type.3')) && $user->hasRole(config('constant.user_type.4'))) {
            return redirect()->route('admin.access.admin.index')->withFlashSuccess(trans('alerts.backend.users.updated_password'));
        }

        return redirect()->back()->withFlashDanger(trans('alerts.backend.users.updated_password_not'));
    }
}
