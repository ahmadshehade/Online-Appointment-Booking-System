<?php

namespace Modules\Reviews\Policies;

use App\Enum\UserRoles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Reviews\Models\Review;
use NunoMaduro\Collision\Provider;

class ReviewPolicy
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
    public  function viewAny(User $user)
    {
        return  $user->hasAnyRole([
            UserRoles::Provider,
            UserRoles::Client,
        ]);
    }


    /**
     * Summary of view
     * @param \App\Models\User $user
     * @param \Modules\Reviews\Models\Review $review
     * @return bool
     */
    public  function view(User $user, Review $review)
    {
        return ($user->hasRole(UserRoles::Provider) &&
            $user->serviceProvider->id === $review->service_provider_id) || (
            $user->hasRole(UserRoles::Client) &&
            $user->id === $review->user_id
        );
    }


    /**
     * Summary of create
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user)
    {

        if (! $user->hasRole(UserRoles::Client)) {
            return false;
        }
        if (! $user->appointments()->where('status', 'completed')->exists()) {
            return false;
        }
        $hasAlreadyReviewed = $user->reviews()
            ->where('service_provider_id', request()->input('service_provider_id'))
            ->exists();

        return ! $hasAlreadyReviewed;
    }



    /**
     * Summary of update
     * @param \App\Models\User $user
     * @param \Modules\Reviews\Models\Review $review
     * @return bool
     */
    public function update(User $user, Review $review)
    {
        return $user->hasRole(UserRoles::Client) && $user->id === $review->user_id;
    }

    /**
     * Summary of delete
     * @param \App\Models\User $user
     * @param \Modules\Reviews\Models\Review $review
     * @return bool
     */
    public function delete(User $user, Review $review)
    {
        return $user->hasRole(UserRoles::Client) && $user->id === $review->user_id;
    }

    /**
     * Summary of restore
     * @param \App\Models\User $user
     * @param \Modules\Reviews\Models\Review $review
     * @return bool
     */
    public function restore(User $user, Review $review)
    {
        return false;
    }

    /**
     * Summary of forceDelete
     * @param \App\Models\User $user
     * @param \Modules\Reviews\Models\Review $review
     * @return bool
     */
    public function forceDelete(User $user, Review $review)
    {
        return false;
    }
}
