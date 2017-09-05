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

Route::group(['prefix' => 'user'], function() {
    Route::post('/register', 'UsersController@register');
    Route::post('/login', 'UsersController@login');
    Route::post('/detail', 'UsersController@detail');

    Route::group(['middleware' => 'authenticate'], function() {
        Route::post('/authenticate', 'UsersController@isLogin');
        Route::post('/logout', 'UsersController@logout');
    });
});

Route::group(['prefix' => 'message'], function() {
    Route::post('/send', 'MessagesController@send');
    Route::group(['middleware' => 'authenticate'], function() {
        Route::post('/', 'MessagesController@index');
    });
});
