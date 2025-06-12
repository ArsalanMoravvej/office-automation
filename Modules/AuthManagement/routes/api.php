<?php

use Illuminate\Support\Facades\Route;
use Modules\AuthManagement\Http\Controllers\AuthManagementController;
use Modules\AuthManagement\Http\Controllers\PositionController;
use Modules\AuthManagement\Http\Controllers\RoleController;
use Modules\AuthManagement\Http\Controllers\UserController;


Route::prefix('v1')
//    ->middleware('auth.jwt') Disabled for development
    ->group(function () {

    Route::prefix('admin')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::apiResource('positions', PositionController::class)->names('admin.positions');
        Route::apiResource('roles', RoleController::class)->names('admin.roles');

    });
});

