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

Route::redirect('/', '/dashboard');

Auth::routes();

Route::get('dashboard', 'DashboardController@index')
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('settings', 'SettingController@index')
    ->middleware(['auth'])
    ->name('settings');

Route::get('settings/payment', 'PaymentController@settings')
    ->middleware(['auth'])
    ->name('settings.payment');

Route::post('settings/payment', 'PaymentController@settingsSave')
    ->middleware(['auth'])
    ->name('settings.payment.save');

Route::get('settings/user/{user}', 'UserController@show')
    ->middleware(['auth'])
    ->name('user.show');

Route::get('settings/users', 'UserController@index')
    ->middleware(['auth'])
    ->name('users');

Route::get('settings/users/create', 'UserController@create')
    ->middleware(['auth'])
    ->name('user.create');

Route::post('settings/save', 'SettingController@save')
    ->middleware(['auth'])
    ->name('settings.save');

Route::post('settings/user/save', 'UserController@save')
    ->middleware(['auth'])
    ->name('user.save');

Route::post('settings/user/store/{user}', 'UserController@save')
    ->middleware(['auth'])
    ->name('user.store');

Route::get('user/{token}', 'UserController@activate')
    ->name('user.activate');

Route::get('clients', 'ClientController@index')
    ->middleware(['auth'])
    ->name('clients');

Route::get('clients/create', 'ClientController@create')
    ->middleware(['auth'])
    ->name('clients.create');

Route::post('clients/save', 'ClientController@save')
    ->middleware(['auth'])
    ->name('clients.save');

Route::get('clients/show/{client}', 'ClientController@show')
    ->middleware(['auth'])
    ->name('clients.show');

Route::get('api/clients/datatables', 'ClientController@datatables')
    ->middleware(['auth'])
    ->name('clients.data');

Route::get('payments', 'PaymentController@index')
    ->middleware(['auth'])
    ->name('payments');

Route::get('payments/show/{payment}', 'PaymentController@show')
    ->middleware(['auth'])
    ->name('payments.show');

Route::get('payments/refund/{payment}', 'PaymentController@refund')
    ->middleware(['auth'])
    ->name('payments.refund');

Route::get('invoices', 'InvoiceController@index')
    ->middleware(['auth'])
    ->name('invoices');

Route::get('invoices/show/{invoice}', 'InvoiceController@show')
    ->middleware(['auth'])
    ->name('invoices.show');

Route::get('invoice-credits', 'InvoiceCreditController@index')
    ->middleware(['auth'])
    ->name('invoice-credits');
