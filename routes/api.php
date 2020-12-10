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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {

    Route::get('governrates', 'MainController@governrates');
    Route::get('cities', 'MainController@cities');
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('reset', 'AuthController@reset');
    Route::post('password', 'AuthController@password');
    Route::get('categories', 'MainController@categories');
    Route::get('service', 'MainController@service');
    Route::get('comments', 'MainController@comments');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('profile','AuthController@profile');
        Route::post('addComment','MainController@addComment');
        Route::post('addOrder','MainController@addOrder');
        Route::post('myOrder','MainController@myOrder');
        Route::get('showOrder','MainController@showOrder');

    });


});
