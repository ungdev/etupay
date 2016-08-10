<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'bank'], function(){
    Route::get('/test', ['as'=> 'payment.request', 'uses' => 'TransactionRequest@testRequest']);
});

Route::group([], function(){
    Route::get('/transaction/{InitialisedTransaction}', ['as'=> 'userFrontend.choose', 'uses' => 'UserFrontend@paymentGatewayChoice']);
});
Route::group([], function(){
    Route::get('/requete', ['as'=> 'payment.request', 'uses' => 'TransactionRequest@testDecrypt']);
    Route::post('/requete', ['as'=> 'payment.request', 'uses' => 'TransactionRequest@testDecrypt']);
});

//Callback atos
Route::group([], function(){
    Route::get('/atos/callback', ['as'=> 'callback.atos', 'uses' => 'CallbackController@handleAtosCallback']);
    Route::post('/atos/callback', ['as'=> 'callback.atos', 'uses' => 'CallbackController@handleAtosCallback']);
});

Route::bind('InitialisedTransaction', function ($id){
    $transaction = \App\Models\Transaction::where('id', $id)->where('step', 'INITIALISED')->first();
    if($transaction)
        return $transaction;
    else abort(404);
});