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

// CallBack ATOS
Route::group(['middleware' => 'bank'], function(){
    Route::get('/atos/callback', ['as'=> 'callback.atos', 'uses' => 'CallbackController@handleAtosCallback']);
    Route::post('/atos/callback', ['as'=> 'callback.atos', 'uses' => 'CallbackController@handleAtosCallback']);
});


Route::group([], function(){
    Route::get('/transaction/{InitialisedTransaction}', ['as'=> 'userFrontend.choose', 'uses' => 'UserFrontend@paymentGatewayChoice']);

    Route::get('/atos/return', ['as'=> 'return.atos', 'uses' => 'UserFrontend@atosCallback']);
    Route::post('/atos/return', ['as'=> 'return.atos', 'uses' => 'UserFrontend@atosCallback']);

    //Route::get('/paypal/return', ['as'=> 'return.paypal', 'uses' => 'UserFrontend@paypalCallback']);

    Route::get('/paypal/return', ['as'=> 'return.paypal', 'uses' => 'UserFrontend@paypalCallback']);
    Route::get('/transaction/{InitialisedTransaction}/paypal', ['as'=> 'userFrontend.paypalRedirect', 'uses' => 'UserFrontend@paypalRedirect']);
});

Route::group([], function(){
    Route::get('/initiate', ['as'=> 'payment.request', 'uses' => 'TransactionRequest@incomming']);
    Route::post('/initiate', ['as'=> 'payment.request', 'uses' => 'TransactionRequest@incomming']);
});



Route::bind('InitialisedTransaction', function ($id){
    $transaction = \App\Models\Transaction::where('id', $id)->where('step', 'INITIALISED')->first();
    if($transaction)
        return $transaction;
    else abort(404);
});