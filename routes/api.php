<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthenticationController;
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

Route::prefix('activity')->group(function () {
    Route::post('', [ActivityController::class, 'store']);
    Route::put('{id}', [ActivityController::class, 'update']);
});

Route::prefix('user')->group(function () {
    Route::post('{id}/activity', [ActivityController::class, 'storeOne']);
    Route::put('{userId}/activity/{activityId}', [ActivityController::class, 'updateOne']);
});
