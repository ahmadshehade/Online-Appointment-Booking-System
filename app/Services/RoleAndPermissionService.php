<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionService
{
    /**
     * Summary of assignRoleToUser
     * @param \App\Models\User $user
     * @param \Spatie\Permission\Models\Role $role
     * @return bool
     */
    public function assignRoleToUser(User $user, Role $role): bool
    {
        $user->assignRole($role->name);
        return $user->hasRole($role->name);
    }

    /**
     * Summary of removeRoleFromUser
     * @param \App\Models\User $user
     * @param \Spatie\Permission\Models\Role $role
     * @return bool
     */
    public function removeRoleFromUser(User $user, Role $role): bool
    {
        $user->removeRole($role->name);
        return !$user->hasRole($role->name);
    }

    /**
     * Summary of assignPermissionToUser
     * @param \App\Models\User $user
     * @param \Spatie\Permission\Models\Permission $permission
     * @return bool
     */
    public function assignPermissionToUser(User $user, Permission $permission): bool
    {
        $user->givePermissionTo($permission->name);
        return $user->can($permission->name);
    }

    /**
     * Summary of removePermissionFromUser
     * @param \App\Models\User $user
     * @param \Spatie\Permission\Models\Permission $permission
     * @return bool
     */
    public function removePermissionFromUser(User $user, Permission $permission): bool
    {
        $user->revokePermissionTo($permission->name);
        return !$user->can($permission->name);
    }

    /**
     * Summary of userHasRole
     * @param \App\Models\User $user
     * @param string $roleName
     * @return bool
     */
    public function userHasRole(User $user, string $roleName): bool
    {
        return $user->hasRole($roleName);
    }

    /**
     * Summary of userHasPermission
     * @param \App\Models\User $user
     * @param string $permissionName
     * @return bool
     */
    public function userHasPermission(User $user, string $permissionName): bool
    {
        return $user->can($permissionName);
    }

    /**
     * Summary of getUserRoles
     * @param \App\Models\User $user
     * @return array
     */
    public function getUserRoles(User $user): array
    {
        return $user->getRoleNames()->toArray();
    }

    /**
     * Summary of getUserPermissions
     * @param \App\Models\User $user
     * @return array
     */
    public function getUserPermissions(User $user): array
    {
        return $user->getAllPermissions()->pluck('name')->toArray();
    }

    /**
     * Summary of createRole
     * @param string $roleName
     * @return Role
     */
    public function createRole(string $roleName): Role
    {
        return Role::firstOrCreate([
            'name' => $roleName,
            'guard_name' => 'web'
        ]);
    }

    /**
     * Summary of createPermission
     * @param string $permissionName
     * @return Permission
     */
    public function createPermission(string $permissionName): Permission
    {
        return Permission::firstOrCreate([
            'name' => $permissionName,
            'guard_name' => 'web'
        ]);
    }
}
