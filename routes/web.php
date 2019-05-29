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

Route::get('/', ['as' => 'home', 'uses' => 'PageController@index']);

// CallBack ATOS
Route::group(['middleware' => 'bank'], function () {
    Route::get('/atos/callback', ['as' => 'callback.atos', 'uses' => 'CallbackController@handleAtosCallback']);
    Route::post('/atos/callback', ['as' => 'callback.atos', 'uses' => 'CallbackController@handleAtosCallback']);
});

Route::group([], function () {
    //Route::get('/transaction/{InitialisedTransaction}', ['as'=> 'userFrontend.choose', 'uses' => 'UserFrontend@paymentGatewayChoice']);
    Route::get('/transaction/{uuid}', ['as' => 'userFrontend.uuid.choose', 'uses' => 'UserFrontend@paymentGatewayChoice']);

    Route::get('/atos/return', ['as' => 'return.atos', 'uses' => 'UserFrontend@atosCallback']);
    Route::post('/atos/return', ['as' => 'return.atos', 'uses' => 'UserFrontend@atosCallback']);

    //Route::get('/paypal/return', ['as'=> 'return.paypal', 'uses' => 'UserFrontend@paypalCallback']);

    Route::get('/paypal/return', ['as' => 'return.paypal', 'uses' => 'UserFrontend@paypalCallback']);
    Route::get('/transaction/{InitialisedTransaction}/paypal', ['as' => 'userFrontend.paypalRedirect', 'uses' => 'UserFrontend@paypalRedirect']);

    //Mode DEV:
    Route::get('/transaction/devMode/{InitialisedTransaction}/{action}', ['as' => 'userFrontend.devMode', 'uses' => 'UserFrontend@devAction']);

    //Payline
    Route::get('/payline/return', ['as' => 'return.payline', 'uses' => 'UserFrontend@paylineCallback']);
    Route::get('/payline/callback', ['as' => 'callback.payline', 'uses' => 'CallbackController@handlePaylineCallback']);
});

Route::group([], function () {
    Route::get('/initiate', ['as' => 'payment.request', 'uses' => 'TransactionRequest@incomming']);
    Route::post('/initiate', ['as' => 'payment.request', 'uses' => 'TransactionRequest@incomming']);
});

//Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
