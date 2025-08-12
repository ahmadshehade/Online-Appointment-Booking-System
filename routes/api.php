<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| These routes handle user authentication processes such as
| registration, login, and logout.
|
*/

// Public routes for authentication (register and login)
Route::prefix('auth')->group(function () {
    // Register a new user
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // User login
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    //Reset Password
    Route::post('forgot-password', [PasswordResetController::class, 'sendResetPasswordEmail']);
    Route::post('reset-password', [PasswordResetController::class, 'resetPassword']);
});

// Protected route for logout - requires authentication via Sanctum middleware
Route::middleware(['auth:sanctum'])->post('/logout/{all?}', [AuthController::class, 'logout'])->name('logout');
