<?php

use App\Http\Controllers\application\CompaniesControllerApplication;
use App\Http\Controllers\application\CurrencyControllerApplication;
use App\Http\Controllers\application\EstateControllerApplication;
use App\Http\Controllers\application\FavoriteControllerApplication;
use App\Http\Controllers\application\NewsControllerApplication;
use App\Http\Controllers\application\NotificationControllerApplication;
use App\Http\Controllers\application\OrderControllerApplication;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


////////////////////with auth

Route::middleware(['auth:sanctum','is_user'])->group(function () {

    Route::controller(AuthController::class)->group(function (){
        Route::get('getHome','getHome');
    });

    ////////////News

    Route::controller(NewsControllerApplication::class)->group(function () {
        Route::get('allNews', 'allNews');
        Route::get('detailsForNews/{id}', 'detailsForNews');
    });

    ///////////////////Companies

    Route::controller(CompaniesControllerApplication::class)->group(function () {
        Route::get('companies', 'companies');
        Route::get('detailCompany/{id}', 'detailCompany');
    });

    ///////////////////Favorites

    Route::controller(FavoriteControllerApplication::class)->group(function () {
        Route::post('addFav/{id}', 'addFav');
        Route::delete('removeFav/{id}', 'removeFav');
        Route::get('showFav', 'showFav');
    });

    //////////////////Notification

    Route::controller(NotificationControllerApplication::class)->group(function () {
        Route::get('allNoti', 'allNoti');
    });

    ///////////////////promotionOrder

    Route::controller(OrderControllerApplication::class)->group(function () {
        Route::post('promotionOrder', 'promotionOrder');
    });

    ///////////////////Estate

    Route::controller(EstateControllerApplication::class)->group(function () {
        Route::post('createEstate/{id?}', 'createEstate');
        Route::get('countEstateForOffice', 'countEstateForOffice');
        Route::get('allEstate', 'allEstate');
        Route::get('detailEstate/{id}','detailEstate');
        Route::get('allEstateForOffice','allEstateForOffice');
        Route::get('estateForUserID','estateForUserID');
        Route::delete('deleteEstate/{id}','deleteEstate');
    });

    ///////////////////Currency

    Route::controller(CurrencyControllerApplication::class)->group(function () {
        Route::get('allCurrency', 'allCurrency');
    });


});



