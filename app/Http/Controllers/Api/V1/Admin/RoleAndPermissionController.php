<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\RoleAndPermissionService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionController extends Controller
{

    protected  RoleAndPermissionService $permissionRole;

    /**
     * Summary of __construct
     * @param \App\Services\RoleAndPermissionService $permissionRole
     */
    public function __construct(RoleAndPermissionService $permissionRole)
    {
        $this->permissionRole = $permissionRole;
    }

    public function assignRoleToUser(User $user, Role $role)
    {
        $this->permissionRole->assignRoleToUser($user, $role);
        return $this->successMessage(['success' => true], 'SuccessFully Assigned Role To User', 200);
    }

    public function removeRoleFromUser(User $user, Role $role)
    {
        $this->permissionRole->removeRoleFromUser($user, $role);
        return $this->successMessage(['success' => true], 'Successfully Remove Role From User', 200);
    }

    /**
     * Summary of assignPermissionToUser
     * @param \App\Models\User $user
     * @param \Spatie\Permission\Models\Permission $permission
     * @return void
     */
    public function assignPermissionToUser(User $user, Permission $permission)
    {
        $this->permissionRole->assignPermissionToUser($user, $permission);
        return $this->successMessage(['success' => true], 'Successfully Assign PermissionTo User', 200);
    }


    /**
     * Summary of removePermissionFromUser
     * @param \App\Models\User $user
     * @param \Spatie\Permission\Models\Permission $permission
     */
    public function removePermissionFromUser(User $user, Permission $permission)
    {
        $this->permissionRole->removePermissionFromUser($user, $permission);
        return $this->successMessage(['success' => true], 'Successfully Remove Permission From User', 200);
    }


    /**
     * Summary of userHasRole
     * @param \App\Models\User $user
     * @param string $roleName
     *
     */
    public function userHasRole(User $user, string $roleName)
    {
        $role = $this->permissionRole->userHasRole($user, $roleName);
        return $this->successMessage(['hasRole' => $role], 'Successfully checked user role', 200);
    }
    /**
     * Summary of userHasPermission
     * @param \App\Models\User $user
     * @param string $permissionName
     */
    public function userHasPermission(User $user, string $permissionName)
    {

        $permission = $this->permissionRole->userHasPermission($user, $permissionName);
        return $this->successMessage(['hasPermission' => $permission], 'Successfully checked user permission', 200);
    }


    /**
     * Summary of getUserRoles
     * @param \App\Models\User $user
     */
    public function getUserRoles(User $user)
    {

        $roles = $this->permissionRole->getUserRoles($user);
        return $this->successMessage([$roles], 'Successfully get User Roles', 200);
    }



    /**
     * Summary of createRole
     * @param string $roleName
     */
    public function createRole(string $roleName)
    {

        $data = $this->permissionRole->createRole($roleName);
        return $this->successMessage([$data], 'Successfully  CreateRole', 200);
    }


    /**
     * Summary of createPermission
     * @param string $permissionName
     */
    public function createPermission(string $permissionName)
    {
        $data = $this->permissionRole->createPermission($permissionName);
        return $this->successMessage([$data], 'Successfully Make Permission', 200);
    }


    /**
     * Summary of getUserPermissions
     * @param \App\Models\User $user
     */
    public function getUserPermissions(User $user)
    {
        $permissions = $this->permissionRole->getUserPermissions($user);
        return $this->successMessage([$permissions], 'Successfully Get All Permission To USer', 200);
    }
}
