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

Route::group(['prefix' => 'community', 'namespace' => 'RealEstate'], function () {
    Route::get('', 'CommunityController@index')->name('community.index');
    Route::get('communityDetail/{communityName}', 'CommunityController@communityDetail')->name('community.communityDetail');
    Route::get('getRegionList/{type}/{districtId}/{city}', 'CommunityController@getRegionList')->name('community.getRegionList');
    Route::get('ajax/getCommunityDetailByBizcircle', 'CommunityController@getCommunityDetailByBizcircle')
        ->name('community.getCommunityDetailByBizcircle');
});
Route::group(['prefix' => 'sell', 'namespace' => 'RealEstate'], function () {
    Route::get('sellUpsAndDowns', 'SellController@sellUpsAndDownsIndex')->name('sell.sellUpsAndDownsIndex');
    Route::get('ajax/getSellUpsAndDowns', 'SellController@getSellUpsAndDowns')
        ->name('sell.getSellUpsAndDowns');
    Route::get('ajax/exportCsv', 'SellController@exportCsv')
        ->name('sell.exportCsv');
});