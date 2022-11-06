<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', 'DashboardController@index')->name('dashboard');

Route::prefix('inventory')->group(function () {
    Route::get('/', 'InventoryController@index');
    Route::get('create', 'InventoryController@create');
});

Route::prefix('vehicle')->group(function () {
    Route::get('/', 'VehicleController@index');
    Route::get('create', 'VehicleController@create');
});

Route::prefix('api')->group(function () {
    Route::prefix('vehicle')->group(function () {
        Route::get('/', 'Api\VehicleController@index');
        Route::post('store', 'Api\VehicleController@store');
    });    
});