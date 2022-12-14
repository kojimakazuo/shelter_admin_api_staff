<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DisasterController;
use App\Http\Controllers\DisasterEntryController;
use App\Http\Controllers\DisasterEntrySheetController;
use App\Http\Controllers\DisasterShelterStaffsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NativeAppController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\ShelterController;
use App\Http\Controllers\FacilityController;
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
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
    Route::group(['prefix' => 'disasters'], function ($router) {
        Route::get('', [DisasterController::class, 'index']);
        Route::get('/current', [DisasterController::class, 'current']);
        Route::get('/{id}', [DisasterController::class, 'show']);
        Route::post('', [DisasterController::class, 'store']);
        Route::put('/{id}', [DisasterController::class, 'update']);
        Route::put('/close/{id}', [DisasterController::class, 'close']);
        Route::put('/reopen/{id}', [DisasterController::class, 'reopen']);
        Route::delete('/{id}', [DisasterController::class, 'destroy']);
        Route::get('/{id}/entry_sheets', [DisasterEntrySheetController::class, 'index']);
        Route::get('entry_sheets/qrcode/{value}', [DisasterEntrySheetController::class, 'qrcode']);
        Route::get('entry_sheets/{id}/web', [DisasterEntrySheetController::class, 'web']);
        Route::put('entry_sheets/{id}/web', [DisasterEntrySheetController::class, 'updateWeb']);
        Route::get('entry_sheets/{id}/paper', [DisasterEntrySheetController::class, 'paper']);
        Route::put('entry_sheets/{id}/paper', [DisasterEntrySheetController::class, 'updatePaper']);
        Route::get('/{id}/entries', [DisasterEntryController::class, 'index']);
        Route::post('entry/web', [DisasterEntryController::class, 'web']);
        Route::post('entry/paper', [DisasterEntryController::class, 'paper']);
        Route::get('entries/{id}', [DisasterEntryController::class, 'show']);
        Route::get('entries/qrcode/{value}', [DisasterEntryController::class, 'qrcode']);
        Route::post('entries/{id}/out', [DisasterEntryController::class, 'out']);
        Route::post('entries/{id}/in', [DisasterEntryController::class, 'in']);
        Route::post('entries/{id}/exit', [DisasterEntryController::class, 'exit']);
        Route::get('/current2', [DisasterController::class, 'current']);
        Route::get('staff/test', [DisasterShelterStaffsController::class, 'test']);
        Route::get('staff/{shalter_id}', [DisasterShelterStaffsController::class, 'index']);
        Route::post('staff/{shalter_id}/{id}', [DisasterShelterStaffsController::class, 'update']);    
        //????????????Route::delete('staff/close', [DisasterShelterStaffController::class, 'close']);
    });
    Route::group(['prefix' => 'shelters'], function ($router) {
        Route::get('', [ShelterController::class, 'index']);
        Route::get('/{id}', [ShelterController::class, 'show']);
        Route::post('', [ShelterController::class, 'store']);
        Route::put('/{id}', [ShelterController::class, 'update']);
        Route::delete('/{id}', [ShelterController::class, 'destroy']);
        Route::post('/{id}/shellter_images', [ShelterController::class, 'storeShelterImage']);
        Route::delete('/{id}/shellter_images/{image_id}', [ShelterController::class, 'destroyShelterImage']);
    });
    Route::group(['prefix' => 'facilities'], function ($router) {
        Route::get('', [FacilityController::class, 'index']);
        Route::get('/{id}', [FacilityController::class, 'show']);
        Route::post('', [FacilityController::class, 'store']);
        Route::put('/{id}', [FacilityController::class, 'update']);
        Route::delete('/{id}', [FacilityController::class, 'destroy']);
        Route::put('/{id}/image', [FacilityController::class, 'updateImage']);
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
    Route::group(['prefix' => 'native_apps'], function ($router) {
        Route::get('', [NativeAppController::class, 'index']);
        Route::get('/download_url/android/{path}', [NativeAppController::class, 'androidDownloadUrl']);
    });
});

/*
|--------------------------------------------------------------------------
| API Routes - ???????????????
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => 'api', 'prefix' => 'app'], function ($router) {
    Route::group(['prefix' => 'home'], function ($router) {
        Route::get('', [HomeController::class, 'index']);
    });
});
