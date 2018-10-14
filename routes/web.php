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

Route::get('/','Owner@dashboard');

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
<<<<<<< HEAD
Route::get('/settings/exempted-setting', 'Client@exemptedDuration');
Route::post('/settings/exempted-setting', 'Client@exemptedDuration');
=======

/**
 * Employee Routes
 */

Route::get('/create-employee', 'Client@createEmployee');
Route::post('/create-employee', 'Client@createEmployee');
Route::get('/manage-employee', 'Client@manageEmployee');
Route::post('/edit-password', 'Client@editPassword');
Route::post('/edit-employee', 'Client@editEmployee');
Route::post('/blocking', 'Client@blocking');
>>>>>>> 4b6317bbf78af8f4ebc58e6463c63c98954fdc19
