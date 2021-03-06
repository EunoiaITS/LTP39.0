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
Route::post('login', 'Api@login');

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'Api@details');
    Route::post('check-in', 'Api@checkIn');
    Route::post('check-out', 'Api@checkOut');
    Route::post('vip-request', 'Api@vipRequest');
    Route::post('vip-check-in', 'Api@vipCheckIn');
    Route::post('vip-check-out', 'Api@vipCheckOut');
});

Route::prefix('v1')->group(function(){
    Route::post('/login', 'APIV2@login');
    Route::middleware('APIToken')->group(function () {
        Route::post('check-in', 'APIV2@checkIn');
        Route::post('check-out', 'APIV2@checkOut');
        Route::post('vip-request', 'APIV2@vipRequest');
        Route::post('vip-check-in', 'APIV2@vipCheckIn');
        Route::post('vip-check-out', 'APIV2@vipCheckOut');
        Route::get('/logout','APIV2@logout');
        Route::post('reports','APIV2@reports');
        Route::post('stats','APIV2@stats');
        Route::post('test-check-out', 'APIV2@testCheckOut');
    });
});
