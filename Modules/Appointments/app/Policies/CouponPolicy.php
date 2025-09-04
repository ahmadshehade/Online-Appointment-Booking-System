<?php

namespace Modules\Appointments\Policies;

use App\Enum\UserRoles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Appointments\Models\Coupon;

class CouponPolicy
{
    use HandlesAuthorization;



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
    public function  viewAny(User $user)
    {
        return $user->hasAnyRole([
            UserRoles::Client,
            UserRoles::Provider
        ]);
    }

    /**
     * Summary of view
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Coupon $Coupon
     * @return bool
     */
    public function view(User $user, Coupon $Coupon)
    {
        return $user->hasAnyRole([
            UserRoles::Client,
            UserRoles::Provider
        ]);
    }

    /**
     * Summary of create
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasRole(UserRoles::Provider);
    }

    /**
     * Summary of update
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Coupon $Coupon
     * @return bool
     */
    public function update(User $user, Coupon $coupon)
    {
        return $user->hasRole(UserRoles::Provider) && $user->serviceProvider->id === $coupon->service_provider_id;
    }

    /**
     * Summary of delete
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Coupon $Coupon
     * @return bool
     */
    public function delete(User $user, Coupon $coupon)
    {
        return $user->hasRole(UserRoles::Provider) && $user->serviceProvider->id === $coupon->service_provider_id;
    }


    /**
     * 
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Coupon $Coupon
     * @return bool
     */
    public function restore(User $user, Coupon $coupon)
    {
        return false;
    }


    /**
     * Summary of forceDelete
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Coupon $Coupon
     * @return bool
     */
    public function forceDelete(User $user, Coupon $coupon)
    {
        return false;
    }
}
