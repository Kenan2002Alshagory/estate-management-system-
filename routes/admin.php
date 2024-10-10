<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\web\CompaniesControllerWeb;
use App\Http\Controllers\web\CurrencyControllerWeb;
use App\Http\Controllers\web\EstateControllerWeb;
use App\Http\Controllers\web\NewsControllerWeb;
use App\Http\Controllers\Web\NotificationControllerWeb;
use App\Http\Controllers\web\OrderControllerWeb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


////////////////////with auth 

Route::middleware(['auth:sanctum','is_admin'])->group(function () {

        //////////////////News 

        Route::controller(NewsControllerWeb::class)->group(function () {
            Route::post('createNews', 'createNews');
            Route::get('allNews', 'allNews');
            Route::get('detailsForNews/{id}', 'detailsForNews');
            Route::delete('deleteNews/{id}', 'deleteNews');
        });

        /////////////////Companies

        Route::controller(CompaniesControllerWeb::class)->group(function () {
            Route::get('companies/{type}/{name?}', 'companies');
            Route::post('createCompany', 'createCompany');
            Route::get('detailCompany/{id}', 'detailCompany');
            Route::put('blockCompany/{id}', 'blockCompany');
            Route::delete('deleteCompany/{id}', 'deleteCompany');
        });

         //////////////////Notification
        
        Route::controller(NotificationControllerWeb::class)->group(function () {
            Route::get('allNoti', 'allNoti');
        });
        
         //////////////////promotionOrder

        Route::controller(OrderControllerWeb::class)->group(function () {
            Route::get('allPromotionOrder', 'allPromotionOrder');
            Route::delete('acceptOrRejectOrder/{type}/{id}', 'acceptOrRejectOrder');
        });

         ////////////////Users

        Route::controller(AuthController::class)->group(function () {
            Route::delete('deleteUser/{id}', 'deleteUser');
            Route::put('blockUser/{id}', 'blockUser');
        });

         //////////////////estate

        
         //////////////////Currency

        Route::controller(CurrencyControllerWeb::class)->group(function () {
            Route::post('createCurrency', 'createCurrency');
            Route::get('allCurrency', 'allCurrency');
            Route::put('updateCurrency/{id}', 'updateCurrency');
            Route::delete('deleteCurrency/{id}', 'deleteCurrency');
        });

});



