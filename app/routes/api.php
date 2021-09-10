<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisasterController;
use App\Http\Controllers\DisasterEntryController;
use App\Http\Controllers\DisasterEntrySheetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ShelterController;
use App\Http\Controllers\StaffUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'api'], function ($router) {
    Route::group(['prefix' => 'home'], function ($router) {
        Route::get('', [HomeController::class, 'index']);
    });
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('refresh', [AuthController::class, 'refresh']);
    });
    Route::group(['prefix' => 'disasters'], function ($router) {
        Route::get('', [DisasterController::class, 'index']);
        Route::get('/current', [DisasterController::class, 'current']);
        Route::get('/{id}', [DisasterController::class, 'show']);
        Route::post('', [DisasterController::class, 'store']);
        Route::put('/{id}', [DisasterController::class, 'update']);
        Route::delete('/{id}', [DisasterController::class, 'destroy']);
        Route::get('/{id}/entry_sheets', [DisasterEntrySheetController::class, 'index']);
        Route::get('entry_sheets/{qrcode_data}/qrcode', [DisasterEntrySheetController::class, 'qrcode']);
        Route::get('entry_sheets/{id}/web', [DisasterEntrySheetController::class, 'web']);
        Route::put('entry_sheets/{id}/web', [DisasterEntrySheetController::class, 'updateWeb']);
        Route::get('entry_sheets/{id}/paper', [DisasterEntrySheetController::class, 'paper']);
        Route::put('entry_sheets/{id}/paper', [DisasterEntrySheetController::class, 'updatePaper']);
        Route::get('/{id}/entries', [DisasterEntryController::class, 'index']);
        Route::post('entry/web', [DisasterEntryController::class, 'web']);
        Route::post('entry/paper', [DisasterEntryController::class, 'paper']);
        Route::get('entries/{id}', [DisasterEntryController::class, 'show']);
        Route::post('entries/{id}/out', [DisasterEntryController::class, 'out']);
        Route::post('entries/{id}/in', [DisasterEntryController::class, 'in']);
        Route::post('entries/{id}/exit', [DisasterEntryController::class, 'exit']);
    });
    Route::group(['prefix' => 'shelters'], function ($router) {
        Route::get('', [ShelterController::class, 'index']);
        Route::get('/{id}', [ShelterController::class, 'show']);
        Route::post('', [ShelterController::class, 'store']);
        Route::put('/{id}', [ShelterController::class, 'update']);
        Route::delete('/{id}', [ShelterController::class, 'destroy']);
    });
    Route::group(['prefix' => 'notices'], function ($router) {
        Route::get('', [NoticeController::class, 'index']);
        Route::get('/{id}', [NoticeController::class, 'show']);
        Route::post('', [NoticeController::class, 'store']);
        Route::put('/{id}', [NoticeController::class, 'update']);
        Route::delete('/{id}', [NoticeController::class, 'destroy']);
    });
    Route::group(['prefix' => 'staff_users'], function ($router) {
        Route::get('', [StaffUserController::class, 'index']);
        Route::get('/{id}', [StaffUserController::class, 'show']);
        Route::post('', [StaffUserController::class, 'store']);
        Route::put('/{id}', [StaffUserController::class, 'update']);
        Route::delete('/{id}', [StaffUserController::class, 'destroy']);
    });
});

/*
|--------------------------------------------------------------------------
| API Routes - アプリ専用
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'api', 'prefix' => 'app'], function ($router) {
    Route::group(['prefix' => 'home'], function ($router) {
        Route::get('', [HomeController::class, 'index']);
    });
});
