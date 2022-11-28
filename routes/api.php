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

Route::post('login', 'Api\AuthController@login'); 

Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('v1')->group(function() {
        Route::post('logout', 'Api\AuthController@logout');

        Route::prefix('delivery')->group(function() {
            Route::get('/', 'Api\V1\DeliveryController@index');
            Route::get('{shipping}', 'Api\V1\DeliveryController@show');
            Route::put('{shipping}/setStatus', 'Api\V1\DeliveryController@setStatus');
        });
    });
});