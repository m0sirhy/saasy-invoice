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
    Route::post('create', 'ClientController@create');
    Route::get('get', 'ClientController@getAll');
    Route::get('get/id/{client}', 'ClientController@show');
    Route::get('get/crm/{id}', 'ClientController@showCrm');
    Route::get('delete/{client}', 'ClientController@destroy');
});

Route::prefix('products')->group(function () {
    Route::post('create', 'ProductController@create');
    Route::get('get', 'ProductController@getAll');
    Route::get('get/id/{product}', 'ProductController@show');
    Route::get('delete/{product}', 'ProductController@destroy');
});