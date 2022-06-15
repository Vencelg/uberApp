<?php

use Illuminate\Http\Request;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::delete('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::post('update', [\App\Http\Controllers\AuthController::class, 'update'])->middleware('auth:sanctum');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResources([
        'offers' => \App\Http\Controllers\OfferController::class,
        'requested_rides' => \App\Http\Controllers\RequestedRideController::class,
    ]);
});
