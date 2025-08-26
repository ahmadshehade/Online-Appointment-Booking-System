<?php

use Illuminate\Support\Facades\Route;
use Modules\Appointments\Http\Controllers\AppointmentsController;
use Modules\Appointments\Http\Controllers\CategoryController;
use Modules\Appointments\Http\Controllers\CouponsController;
use Modules\Appointments\Http\Controllers\ServiceController;

Route::middleware(['auth:sanctum'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Category Routes
    |--------------------------------------------------------------------------
    */
    Route::apiResource('categories', CategoryController::class);

    /*
    |--------------------------------------------------------------------------
    | Service Routes
    |--------------------------------------------------------------------------
    */
    Route::apiResource('services', ServiceController::class);

    /*
    |--------------------------------------------------------------------------
    | Coupon Routes
    |--------------------------------------------------------------------------
    */
    Route::apiResource('coupons', CouponsController::class);

    /*
    |--------------------------------------------------------------------------
    | Coupon Routes
    |--------------------------------------------------------------------------
    */
    Route::apiResource('appointments', AppointmentsController::class);
});
