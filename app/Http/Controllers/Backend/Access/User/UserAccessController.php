<?php

namespace App\Http\Controllers\Backend\Access\User;

use App\Exceptions\GeneralException;
use App\Helpers\Auth\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\ManageUserRequest;
use App\Models\Access\User\User;
use Illuminate\Http\RedirectResponse;

/**
 * Class UserAccessController.
 */
class UserAccessController extends Controller
{
    /**
     * @throws GeneralException
     */
    public function loginAs(User $user, ManageUserRequest $request): RedirectResponse
    {
        // Overwrite who we're logging in as, if we're already logged in as someone else.
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            // Let's not try to login as ourselves.
            if (access()->id() == $user->id || session()->get('admin_user_id') == $user->id) {
                throw new GeneralException('Do not try to login as yourself.');
            }

            // Overwrite temp user ID.
            session(['temp_user_id' => $user->id]);

            // Login.
            access()->loginUsingId($user->id);

            // Redirect.
            return redirect()->route(homeRoute());
        }

        app()->make(Auth::class)->flushTempSession();

        // Won't break, but don't let them "Login As" themselves
        if (access()->id() == $user->id) {
            throw new GeneralException('Do not try to login as yourself.');
        }

        // Add new session variables
        session(['admin_user_id' => access()->id()]);
        session(['admin_user_name' => access()->user()->full_name]);
        session(['temp_user_id' => $user->id]);

        // Login user
        access()->loginUsingId($user->id);

        // Redirect to frontend
        return redirect()->route(homeRoute());
    }
}
