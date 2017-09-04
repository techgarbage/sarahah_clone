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

Route::group(['prefix' => 'user'], function() {
    Route::post('/register', 'UsersController@register');
    Route::post('/login', 'UsersController@login');
    Route::post('/detail', 'UsersController@detail');

    Route::group(['middleware' => 'jwt.auth'], function() {

    });
});

Route::group(['prefix' => 'message'], function() {
    Route::post('/send', 'MessagesController@send');
    Route::group(['middleware' => 'jwt.auth'], function() {
        Route::post('/', 'MessagesController@index');
    });
});
