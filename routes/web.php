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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('client', 'ClientController');
Route::resource('governorate', 'GovernorateController');
Route::resource('city', 'CityController');
Route::resource('category', 'CategoryController');
Route::resource('service', 'ServiceController');
Route::resource('token', 'TokenController');

Route::get('/home', 'HomeController@index')->name('home');
