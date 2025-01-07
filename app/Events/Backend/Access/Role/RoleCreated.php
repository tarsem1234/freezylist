<?php

namespace App\Events\Backend\Access\Role;

use Illuminate\Queue\SerializesModels;

/**
 * Class RoleCreated.
 */
class RoleCreated
{
    use SerializesModels;

    public $role;

    public function __construct($role)
    {
        $this->role = $role;
    }
}
