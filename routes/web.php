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

Route::get('clients/credits/{client}/create', function() {
        return redirect(route('credits.create'));
    })
    ->middleware(['auth']);


Route::get('clients/credits/{client}', 'ClientController@creditsShow')
    ->middleware(['auth'])
    ->name('clients.credits');

Route::get('clients/payments/{client}/create', function() {
        return redirect(route('payments.create'));
    })
    ->middleware(['auth']);

Route::get('clients/payments/{client}', 'ClientController@paymentsShow')
    ->middleware(['auth'])
    ->name('clients.payments');

Route::get('clients/show/{client}/create', function() {
        return redirect(route('invoices.create'));
    })
    ->middleware(['auth']);

Route::get('clients/show/{client}', 'ClientController@invoicesShow')
    ->middleware(['auth'])
    ->name('clients.show');

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
    Route::get('owed/create', function () {
        return redirect(route('commissions.create'));
    });
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

Route::prefix('client')->namespace('Client')->group(function () {
    Route::get('dashboard', 'DashboardController@index')->name('client.dashboard');
    Route::get('invoice/show/{invoice}', 'DashboardController@showInvoice')->name('client.invoice.show')->middleware(['auth:client']);
    Route::get('invoice/download/{invoice}', 'DashboardController@downloadInvoice')->name('client.invoice.download')->middleware(['auth:client']);
    Route::get('invoice/pay/{invoice}', 'DashboardController@payInvoice')->name('client.invoice.pay')->middleware(['auth:client']);
    Route::post('invoice/payment/{invoice}', 'DashboardController@payment')->name('client.invoice.payment')->middleware(['auth:client']);
    Route::namespace('Auth')->group(function(){
        Route::get('/login/{uuid}','LoginController@login')->name('client.login')->middleware(['guest:client']);
        Route::post('/logout','LoginController@logout')->name('client.logout');
    });
});

Route::prefix('billings')->middleware(['auth'])->group(function () {
    Route::get('/', 'BillingController@index')->name('billings');
    Route::get('create', 'BillingController@create')->name('billings.create');
    Route::get('edit/{billing}', 'BillingController@edit')->name('billings.edit');
    Route::get('destroy/{billing}', 'BillingController@edit')->name('billings.destroy');
});

Route::prefix('products')->middleware(['auth'])->group(function () {
    Route::get('/', 'ProductController@index')->name('products');
    Route::get('show/{product}', 'ProductController@show')->name('products.show');
    Route::get('create', 'ProductController@create')->name('products.create');
    Route::get('destroy/{product}', 'ProductController@destroy')->name('products.destroy');;
    Route::post('store', 'ProductController@store')->name('products.store');
    Route::post('update/{product}', 'ProductController@update')->name('products.update');
});

Route::prefix('payments')->middleware(['auth'])->group(function () {
    Route::get('/', 'PaymentController@index')->name('payments');
    Route::get('create', 'PaymentController@create')->name('payments.create');
    Route::get('edit/{payment}', 'PaymentController@edit')->name('payments.edit');
    Route::get('refund/{payment}', 'PaymentController@refund')->name('payments.refund');
    
});

Route::get('charge', 'PaymentController@userCharge')->name('payments.user.charge');
Route::post('charge/card', 'PaymentController@chargeCard')->name('payments.user.charge');

Route::prefix('api')->middleware(['auth'])->namespace('Api')->group(function () {
    Route::get('clients', 'ClientController@getAll')->name('api.clients.get');
    Route::get('invoice/client/{client}', 'InvoiceController@getByClient')->name('api.invoice.client');
    Route::get('invoice/destroy/{invoice}', 'InvoiceController@destroy')->name('api.invoice.destroy');
    Route::get('products', 'ProductController@getAll')->name('api.products.get');
    Route::get('users', 'UserController@getAll')->name('api.clients.get');
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

