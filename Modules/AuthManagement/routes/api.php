<?php

use Illuminate\Support\Facades\Route;
use Modules\AuthManagement\Http\Controllers\AuthManagementController;
use Modules\AuthManagement\Http\Controllers\PositionController;
use Modules\AuthManagement\Http\Controllers\RoleController;


Route::prefix('v1')
//    ->middleware('auth.jwt') Disabled for development
    ->group(function () {

    Route::prefix('admin')->group(function () {

        Route::apiResource('positions', PositionController::class);

        Route::apiResource('roles', RoleController::class);

    });
});

