<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionService
{
    public function assignRoleToUser(User $user, Role $role): bool
    {
        $user->assignRole($role->name);
        return $user->hasRole($role->name);
    }

    public function removeRoleFromUser(User $user, Role $role): bool
    {
        $user->removeRole($role->name);
        return !$user->hasRole($role->name);
    }

    public function assignPermissionToUser(User $user, Permission $permission): bool
    {
        $user->givePermissionTo($permission->name);
        return $user->can($permission->name);
    }

    public function removePermissionFromUser(User $user, Permission $permission): bool
    {
        $user->revokePermissionTo($permission->name);
        return !$user->can($permission->name);
    }

    public function userHasRole(User $user, string $roleName): bool
    {
        return $user->hasRole($roleName);
    }

    public function userHasPermission(User $user, string $permissionName): bool
    {
        return $user->can($permissionName);
    }

    public function getUserRoles(User $user): array
    {
        return $user->getRoleNames()->toArray();
    }

    public function getUserPermissions(User $user): array
    {
        return $user->getAllPermissions()->pluck('name')->toArray();
    }

    public function createRole(string $roleName): Role
    {
        return Role::firstOrCreate([
            'name' => $roleName,
            'guard_name' => 'web'
        ]);
    }

    public function createPermission(string $permissionName): Permission
    {
        return Permission::firstOrCreate([
            'name' => $permissionName,
            'guard_name' => 'web'
        ]);
    }
}
