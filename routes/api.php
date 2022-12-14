<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthenticationController::class, 'login']);
    Route::post('signup', [AuthenticationController::class, 'signup']);
    Route::post('logout', [AuthenticationController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('super.admin')->group(function () {
        Route::prefix('activity')->group(function () {
            Route::get('', [ActivityController::class, 'index']);
            Route::post('', [ActivityController::class, 'store']);
            Route::put('{id}', [ActivityController::class, 'update']);
            Route::delete('{id}', [ActivityController::class, 'destroy']);
        });

        Route::prefix('user')->group(function () {
            Route::get('', [UserController::class, 'index']);
            Route::get('{id}/activities', [ActivityController::class, 'getUserActivities']);
            Route::put('{id}/activity/{activityId}', [ActivityController::class, 'updateOne']);
        });
    });

    Route::get('user/activities/get-by-date', [ActivityController::class, 'fetchByDate']);
});
