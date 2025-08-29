<?php

namespace Modules\Payments\Policies;

use App\Enum\UserRoles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Payments\Models\Payment;

class PaymentPolicy
{
    use HandlesAuthorization;

    /**
     * Summary of before
     * @param \App\Models\User $user
     * 
     */
    public  function before(User $user)
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
    public function viewAny(User $user)
    {
        return $user->hasAnyRole([
            UserRoles::Provider,
            UserRoles::Client,
        ]);
    }
    /**
     * Summary of view
     * @param \App\Models\User $user
     * @param \Modules\Payments\Models\Payment $payment
     * @return bool
     */
    public function view(User $user, Payment $payment)
    {
        if ($user->hasRole(UserRoles::Provider)) {
            return $payment->appointment
                && $payment->appointment->service->service_provider_id === $user->serviceProvider->id;
        }



        if ($user->hasRole(UserRoles::Client)) {
            return $payment->appointment->user_id === $user->id;
        }
        return false;
    }

    /**
     * Summary of create
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasRole(UserRoles::Client) && $user->appointments()->exists();
    }

    /**
     * Summary of update
     * @param \App\Models\User $user
     * @param \Modules\Payments\Models\Payment $payment
     * @return bool
     */
    public function update(User $user, Payment $payment)
    {
        return $user->hasRole(UserRoles::Client)
            && $payment->appointment->user_id === $user->id;
    }

    /**
     * Summary of delete
     * @param \App\Models\User $user
     * @param \Modules\Payments\Models\Payment $payment
     * @return bool
     */
    public function delete(User $user, Payment $payment): bool
    {
        return $user->hasRole(UserRoles::Client)
            && $payment->appointment->user_id === $user->id;
    }
    /**
     * Summary of restore
     * @param \App\Models\User $user
     * @param \Modules\Payments\Models\Payment $payment
     * @return bool
     */
    public function restore(User $user, Payment $payment)
    {
        return false;
    }

    /**
     * Summary of forceDelete
     * @param \App\Models\User $user
     * @param \Modules\Payments\Models\Payment $payment
     * @return bool
     */
    public function forceDelete(User $user, Payment $payment)
    {
        return false;
    }
}
