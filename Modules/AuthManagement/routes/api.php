<?php

use Illuminate\Support\Facades\Route;
use Modules\AuthManagement\Http\Controllers\AuthManagementController;
use Modules\AuthManagement\Http\Controllers\PositionController;


Route::prefix('v1/admin')->group(function () {
    Route::apiResource('positions', PositionController::class);
});

