<?php

namespace Modules\Users\Policies;

use App\Enum\UserRoles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Users\Models\AvailabilitySlot;

class AvailabilitySlotPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param \App\Models\User $user
     * @return bool|null
     */
    public function before(User $user)
    {
        if ($user->hasRole(UserRoles::SuperAdmin)) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any availability slots.
     *
     * Only providers should see the list of their own slots.
     */
    public function viewAny(User $user)
    {
        return $user->hasRole(UserRoles::Provider);
    }

    /**
     * Determine whether the user can view a specific availability slot.
     *
     * - Providers can only see their own slots.
     * - Clients can see slots (to be able to book them).
     */
    public function view(User $user, AvailabilitySlot $availabilitySlot)
    {
        if ($user->hasRole(UserRoles::Provider)) {
            return $user->serviceProvider->id === $availabilitySlot->service_provider_id;
        }

        if ($user->hasRole(UserRoles::Client)) {
            return true; 
        }

        return false;
    }

    /**
     * Determine whether the user can create availability slots.
     */
    public function create(User $user)
    {
        return $user->hasRole(UserRoles::Provider);
    }

    /**
     * Determine whether the user can update a specific availability slot.
     */
    public function update(User $user, AvailabilitySlot $availabilitySlot)
    {
        return $user->hasRole(UserRoles::Provider) &&
            $user->serviceProvider->id === $availabilitySlot->service_provider_id;
    }

    /**
     * Determine whether the user can delete a specific availability slot.
     */
    public function delete(User $user, AvailabilitySlot $availabilitySlot)
    {
        return $user->hasRole(UserRoles::Provider) &&
            $user->serviceProvider->id === $availabilitySlot->service_provider_id;
    }

    /**
     * Determine whether the user can restore a specific availability slot.
     */
    public function restore(User $user, AvailabilitySlot $availabilitySlot)
    {
        return false; 
    }

    /**
     * Determine whether the user can permanently delete a specific availability slot.
     */
    public function forceDelete(User $user, AvailabilitySlot $availabilitySlot)
    {
        return false; 
    }
}
