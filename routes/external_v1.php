<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('clients')->group(function () {
	Route::post('clients/create', 'ClientController@create');
	Route::get('get', 'ClientController@getAll');
	Route::get('get/id/{client}', 'ClientController@show');
	Route::get('get/crm/{id}', 'ClientController@showCrm');
});