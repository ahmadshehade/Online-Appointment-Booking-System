<?php

namespace Modules\Users\Policies;

use App\Enum\UserRoles;
use App\Models\User;
use Modules\Users\Models\ServiceProvider;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceProviderPolicy
{
    use HandlesAuthorization;

    /**
     * Summary of before
     * @param \App\Models\User $user
     *
     */
    public function before(User $user)
    {

        if ($user->hasRole(UserRoles::SuperAdmin)) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any service providers.
     */
    public function viewAny(User $user)
    {

        return false;
    }

    /**
     * Determine whether the user can view the service provider.
     */
    public function view(User $user, ServiceProvider $serviceProvider)
    {

        return $user->hasRole(UserRoles::Provider) &&
            $user->id === $serviceProvider->user_id;
    }

    /**
     * Determine whether the user can create service providers.
     */
    public function create(User $user)
    {

        return $user->hasRole(UserRoles::Provider);
    }

    /**
     * Determine whether the user can update the service provider.
     */
    public function update(User $user, ServiceProvider $serviceProvider)
    {

        return $user->id === $serviceProvider->user_id &&
            $user->hasRole(UserRoles::Provider);
    }

    /**
     * Determine whether the user can delete the service provider.
     */
    public function delete(User $user, ServiceProvider $serviceProvider)
    {

        return $user->id === $serviceProvider->user_id &&
            $user->hasRole(UserRoles::Provider);
    }
}
