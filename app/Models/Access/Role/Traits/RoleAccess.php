<?php

namespace App\Models\Access\Role\Traits;

/**
 * Class RoleAccess.
 */
trait RoleAccess
{
    /**
     * Save the inputted permissions.
     *
     * @param  mixed  $inputPermissions
     */
    public function savePermissions($inputPermissions): void
    {
        if (! empty($inputPermissions)) {
            $this->permissions()->sync($inputPermissions);
        } else {
            $this->permissions()->detach();
        }
    }

    /**
     * Attach permission to current role.
     *
     * @param  object|array  $permission
     */
    public function attachPermission($permission): void
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }

        if (is_array($permission)) {
            $permission = $permission['id'];
        }

        $this->permissions()->attach($permission);
    }

    /**
     * Detach permission form current role.
     *
     * @param  object|array  $permission
     */
    public function detachPermission($permission): void
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }

        if (is_array($permission)) {
            $permission = $permission['id'];
        }

        $this->permissions()->detach($permission);
    }

    /**
     * Attach multiple permissions to current role.
     *
     * @param  mixed  $permissions
     */
    public function attachPermissions($permissions): void
    {
        foreach ($permissions as $permission) {
            $this->attachPermission($permission);
        }
    }

    /**
     * Detach multiple permissions from current role.
     *
     * @param  mixed  $permissions
     */
    public function detachPermissions($permissions): void
    {
        foreach ($permissions as $permission) {
            $this->detachPermission($permission);
        }
    }
}
