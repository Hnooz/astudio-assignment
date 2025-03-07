<?php

use App\Http\Controllers\Api\V1\Auth\AuthenticationController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\TimeSheetController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticationController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::apiResource('users', UserController::class);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('time-sheets', TimeSheetController::class);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
