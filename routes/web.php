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

Route::get('/', function () {
    return view('pages.owner.dashboard');
});

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