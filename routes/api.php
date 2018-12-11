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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('order')->group(function () {

    // Mapping to OrderController@store
    Route::post('/', 'OrderController@store');

    // Mapping to OrderController@index
    Route::get('/', 'OrderController@index');

    // Mapping to OrderContorller@update
    Route::put('/', 'OrderController@update');

    Route::delete('/', 'OrderController@delete');

});
