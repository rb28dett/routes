<?php

namespace RB28DETT\Routes\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use RB28DETT\Users\Models\User;

class RoutePolicy
{
    use HandlesAuthorization;

    /**
     * Filters the authoritzation.
     *
     * @param mixed $user
     * @param mixed $ability
     */
    public function before($user, $ability)
    {
        if (User::findOrFail($user->id)->superAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the current user can access statistics moule.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function access($user)
    {
        return User::findOrFail($user->id)->hasPermission('rb28dett::routes.access');
    }
}
