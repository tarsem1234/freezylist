<?php

namespace App\Events\Backend\Access\User;

use Illuminate\Queue\SerializesModels;

/**
 * Class UserCreated.
 */
class UserCreated
{
    use SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}