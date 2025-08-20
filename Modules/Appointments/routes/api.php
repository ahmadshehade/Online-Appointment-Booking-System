<?php

use Illuminate\Support\Facades\Route;
use Modules\Appointments\Http\Controllers\AppointmentsController;
use Modules\Appointments\Http\Controllers\CategoryController;

Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('categories', CategoryController::class);
    
});
