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
Route::get('/un','MainController@gtaun')->name('gtaun');

//搜索
Route::get('/search/{keywords?}','ServerController@search')->name('search');

//Route::get('/cn','MainController@gtaun')->name('index');


Auth::routes();


//对外
Route::prefix('api')->group(function () {
    Route::get('/get/samp/info/{ip}{port}','SAMPAPIController@getInfo')->name('api.getInfo');

    //API
    Route::get('/samp/live/info/{ip}/port/{port}','SAMPAPIController@liveInfo')->name('api.liveInfo.info');
    Route::get('/samp/live/rule/{ip}/port/{port}','SAMPAPIController@liveRule')->name('api.liveInfo.rule');
    Route::get('/samp/info/{id}','SAMPAPIController@info')->name('api.info');
    Route::get('/samp/player/{ip}/port/{port}','SAMPAPIController@player')->name('api.player');
    Route::get('/samp/playerlist/{ip}/port/{port}','SAMPAPIController@playerList')->name('api.player.list');
    Route::get('/samp/ping/{ip}/port/{port}','SAMPAPIController@ping')->name('api.ping');
    Route::get('/samp/rules/{ip}/port/{port}','SAMPAPIController@rules')->name('api.rules');
    Route::get('/samp/index','ServerController@indexApi')->name('api.index');

    //图表API
    Route::get('/server/recorddate/{id}/', 'ServerController@recordDateRange')->name('server.recordDateRange');
    Route::get('/server/record/{id}/{date}', 'ServerController@record')->name('server.record');
    //头像
    Route::get('/user/gravator/{email}', 'GravatorController@imgUrl')->name('api.avator');

    //服务器签名API
    Route::get('/samp/signature/{ip}/port/{port}', 'SignatureAPIController@generate')->name('api.signature');

    
});

Route::get('/server/detail/{id}', 'ServerController@fontedDetail')->name('server.detail');


//Route::get('/api/server/players/{ip}/port/{port}','SAMPAPIController@test')->name('test');

Route::group(['middleware'=>'auth'],function(){
    Route::get('/home', 'MainController@index')->name('home');
    Route::get('/update', 'MainController@update')->name('home');
    Route::get('/ucp', 'UCPController@index')->name('ucp.index');
//UCP SERVER
    Route::get('/ucp/server/', 'ServerController@index')->name('ucp.server.index');

    Route::get('/ucp/server/add', 'ServerController@add')->name('ucp.server.add');
    Route::get('/ucp/server/del/{id}', 'ServerController@del')->name('ucp.server.del');
    Route::get('/ucp/server/edit/{id}', 'ServerController@edit')->name('ucp.server.edit');
    Route::get('/ucp/server/activate/{id}', 'ServerController@activate')->name('ucp.server.activate');
    Route::post('/ucp/server/store', 'ServerController@store')->name('ucp.server.store');
    Route::post('/ucp/server/update/{id}', 'ServerController@update')->name('ucp.server.update');
    Route::post('/ucp/server/active/{id}', 'ServerController@activateServer')->name('ucp.server.active');
    Route::get('/ucp/server/detail/{id}', 'ServerController@detail')->name('ucp.server.detail');
    
    //UCP API
    Route::get('/ucp/api/query/', 'SAMPAPIController@frontendQuery')->name('ucp.api.query');


});
