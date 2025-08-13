<?php

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\Api\V1\ServiceProviderController;
use Modules\Users\Http\Controllers\UsersController;



Route::middleware(['auth:sanctum'])->prefix('provider')->group(function () {

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

