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

Auth::routes(['register' => false]);

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

Route::get('settings/reminders', 'SettingController@remindersSettings')
    ->middleware(['auth'])
    ->name('settings.reminders');

Route::post('settings/reminders', 'SettingController@remindersSave')
    ->middleware(['auth'])
    ->name('settings.reminders.save');

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

Route::post('settings/user/update/{user}', 'UserController@update')
    ->name('user.update');

Route::post('settings/user/store/{user}', 'UserController@save')
    ->middleware(['auth'])
    ->name('user.store');

Route::get('user/{token}', 'UserController@activate')
    ->name('user.activate');

Route::get('clients', 'ClientController@index')
    ->middleware(['auth'])
    ->name('clients');

Route::get('client/merge/{client}', 'ClientController@merge')
    ->middleware(['auth'])
    ->name('client.merge');

Route::post('client/merging/{client}', 'ClientController@merging')
    ->middleware(['auth'])
    ->name('client.merging');

Route::get('clients/create', 'ClientController@create')
    ->middleware(['auth'])
    ->name('clients.create');

Route::post('clients/save', 'ClientController@save')
    ->middleware(['auth'])
    ->name('clients.save');

Route::get('clients/credits/{client}', 'ClientController@creditsShow')
    ->middleware(['auth'])
    ->name('clients.credits');

Route::get('clients/payments/{client}', 'ClientController@paymentsShow')
    ->middleware(['auth'])
    ->name('clients.payments');

Route::get('clients/show/{client}', 'ClientController@show')
    ->middleware(['auth'])
    ->name('clients.show');

Route::get('clients/delete/{client}', 'ClientController@delete')
    ->middleware(['auth'])
    ->name('client.delete');

Route::get('api/clients/datatables', 'ClientController@datatables')
    ->middleware(['auth'])
    ->name('clients.data');

Route::get('invoices', 'InvoiceController@index')
    ->middleware(['auth'])
    ->name('invoices');

Route::get('invoices/create', 'InvoiceController@create')
    ->middleware(['auth'])
    ->name('invoices.create');

Route::get('invoices/edit/{invoice}', 'InvoiceController@edit')
    ->middleware(['auth'])
    ->name('invoices.edit');

Route::post('invoices/store', 'InvoiceController@store')
    ->middleware(['auth'])
    ->name('invoices.store');

Route::get('invoices/show/{invoice}', 'InvoiceController@show')
    ->middleware(['auth'])
    ->name('invoices.show');

Route::get('invoices/destroy/{invoice}', 'InvoiceController@destroy')
    ->middleware(['auth'])
    ->name('invoices.destroy');

Route::get('invoices/download/{invoice}', 'InvoiceController@download')
    ->middleware(['auth'])
    ->name('invoice.download');

Route::get('credits', 'CreditController@index')
    ->middleware(['auth'])
    ->name('credits');

Route::get('credits/create', 'CreditController@create')
    ->middleware(['auth'])
    ->name('credits.create');

Route::get('credits/edit/{credit}', 'CreditController@edit')
    ->middleware(['auth'])
    ->name('credits.edit');

Route::get('credits/destroy/{credit}', 'CreditController@destroy')
    ->middleware(['auth'])
    ->name('credits.destroy');

Route::get('subscriptions', 'SubscriptionController@index')
    ->middleware(['auth'])
    ->name('subscriptions');

Route::get('subscriptions/create', 'SubscriptionController@create')
    ->middleware(['auth'])
    ->name('subscriptions.create');

Route::get('subscriptions/show/{subscription?}', 'SubscriptionController@show')
    ->middleware(['auth'])
    ->name('subscriptions.show');

Route::post('subscriptions/save', 'SubscriptionController@save')
    ->middleware(['auth'])
    ->name('subscriptions.save');

Route::post('subscriptions/store', 'SubscriptionController@store')
    ->middleware(['auth'])
    ->name('subscriptions.store');

Route::get('danger', 'SettingController@danger')
    ->middleware(['auth'])
    ->name('danger');

Route::get('danger/delete', 'SettingController@delete')
    ->middleware(['auth'])
    ->name('danger.delete');

Route::get('billings/show/{subscription?}', 'BillingController@show')
    ->middleware(['auth'])
    ->name('billings.show');

Route::prefix('commissions')->middleware(['auth'])->group(function () {
    Route::get('', 'CommissionController@index')
        ->name('commissions');
    Route::get('edit/{commission}', 'CommissionController@edit')
        ->name('commissions.edit');
    Route::get('create', 'CommissionController@create')
        ->name('commissions.create');
    Route::post('store', 'CommissionController@store')
        ->name('commissions.store');
    Route::post('update/{commission}', 'CommissionController@update')
        ->name('commissions.update');
    Route::get('destroy/{commission}', 'CommissionController@destroy')
        ->name('commissions.destroy');
});

Route::prefix('commissions')->middleware(['auth'])->group(function () {
    Route::get('', 'CommissionController@index')
        ->name('commissions');
    Route::get('owed', 'CommissionController@owed')
        ->name('commissions.owed');
    Route::get('edit/{commission}', 'CommissionController@edit')
        ->name('commissions.edit');
    Route::get('create', 'CommissionController@create')
        ->name('commissions.create');
    Route::post('store', 'CommissionController@store')
        ->name('commissions.store');
    Route::post('update/{commission}', 'CommissionController@update')
        ->name('commissions.update');
    Route::get('destroy/{commission}', 'CommissionController@destroy')
        ->name('commissions.destroy');
});

Route::prefix('activity')->group(function () {
    Route::get('show', 'UserActivityLogController@index')->name('user.activity.show');
});

Route::prefix('client')->namespace('Client')->middleware(['auth:client'])->group(function () {
    Route::get('dashboard', 'DashboardController@index')->name('client.dashboard');
    Route::get('invoice/show/{invoice:public_id}', 'InvoiceController@show')
        ->name('client.invoice.show');
    Route::get('invoice/download/{invoice:public_id}', 'InvoiceController@download')
        ->name('client.invoice.download');
    Route::post('invoice/onfile/{invoice:public_id}', 'PaymentController@paymentFile')
        ->name('client.invoice.onfile');
    Route::get('invoice/pay/{invoice:public_id}', 'PaymentController@payInvoice')
        ->name('client.invoice.pay');
    Route::post('invoice/payment/{invoice:public_id}', 'PaymentController@payment')
        ->name('client.invoice.payment');
});
Route::prefix('client')->namespace('Client\Auth')->group(function () {
    Route::get('/login/{uuid}', 'LoginController@login')
        ->name('client.login')
        ->middleware(['guest:client']);
    Route::post('/logout', 'LoginController@logout')->name('client.logout');
});
Route::prefix('client')->namespace('Client')->group(function () {
    Route::get('/loggedout', 'LoggedOutController@loggedOut')->name('client.loggedout');
});

Route::prefix('billings')->middleware(['auth'])->group(function () {
    Route::get('/', 'BillingController@index')->name('billings');
    Route::get('create', 'BillingController@create')->name('billings.create');
    Route::get('edit/{billing}', 'BillingController@edit')->name('billings.edit');
    Route::get('destroy/{billing}', 'BillingController@destroy')->name('billings.destroy');
});

Route::prefix('products')->middleware(['auth'])->group(function () {
    Route::get('/', 'ProductController@index')->name('products');
    Route::get('show/{product}', 'ProductController@show')->name('products.show');
    Route::get('create', 'ProductController@create')->name('products.create');
    Route::get('destroy/{product}', 'ProductController@destroy')->name('products.destroy');
    ;
    Route::post('store', 'ProductController@store')->name('products.store');
    Route::post('update/{product}', 'ProductController@update')->name('products.update');
});

Route::prefix('payments')->middleware(['auth'])->group(function () {
    Route::get('/', 'PaymentController@index')->name('payments');
    Route::get('create', 'PaymentController@create')->name('payments.create');
    Route::get('edit/{payment}', 'PaymentController@edit')->name('payments.edit');
    Route::get('refund/{payment}', 'PaymentController@refund')->name('payments.refund');
    Route::get('destroy/{payment}', 'PaymentController@destroy')->name('payments.destroy');
    Route::get('card/{invoice?}', 'PaymentController@userCharge')->name('payments.user.card');
    Route::post('charge/card/{invoice?}', 'PaymentController@chargeCard')->name('payments.user.charge.card');
    Route::post('quick/{invoice}', 'PaymentController@addPayment')->name('payments.quick');
    Route::get('payments/excel/{sortField?}/{sortAsc?}/{search?}', 'PaymentController@downloadExcel')->name('payments.download.excel');
});

Route::prefix('api')->middleware(['auth'])->namespace('Api')->group(function () {
    Route::get('clients', 'ClientController@getAll')->name('api.clients.get');
    Route::get('invoice/client/{client}', 'InvoiceController@getByClient')->name('api.invoice.client');
    Route::get('invoice/destroy/{invoice}', 'InvoiceController@destroy')->name('api.invoice.destroy');
    Route::get('invoice/items/{invoice}', 'InvoiceItemsController@getbyInvoice')->name('api.invoice.items');
    Route::get('products', 'ProductController@getAll')->name('api.products.get');
    Route::get('users', 'UserController@getAll')->name('api.users.get');
    Route::post('billing/create', 'BillingController@create')->name('api.billing.create');
    Route::post('billing/update/{billing}', 'BillingController@update')->name('api.billing.update');
    Route::post('commission/create', 'CommissionController@create')->name('api.commission.create');
    Route::post('commission/update/{commission}', 'CommissionController@update')->name('api.commission.update');
    Route::post('credit/create', 'CreditController@create')->name('api.credit.create');
    Route::post('credit/update/{credit}', 'CreditController@update')->name('api.credit.update');
    Route::post('invoice/create', 'InvoiceController@create')->name('api.invoice.create');
    Route::post('invoice/update/{invoice}', 'InvoiceController@update')->name('api.invoice.update');
    Route::post('payment/create', 'PaymentController@create')->name('api.payment.create');
    Route::post('payment/update/{payment}', 'PaymentController@update')->name('api.payment.update');
    Route::post('payment/charge', 'PaymentController@charge')->name('api.payment.user.charge');
});
