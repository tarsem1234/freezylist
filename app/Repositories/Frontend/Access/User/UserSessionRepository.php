<?php

namespace App\Repositories\Frontend\Access\User;

use App\Models\Access\User\User;

/**
 * Class UserSessionRepository.
 */
class UserSessionRepository
{
    /**
     * @return mixed
     */
    public function clearSessionExceptCurrent(User $user)
    {
        if (config('session.driver') == 'database') {
            return $user->sessions()
                ->where('user_id', $user->id)
                ->where('user_id', '<>', session()->getId())
                ->delete();
            // return $user->sessions()
            //     ->where('id', '<>', session()->getId())
            //     ->delete();
        }

        // If session driver not database, do nothing
        return false;
    }
}
