<?php

namespace App\Models\Access\User\Traits;

/**
 * Class UserAccess.
 */
trait UserAccess
{
    /**
     * Checks if the user has a Role by its name or id.
     *
     * @param  string  $nameOrId  Role name or id.
     */
    public function hasRole(string $nameOrId): bool
    {
        foreach ($this->roles as $role) {
            //See if role has all permissions
            if ($role->all) {
                return true;
            }

            //First check to see if it's an ID
            if (is_numeric($nameOrId)) {
                if ($role->id == $nameOrId) {
                    return true;
                }
            }

            //Otherwise check by name
            if ($role->name == $nameOrId) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks to see if user has array of roles.
     *
     * All must return true
     */
    public function hasRoles($roles, $needsAll = false): bool
    {
        //If not an array, make a one item array
        if (! is_array($roles)) {
            $roles = [$roles];
        }

        //User has to possess all of the roles specified
        if ($needsAll) {
            $hasRoles = 0;
            $numRoles = count($roles);

            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    $hasRoles++;
                }
            }

            return $numRoles == $hasRoles;
        }

        //User has to possess one of the roles specified
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if user has a permission by its name or id.
     *
     * @param  string  $nameOrId  Permission name or id.
     */
    public function allow(string $nameOrId): bool
    {
        foreach ($this->roles as $role) {
            // See if role has all permissions
            if ($role->all) {
                return true;
            }

            // Validate against the Permission table
            foreach ($role->permissions as $perm) {

                // First check to see if it's an ID
                if (is_numeric($nameOrId)) {
                    if ($perm->id == $nameOrId) {
                        return true;
                    }
                }

                // Otherwise check by name
                if ($perm->name == $nameOrId) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check an array of permissions and whether or not all are required to continue.
     */
    public function allowMultiple($permissions, $needsAll = false): bool
    {
        //If not an array, make a one item array
        if (! is_array($permissions)) {
            $permissions = [$permissions];
        }

        //User has to possess all of the permissions specified
        if ($needsAll) {
            $hasPermissions = 0;
            $numPermissions = count($permissions);

            foreach ($permissions as $perm) {
                if ($this->allow($perm)) {
                    $hasPermissions++;
                }
            }

            return $numPermissions == $hasPermissions;
        }

        //User has to possess one of the permissions specified
        foreach ($permissions as $perm) {
            if ($this->allow($perm)) {
                return true;
            }
        }

        return false;
    }

    public function hasPermission($nameOrId): bool
    {
        return $this->allow($nameOrId);
    }

    public function hasPermissions($permissions, bool $needsAll = false): bool
    {
        return $this->allowMultiple($permissions, $needsAll);
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param  mixed  $role
     */
    public function attachRole($role): void
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }

        if (is_array($role)) {
            $role = $role['id'];
        }

        $this->roles()->attach($role);
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param  mixed  $role
     */
    public function detachRole($role): void
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }

        if (is_array($role)) {
            $role = $role['id'];
        }

        $this->roles()->detach($role);
    }

    /**
     * Attach multiple roles to a user.
     *
     * @param  mixed  $roles
     */
    public function attachRoles($roles): void
    {
        foreach ($roles as $role) {
            $this->attachRole($role);
        }
    }

    /**
     * Detach multiple roles from a user.
     *
     * @param  mixed  $roles
     */
    public function detachRoles($roles): void
    {
        foreach ($roles as $role) {
            $this->detachRole($role);
        }
    }
}
