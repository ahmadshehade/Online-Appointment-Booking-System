<?php

namespace Modules\Appointments\Policies;

use App\Enum\UserRoles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Appointments\Models\Appointment;

class AppointmentPolicy
{
    use HandlesAuthorization;


    /**
     * Summary of isOwnerOrProvider
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Appointment $appointment
     * @return bool
     */
    protected function isOwnerOrProvider(User $user, Appointment $appointment): bool
    {
        if ($user->hasRole(UserRoles::Provider->value) && $user->serviceProvider) {
            return $user->serviceProvider
                ->availabilitySlots()
                ->where('id', $appointment->availability_slot_id)
                ->exists();
        }

        return $user->hasRole(UserRoles::Client->value) && $user->id === $appointment->user_id;
    }



    /**
     * Summary of before
     * @param \App\Models\User $user
     * 
     */
    public function  before(User $user)
    {
        if ($user->hasRole(UserRoles::SuperAdmin)) {
            return true;
        }
    }

    /**
     * Summary of viewAny
     * @param \App\Models\User $user
     * @return bool
     */
    public  function  viewAny(User $user)
    {
        return $user->hasAnyRole([
            UserRoles::Provider,
            UserRoles::Client,
        ]);
    }

    /**
     * Summary of view
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Appointment $appointment
     * @return bool
     */
    public function view(User $user, Appointment $appointment)
    {
        return $this->isOwnerOrProvider($user, $appointment);
    }

    /**
     * Summary of create
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasRole(UserRoles::Client);
    }

    /**
     * Summary of update
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Appointment $appointment
     * @return bool
     */
    public function  update(User $user, Appointment $appointment)
    {

        return $this->isOwnerOrProvider($user, $appointment);
    }

    /**
     * Summary of delete
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Appointment $appointment
     * @return bool
     */
    public function delete(User $user, Appointment $appointment)
    {
        return $this->isOwnerOrProvider($user, $appointment);
    }
    /**
     * Summary of restore
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Appointment $appointment
     * 
     */
    public function restore(User $user, Appointment $appointment)
    {
        //
    }

    /**
     * Summary of forceDelete
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Appointment $appointment
     * 
     */
    public function forceDelete(User $user, Appointment $appointment)
    {
        //
    }
}
