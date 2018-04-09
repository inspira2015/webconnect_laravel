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
    return redirect('login');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/cashBailManual', 'HomeController@downloadCashBailManual');
Route::get('/import/jail/data', 'ImportDataController@importOldJailTable')->name('importjaildata');

Route::get('/enterbail', 'EnterBailController@index')->name('enterbail');
Route::get('/enterbail/ajax/findcheck', 'EnterBailController@searchcheckajax')->name('searchcheckajax');
Route::get('/enterbail/jailbatch', 'EnterBailBatchController@index')->name('jailcheck');
Route::post('/enterbail/jailbatch/check/results', 'EnterBailBatchController@searchchecknumber')->name('searchchecknumber');
Route::any('/enterbail/jailbatch/processed', 'EnterBailBatchController@processbails')->name('processbails');

Route::get('/enterbail/manualentry', 'EnterBailManualController@index')->name('manualentry');
Route::any('/enterbail/manualentry/processed', 'EnterBailManualController@processmanualentry')->name('processmanualentry');
Route::get('/enterbail/validateindexyear', 'EnterBailManualController@validateindexyear')->name('validateindexyear');
Route::post('/enterbail/edit/manualentry', 'EnterBailManualController@editManualRecord')->name('editmanualentry');

Route::get('/processbail', 'ProcessbailController@index')->name('processbailsearch');
Route::any('/processbail/find/results', 'ProcessbailController@searchresults')->name('processbailresults');
Route::post('/processbail/edit/bailmaster', 'ProcessbailController@editbailmaster')->name('editbailmaster');

Route::post('/bailrefund/refundbalance', 'BailRefundProcessController@refundbalance')->name('refundbalance');
Route::post('/bailrefund/partialrefund', 'BailRefundProcessController@partialrefund')->name('partialrefund');
Route::post('/bailrefund/multicheck', 'BailRefundProcessController@multicheck')->name('multicheck');
Route::post('/bailrefund/reversetransaction', 'BailRefundProcessController@reversetransaction')->name('reversetransaction');

Route::get('/forfeitures', 'ForfeituresController@index')->name('forfeitures');
Route::any('/forfeitures/find/results', 'ForfeituresController@searchresults')->name('forfeituresresults');
Route::any('/forfeitures/report', 'ForfeituresController@createReport')->name('forfeituresreport');
Route::get('/forfeitures/excel/report', 'ForfeituresController@createExcelReport')->name('forfeituresExcel');
Route::any('/forfeitures/process', 'ForfeituresController@processForfeitures')->name('processforfeitures');


Route::get('/ajaxcall/findbailmaster', 'AjaxSearchController@searchBailMaster')->name('searchBailMaster');
Route::any('/ajaxcall/forfeiture/action', 'AjaxSearchController@ajaxForfeituresAddRemove')->name('forfeituresControl');