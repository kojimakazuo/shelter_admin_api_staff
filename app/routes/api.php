<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShelterController;

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

Route::group(['middleware' => 'api'], function ($router) {
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('refresh', [AuthController::class, 'refresh']);
    });
    Route::group(['prefix' => 'shelters'], function ($router) {
        Route::get('', [ShelterController::class, 'index']);
        Route::post('', [ShelterController::class, 'store']);
    });
});
