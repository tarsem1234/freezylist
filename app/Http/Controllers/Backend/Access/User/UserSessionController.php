<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Models\Access\User\User;
use App\Repositories\Backend\Access\User\UserSessionRepository;
use Illuminate\Http\RedirectResponse;

/**
 * Class UserSessionController.
 */
class UserSessionController extends Controller
{
    public function clearSession(User $user, ManageUserRequest $request, UserSessionRepository $userSessionRepository): RedirectResponse
    {
        $userSessionRepository->clearSession($user);

        return redirect()->back()->withFlashSuccess(trans('alerts.backend.users.session_cleared'));
    }
}
