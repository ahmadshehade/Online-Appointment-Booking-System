<?php

use Illuminate\Support\Facades\Route;
use Modules\Appointments\Http\Controllers\Api\V1\AppointmentsController;
use Modules\Appointments\Http\Controllers\Api\V1\CategoryController;
use Modules\Appointments\Http\Controllers\Api\V1\CouponsController;
use Modules\Appointments\Http\Controllers\Api\V1\ServiceController;

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
