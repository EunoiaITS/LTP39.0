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

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'owner']], function(){

    /**
     * client routes
     **/

    Route::get('/create-client', 'Owner@createClient');
    Route::post('/create-client', 'Owner@createClient');
    Route::get('/clients-list', 'Owner@allClients');
    Route::post('/clients-list', 'Owner@allClients');
    Route::get('/client-details', 'Owner@clientDetails');
    Route::post('/client-details', 'Owner@clientDetails');

    /**
     *device routes
     **/

    Route::get('/create-device', 'Owner@createDevice');
    Route::post('/create-device', 'Owner@createDevice');
    Route::get('/manage-device', 'Owner@manageDevice');
    Route::post('/manage-device', 'Owner@manageDevice');
    Route::post('/delete-device', 'Owner@deleteDevice');

    /**
     *billing routes
     **/

    Route::get('/create-billing','Owner@createBilling');
    Route::post('/create-billing','Owner@createBilling');
    Route::get('/manage-billing','Owner@manageBilling');
    Route::post('/manage-billing','Owner@manageBilling');
    Route::get('/manage-billing-details','Owner@manageBillingDetails');

    /**
     *payment routes
     **/

    Route::post('/payment','Owner@payment');

});

Route::group(['middleware' => ['auth', 'client']], function(){

    /**
     * settings
     * parking settings
     */

    Route::get('/settings/vehicle-types', 'Client@vehicleType');
    Route::post('/settings/vehicle-types', 'Client@vehicleType');
    Route::get('/settings/assign-parking', 'Client@assignParking');
    Route::post('/settings/assign-parking', 'Client@assignParking');
    Route::get('/settings/assign-rate', 'Client@assignRate');
    Route::post('/settings/assign-rate', 'Client@assignRate');
    Route::get('/settings/exempted-setting', 'Client@exemptedDuration');
    Route::post('/settings/exempted-setting', 'Client@exemptedDuration');
    Route::get('/settings/vat', 'Client@vat');
    Route::post('/settings/vat', 'Client@vat');
    Route::get('/settings/vip-parking', 'Client@vipParking');
    Route::post('/settings/vip-parking', 'Client@vipParking');

    /**
     * Employee Routes
     */

    Route::get('/create-employee', 'Client@createEmployee');
    Route::post('/create-employee', 'Client@createEmployee');
    Route::get('/manage-employee', 'Client@manageEmployee');
    Route::post('/edit-password', 'Client@editPassword');
    Route::post('/edit-employee', 'Client@editEmployee');
    Route::post('/blocking', 'Client@blocking');

    /**
     * Vip Routes
     **/

    Route::get('/vip-requests', 'Client@vipRequests');
    Route::post('/vip-requests', 'Client@vipRequests');
    Route::get('/vip-list', 'Client@vipList');
    Route::get('/vip-reject-list', 'Client@vipRejectList');

    /**
     * Report pages
    */
    Route::get('/report/vehicle-category', 'Client@vhReport');
    Route::post('/report/vehicle-category', 'Client@vhReport');
    Route::get('/report/user-incomes', 'Client@uiReport');
    Route::post('/report/user-incomes', 'Client@uiReport');
    Route::get('/report/sales', 'Client@salesReport');
    Route::post('/report/sales', 'Client@salesReport');
    Route::get('/report/tickets', 'Client@ticketReport');
    Route::post('/report/tickets', 'Client@ticketReport');
    Route::get('/report/receipts', 'Client@receiptReport');
    Route::post('/report/receipts', 'Client@receiptReport');

});

Auth::routes();