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

Route::get('/', function () {
    return view('welcome');
});

Route::get('house/{house}', 'house\HouseController@index')->name('house.index');
Route::get('test/{test}', 'house\HouseController@test')->name('house.test');
Route::get('downcommunity/{index}', 'house\HouseController@downcommunity')->name('downcommunity.index');
