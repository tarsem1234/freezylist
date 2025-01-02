<?php

namespace App\Services\Access;

use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Class Access.
 */
class Access
{
    /**
     * Get the currently authenticated user or null.
     */
    public function user()
    {
        return auth()->user();
    }

    /**
     * Return if the current session user is a guest or not.
     *
     * @return mixed
     */
    public function guest()
    {
        return auth()->guest();
    }

    /**
     * @return mixed
     */
    public function logout()
    {
        event(new UserLoggedOut($this->user()));

        return auth()->logout();
    }

    /**
     * Get the currently authenticated user's id.
     *
     * @return mixed
     */
    public function id()
    {
        return auth()->id();
    }

    public function login(Authenticatable $user, bool $remember = false)
    {
        $logged_in = auth()->login($user, $remember);
        event(new UserLoggedIn($this->user()));

        return $logged_in;
    }

    /**
     * @return mixed
     */
    public function loginUsingId($id)
    {
        $logged_in = auth()->loginUsingId($id);
        event(new UserLoggedIn($this->user()));

        return $logged_in;
    }

    /**
     * Checks if the current user has a Role by its name or id.
     *
     * @param  string  $role  Role name.
     */
    public function hasRole(string $role): bool
    {
        if ($user = $this->user()) {
            return $user->hasRole($role);
        }

        return false;
    }

    /**
     * Checks if the user has either one or more, or all of an array of roles.
     */
    public function hasRoles($roles, bool $needsAll = false): bool
    {
        if ($user = $this->user()) {
            return $user->hasRoles($roles, $needsAll);
        }

        return false;
    }

    /**
     * Check if the current user has a permission by its name or id.
     *
     * @param  string  $permission  Permission name or id.
     */
    public function allow(string $permission): bool
    {
        if ($user = $this->user()) {
            return $user->allow($permission);
        }

        return false;
    }

    /**
     * Check an array of permissions and whether or not all are required to continue.
     */
    public function allowMultiple($permissions, $needsAll = false): bool
    {
        if ($user = $this->user()) {
            return $user->allowMultiple($permissions, $needsAll);
        }

        return false;
    }

    public function hasPermission($permission): bool
    {
        return $this->allow($permission);
    }

    public function hasPermissions($permissions, $needsAll = false): bool
    {
        return $this->allowMultiple($permissions, $needsAll);
    }
}
