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

Route::group(['namespace' => 'Api'], function() {
    Route::post('login', 'LoginController@login');

    Route::group(['middleware' => ['auth.jwt']], function() {
        Route::get('logout', 'LoginController@logout');
        Route::get('profile', 'ProfileController@profile');
        Route::resource('products','ProductsController', ['only' => ['index', 'show']]);
        Route::resource('orders','OrdersController', ['except' => ['create', 'edit']]);
    });
});

