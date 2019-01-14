<?php

use Illuminate\Http\Request;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


/*Route::prefix('order')->group(function () {

    // Mapping to OrderController@store
    Route::post('/', 'OrderController@store');

    // Mapping to OrderController@index
    Route::get('/', 'OrderController@index');

    // Mapping to OrderContorller@update
    Route::put('/', 'OrderController@update');

    Route::delete('/', 'OrderController@delete');

});*/

Route::prefix('v1')->group(function () {
    Route::prefix('shops')->group(function () {

        Route::post('/', 'ShopController@regist')->name('shop.regist');

        Route::get('/{id}', 'ShopController@findOne')->name('shop.findOne');

        Route::get('/', 'ShopController@findMany')->name('shop.findMany');

    });
});

Route::prefix('proxy')->group(function () {
    Route::prefix('v2')->group(function () {
        Route::prefix('product')->group(function () {
            Route::get('/', 'Proxy\CAPI\v2\Product@search')->name('proxy.v2.product.search');
        });
        Route::prefix('shop')->group(function () {
            Route::get('/', 'Proxy\CAPI\v2\Shop@search')->name('proxy.v2.shop.search');
        });
    });
});