<?php

namespace App\Models\Access\User\Traits;

use App\Notifications\Frontend\Auth\UserNeedsPasswordReset;

/**
 * Class UserSendPasswordReset.
 */
trait UserSendPasswordReset
{
    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new UserNeedsPasswordReset($token));
    }
}
