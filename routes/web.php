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

Route::get('/','MainController@index')->name('index');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//API
Route::get('/api/samp/info/{ip}/port/{port}','SAMPAPIController@info')->name('api.info');
Route::get('/api/samp/player/{ip}/port/{port}','SAMPAPIController@player')->name('api.player');
//Route::get('/api/server/players/{ip}/port/{port}','SAMPAPIController@test')->name('test');