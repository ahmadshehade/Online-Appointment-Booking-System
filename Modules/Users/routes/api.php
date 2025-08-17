<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\Api\V1\AvailabilitySlotController;
use Modules\Users\Http\Controllers\Api\V1\ServiceProviderController;
use Modules\Users\Http\Controllers\UsersController;



Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('provider')->group(function () {

        Route::get('/all/{filters?}', [ServiceProviderController::class, 'index'])
            ->name('provider.index');

        Route::get('/{service_provider}', [ServiceProviderController::class, 'show'])
            ->name('provider.show');

        Route::put('/{service_provider}', [ServiceProviderController::class, 'update'])
            ->name('provider.update');

        Route::delete('/{service_provider}', [ServiceProviderController::class, 'destroy'])
            ->name('provider.destroy');

        Route::post('/add-provider', [ServiceProviderController::class, 'store'])
            ->name('provider.store');
    });





    Route::prefix('slot')->group(function () {
        Route::post('/make', [AvailabilitySlotController::class, 'store'])
            ->name('slot.make');

        Route::put('/update/{availability_slot}', [AvailabilitySlotController::class, 'update'])
            ->name('slot.update');

        Route::get('/all/{filters?}', [AvailabilitySlotController::class, 'index'])
            ->name('slot.all');

        Route::get('/{availability_slot}', [AvailabilitySlotController::class, 'show'])
            ->name('slot.show');

        Route::delete('/{availability_slot}', [AvailabilitySlotController::class, 'destroy'])
            ->name('slot.delete');
    });
});
