<?php

use Illuminate\Support\Facades\Route;
use Modules\AuthManagement\Http\Controllers\AuthManagementController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthManagementController::class, 'login']);
    Route::post('/access', [AuthManagementController::class, 'access']);
    Route::delete('/logout', [AuthManagementController::class, 'logout'])->middleware('auth:web');
});
