<?php

use App\Enum\UserRoles;
use App\Http\Controllers\Api\V1\Admin\RoleAndPermissionController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| These routes handle user authentication processes such as
| registration, login, logout, and password reset.
|
*/

// Public routes for authentication
Route::prefix('auth')->group(function () {
    // Register a new user
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // User login
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Password reset
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetPasswordEmail']);
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
});

// Protected route for logout (requires authentication via Sanctum middleware)
Route::middleware(['auth:sanctum'])->post('/logout/{all?}', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Admin Routes: Role & Permission Management
|--------------------------------------------------------------------------
|
| Routes for managing roles and permissions assigned to users.
| Protected routes, should be accessible only by authorized admins.
|
*/
Route::prefix('admin')->middleware(['auth:sanctum', 'can:access-admin'])->group(function () {

    // ----------------------
    // Role Management
    // ----------------------
    Route::post('users/{user}/roles/{role}/assign', [RoleAndPermissionController::class, 'assignRoleToUser']);
    Route::post('users/{user}/roles/{role}/remove', [RoleAndPermissionController::class, 'removeRoleFromUser']);
    Route::get('users/{user}/roles', [RoleAndPermissionController::class, 'getUserRoles']);
    Route::post('roles/create/{roleName}', [RoleAndPermissionController::class, 'createRole']);
    Route::get('users/{user}/roles/check/{roleName}', [RoleAndPermissionController::class, 'userHasRole']);

    // ----------------------
    // Permission Management
    // ----------------------
    Route::post('users/{user}/permissions/{permission}/assign', [RoleAndPermissionController::class, 'assignPermissionToUser']);
    Route::post('users/{user}/permissions/{permission}/remove', [RoleAndPermissionController::class, 'removePermissionFromUser']);
    Route::get('users/{user}/permissions', [RoleAndPermissionController::class, 'getUserPermissions']);
    Route::get('users/{user}/permissions/check/{permissionName}', [RoleAndPermissionController::class, 'userHasPermission']);
    Route::post('permissions/create/{permissionName}', [RoleAndPermissionController::class, 'createPermission']);
});
