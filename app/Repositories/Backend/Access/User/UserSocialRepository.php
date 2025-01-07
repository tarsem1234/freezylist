<?php

namespace App\Repositories\Backend\Access\User;

use App\Events\Backend\Access\User\UserSocialDeleted;
use App\Exceptions\GeneralException;
use App\Models\Access\User\SocialLogin;
use App\Models\Access\User\User;

/**
 * Class UserSocialRepository.
 */
class UserSocialRepository
{
    /**
     * @throws GeneralException
     */
    public function delete(User $user, SocialLogin $social): bool
    {
        if ($user->providers()->whereId($social->id)->delete()) {
            event(new UserSocialDeleted($user, $social));

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.access.users.social_delete_error'));
    }
}
