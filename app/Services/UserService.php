<?php

namespace App\Services;

use App\Models\User;

use App\Notifications\BaseNotification;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;

class UserService
{

    /**
     * Summary of destroy
     * @param \App\Models\User $user
     * @return bool
     */
    public  function  destroy(User $user)
    {
        $user->notifyNow(new BaseNotification(
            'Remove User',
            'Admin removed you from the system.',
            '',
            [],
            ['mail']
        ));

        return $user->delete();
    }


    /**
     * Summary of update
     * @param \App\Models\User $user
     * @param array $data
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return User
     */
    public function update(User $user, array $data)
    {
        try {
            if ($data["password"]) {
                $data["password"] = Hash::make($data["password"]);
            }
            $user->update($data);
            return $user;
        } catch (\Exception $e) {
            throw new HttpResponseException(
                response()->json([
                    "error" => $e->getMessage(),
                ], 500)
            );
        }
    }


    /**
     * Summary of get
     * @param \App\Models\User $user
     * @return User
     */
    public  function   get(User $user)
    {

        return $user;
    }

    /**
     * Summary of gatAll
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Collection<int, User>
     */
    public function getAll(array $filters = [])
    {
        $users = User::with('roles');

        if (!empty($filters['role'])) {
            $roles = is_array($filters['role']) ? $filters['role'] : [$filters['role']];
            $users->whereHas('roles', function ($query) use ($roles) {
                $query->whereIn('name', $roles);
            });
        }

        return $users->get();
    }
}
