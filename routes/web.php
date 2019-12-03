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

Route::get('settings/user/{user}', 'UserController@view')
    ->middleware(['auth'])
    ->name('user.view');

Route::get('settings/users', 'UserController@index')
    ->middleware(['auth'])
    ->name('users');

Route::get('settings/users/new', 'UserController@new')
    ->middleware(['auth'])
    ->name('user.new');

Route::post('settings/save', 'SettingController@save')
    ->middleware(['auth'])
    ->name('settings.save');

Route::post('settings/user/create', 'UserController@create')
    ->middleware(['auth'])
    ->name('user.create');

Route::post('settings/user/store/{user}', 'UserController@save')
    ->middleware(['auth'])
    ->name('user.save');

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

Route::get('clients/view/{client}', 'ClientController@view')
    ->middleware(['auth'])
    ->name('clients.view');

Route::get('api/clients/datatables', 'ClientController@datatables')
    ->middleware(['auth'])
    ->name('clients.data');

Route::get('payments', 'PaymentController@index')
    ->middleware(['auth'])
    ->name('payments');

Route::get('invoices', 'InvoiceController@index')
    ->middleware(['auth'])
    ->name('invoices');

Route::get('invoice-credits', 'InvoiceCreditController@index')
    ->middleware(['auth'])->name('invoice-credits');
