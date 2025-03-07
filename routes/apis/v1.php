<?php

use Illuminate\Http\Request;
use App\Http\Middleware\ApiKey;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\AttributeController;
use App\Http\Controllers\Api\V1\TimeSheetController;
use App\Http\Controllers\Api\V1\AttributeValueController;
use App\Http\Controllers\Api\V1\Auth\AuthenticationController;

Route::middleware([ApiKey::class])->group(function() {
    Route::controller(AuthenticationController::class)->group(function() {
        Route::post('login', 'login');
        Route::post('register', 'register');
    });
    
    Route::middleware(['auth:api'])->group(function() {
        Route::post('logout', [AuthenticationController::class, 'logout']);
        Route::apiResource('users', UserController::class);
        Route::apiResource('projects', ProjectController::class);
        Route::apiResource('attributes', AttributeController::class);
        Route::apiResource('attributeValues', AttributeValueController::class);
        Route::apiResource('time-sheets', TimeSheetController::class);
    });
});
