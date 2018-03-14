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

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/cashBailManual', 'HomeController@downloadCashBailManual');

Route::get('/import/jail/data', 'ImportDataController@importOldJailTable')->name('importjaildata');

Route::get('/enterbail', 'EnterBailController@index')->name('enterbail');
Route::get('/enterbail/ajax/findcheck', 'EnterBailController@searchcheckajax')->name('searchcheckajax');

Route::get('/enterbail/jailbatch', 'EnterBailBatchController@index')->name('jailcheck');
Route::post('/enterbail/jailbatch/check/results', 'EnterBailBatchController@searchchecknumber')->name('searchchecknumber');
Route::post('/enterbail/jailbatch/processed', 'EnterBailBatchController@processbails')->name('processbails');

Route::get('/enterbail/manualentry', 'EnterBailManualController@index')->name('manualentry');
Route::any('/enterbail/manualentry/processed', 'EnterBailManualController@processmanualentry')->name('processmanualentry');
Route::get('/enterbail/validateindexyear', 'EnterBailManualController@validateindexyear')->name('validateindexyear');
Route::post('/enterbail/edit/manualentry', 'EnterBailManualController@editmanualrecord')->name('editmanualentry');


Route::get('/processbail', 'ProcessbailController@index')->name('processbailsearch');
Route::get('/processbail/ajax/findbail', 'ProcessbailController@ajaxfindbail')->name('ajaxfindbail');
Route::any('/processbail/find/results', 'ProcessbailController@searchresults')->name('processbailresults');
Route::post('/processbail/edit/bailmaster', 'ProcessbailController@editbailmaster')->name('editbailmaster');
