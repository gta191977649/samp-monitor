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
Route::get('/un','MainController@gtaun')->name('index');
//Route::get('/cn','MainController@gtaun')->name('index');




Auth::routes();



//API
Route::get('/api/samp/info/{ip}/port/{port}','SAMPAPIController@info')->name('api.info');
Route::get('/api/samp/player/{ip}/port/{port}','SAMPAPIController@player')->name('api.player');
Route::get('/api/samp/playerlist/{ip}/port/{port}','SAMPAPIController@playerList')->name('api.player.list');
Route::get('/api/samp/ping/{ip}/port/{port}','SAMPAPIController@ping')->name('api.ping');
//Route::get('/api/server/players/{ip}/port/{port}','SAMPAPIController@test')->name('test');

Route::group(['middleware'=>'auth'],function(){
    Route::get('/home', 'MainController@index')->name('home');
    Route::get('/ucp', 'UCPController@index')->name('ucp.index');
    //UCP SERVER
    Route::get('/ucp/server/', 'ServerController@index')->name('ucp.server.index');

    Route::get('/ucp/server/add', 'ServerController@add')->name('ucp.server.add');
    Route::get('/ucp/server/del/{id}', 'ServerController@del')->name('ucp.server.del');
    Route::get('/ucp/server/edit/{id}', 'ServerController@edit')->name('ucp.server.edit');
    Route::post('/ucp/server/store', 'ServerController@store')->name('ucp.server.store');
    Route::post('/ucp/server/update/{id}', 'ServerController@update')->name('ucp.server.update');
    Route::get('/ucp/server/detail/{id}', 'ServerController@detail')->name('ucp.server.detail');
});
