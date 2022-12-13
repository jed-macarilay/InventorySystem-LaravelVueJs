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
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/', 'DashboardController@index')->name('dashboard');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('settings', 'DashboardController@changePassword');

Route::prefix('inventory')->group(function () {
    Route::get('/', 'InventoryController@index');
    Route::get('create', 'InventoryController@create');
    Route::get('edit/{inventory}', 'InventoryController@edit');
});

Route::prefix('category')->group(function () {
    Route::get('/', 'CategoryController@index');
    Route::get('create', 'CategoryController@create');
});

Route::prefix('vehicle')->group(function () {
    Route::get('/', 'VehicleController@index');
    Route::get('create', 'VehicleController@create');
    Route::get('edit/{vehicle}', 'VehicleController@edit');

    Route::prefix('shippings')->group(function() {
        Route::get('{vehicle}', 'ShippingController@index');
        Route::get('{vehicle}/create', 'ShippingController@create');
        Route::get('{shipping}/edit', 'ShippingController@edit');
        Route::get('{shipping}/map', 'ShippingController@map');
    });
});

Route::get('sales', 'SaleController@index');
Route::get('order/create', 'ShippingController@createShipping');

Route::get('notifications', 'NotificationController@index');

Route::prefix('api')->group(function () {
    Route::get('users', 'Api\UserController@user');
    Route::get('drivers', 'Api\UserController@showDrivers');
    Route::post('create/new_user', 'Api\UserController@add_user');
    Route::put('change-password/{user}', 'Api\UserController@changePassword');

    Route::get('view/all', 'Api\ViewAllController@view');

    Route::prefix('inventory')->group(function() {
        Route::prefix('product')->group(function() {
            Route::get('/', 'Api\InventoryController@index');
            Route::post('create', 'Api\InventoryController@create');
            Route::put('edit/{inventory}', 'Api\InventoryController@edit');
            Route::delete('delete/{inventory}', 'Api\InventoryController@destroy');
        });
    });

    Route::prefix('category')->group(function() {
        Route::get('/', 'Api\CategoryController@index');
        Route::get('show', 'Api\CategoryController@show');
        Route::post('create', 'Api\CategoryController@create');
    });

    Route::prefix('vehicle')->group(function () {
        Route::get('/', 'Api\VehicleController@index');
        Route::post('store', 'Api\VehicleController@store');
        Route::put('edit/{vehicle}', 'Api\VehicleController@edit');
        Route::delete('delete/{vehicle}', 'Api\VehicleController@destroy');

        Route::prefix('shippings')->group(function() {
            Route::get('{vehicle}', 'Api\VehicleShippingController@index');
            Route::post('{vehicle}/create', 'Api\VehicleShippingController@create');
            Route::put('{shipping}/edit', 'Api\VehicleShippingController@edit');

            Route::get('{shipping}/order', 'Api\OrderController@index');
        });
    });    

    Route::post('shippings/orders/create', 'Api\ShippingController@create');
    Route::put('shippings/update/currentLocation/{shipping}', 'Api\ShippingController@updateCurrentLocation');
    Route::get('sales', 'Api\ShippingController@index');

    Route::get('notifications', 'Api\NotificationController@index');
});