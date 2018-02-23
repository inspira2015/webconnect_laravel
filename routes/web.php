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


Route::get('/enterbail', 'EnterBailController@index')->name('enterbail');
Route::get('/enterbail/jailcheck', 'EnterBailController@jailImport')->name('jailcheck');
Route::post('/enterbail/searchchecknumber', 'EnterBailController@searchchecknumber')->name('searchchecknumber');
Route::post('/enterbail/processbails', 'EnterBailController@processbails')->name('processbails');


Route::get('/enterbail/searchcheckajax', 'EnterBailController@searchcheckajax')->name('searchcheckajax');

Route::get('/enterbail/checkolddatabase', 'EnterBailController@checkolddatabase')->name('checkolddatabase');

