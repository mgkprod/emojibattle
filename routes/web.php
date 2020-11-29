<?php

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

Route::get('/', '\App\Http\Controllers\HomeController@home')->name('home');
Route::get('/hall-of-shame', '\App\Http\Controllers\HomeController@hallOfShame')->name('hall-of-shame');

Route::post('/', '\App\Http\Controllers\HomeController@submit');

Route::get('/{slug}', '\App\Http\Controllers\HomeController@show')->name('show');
