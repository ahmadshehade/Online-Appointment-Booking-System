<?php

namespace Modules\Appointments\Policies;

use App\Enum\UserRoles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Appointments\Models\Category;

class CategoryPolicy
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
     * Summary of viewAny
     * @param \App\Models\User $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        return $user->hasRole(UserRoles::Provider) ||
            $user->hasRole(UserRoles::Client);
    }

    /**
     * Summary of view
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Category $category
     * @return bool
     */
    public function view(User $user, Category $category)
    {
        return $user->hasRole(UserRoles::Provider) ||
            $user->hasRole(UserRoles::Client);
    }

    /**
     * Summary of create
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Summary of update
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Category $category
     * @return bool
     */
    public function update(User $user, Category $category)
    {
        return false;
    }

    /**
     * Summary of delete
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Category $category
     * @return bool
     */
    public function delete(User $user, Category $category)
    {
        return false;
    }

    /**
     * Summary of restore
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Category $category
     * @return bool
     */
    public function restore(User $user, Category $category)
    {
        return false;
    }

    /**
     * Summary of forceDelete
     * @param \App\Models\User $user
     * @param \Modules\Appointments\Models\Category $category
     * @return bool
     */
    public function forceDelete(User $user, Category $category)
    {
        return false;
    }
}
