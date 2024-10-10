<?php

use App\Http\Controllers\application\CompaniesControllerApplication;
use App\Http\Controllers\application\CurrencyControllerApplication;
use App\Http\Controllers\application\EstateControllerApplication;
use App\Http\Controllers\application\FavoriteControllerApplication;
use App\Http\Controllers\application\NewsControllerApplication;
use App\Http\Controllers\application\NotificationControllerApplication;
use App\Http\Controllers\application\OrderControllerApplication;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\web\CompaniesControllerWeb;
use App\Http\Controllers\web\CurrencyControllerWeb;
use App\Http\Controllers\web\EstateControllerWeb;
use App\Http\Controllers\web\NewsControllerWeb;
use App\Http\Controllers\Web\NotificationControllerWeb;
use App\Http\Controllers\web\OrderControllerWeb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//////////////////////without auth

    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('signin', [AuthController::class, 'signin']);
    Route::post('forgetPassword', [AuthController::class, 'forgetPassword']);
    Route::put('resetPassword',[AuthController::class,'resetPassword']);
    Route::get('appInfo',[AuthController::class,'appInfo']);



////////////////////with auth

Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout',[AuthController::class,'logout']);
    Route::put('verifyAcount',[AuthController::class,'verifyAcount']);
    Route::get('userInfo',[AuthController::class,'userInfo']);
    Route::post('updateInfo',[AuthController::class,'updateInfo']);
    Route::get('allUser',[AuthController::class,'allUser']);
});
