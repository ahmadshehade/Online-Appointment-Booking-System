<?php

use Illuminate\Support\Facades\Route;
use Modules\Reviews\Http\Controllers\ReviewsController;

Route::middleware(['auth:sanctum'])->group(function () {
    /*
|--------------------------------------------------------------------------
| Reviews API Routes
|--------------------------------------------------------------------------
|
| These routes handle all review-related actions.
| Access is protected using Sanctum authentication.
| 
| Routes included:
|   - GET     /Reviews           -> index
|   - POST    /Reviews           -> store
|   - GET     /Reviews/{review} -> show
|   - PUT     /Reviews/{review} -> update
|   - DELETE  /Reviews/{review} -> destroy
|
*/

    Route::apiResource('reviews', ReviewsController::class);
});
