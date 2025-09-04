<?php

use Illuminate\Support\Facades\Route;
use Modules\Payments\Http\Controllers\Api\V1\PaymentsController;

Route::middleware(['auth:sanctum'])->group(function () {
    /*
|--------------------------------------------------------------------------
| Payments API Routes
|--------------------------------------------------------------------------
|
| These routes handle all payment-related actions.
| Access is protected using Sanctum authentication.
| 
| Routes included:
|   - GET     /payments           -> index
|   - POST    /payments           -> store
|   - GET     /payments/{payment} -> show
|   - PUT     /payments/{payment} -> update
|   - DELETE  /payments/{payment} -> destroy
|
*/
    Route::apiResource('payments', PaymentsController::class);
});
