<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateInfoRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthorizesRequests;

    protected UserService $user;

    /**
     * Summary of __construct
     * @param \App\Services\UserService $user
     */
    public function __construct(UserService $user)
    {
        $this->user = $user;
    }


    /**
     * Summary of index
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',User::class);
        $filters = $request->only(['role']);

        $users = $this->user->getAll($filters);

        return $this->successMessage([$users], 'Successfully Get All Users', 200);
    }


    /**
     * Summary of update
     * @param \App\Http\Requests\User\UserUpdateInfoRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateInfoRequest $request, User $user)
    {
        $this->authorize('update',$user);
        $user = $this->user->update($user, $request->validated());

        return $this->successMessage([$user], 'Successfully updated user information', 200);
    }


    /**
     * Summary of destroy
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $this->authorize('delete',$user);
        $this->user->destroy($user);
        return $this->successMessage(['success' => true], 'Successfully Delete User', 200);
    }

    /**
     * Summary of show
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        $this->authorize('view',$user);
        $data = $this->user->get($user);
        return $this->successMessage([$data], 'Successfully Get User Informations', 200);
    }
}
