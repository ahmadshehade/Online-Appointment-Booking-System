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


    public function viewAny(User $user)
    {
        return $user->hasRole(UserRoles::Provider) ||
            $user->hasRole(UserRoles::Client);
    }

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

    public function update(User $user, Category $category)
    {
        return false;
    }

    public function delete(User $user, Category $category)
    {
        return false;
    }

    public function restore(User $user, Category $category)
    {
        return false;
    }

    public function forceDelete(User $user, Category $category)
    {
        return false;
    }
}
