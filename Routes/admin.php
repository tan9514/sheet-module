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
*/

// 面单打印设置项
Route::get('delivery/list', 'DeliveryController@list');
Route::get('delivery/ajaxList', 'DeliveryController@ajaxList');
Route::any('delivery/edit', 'DeliveryController@edit');
Route::post('delivery/del', 'DeliveryController@del');
Route::any('sender/setting', 'SenderController@setting');

