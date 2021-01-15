<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });




 
// Route::get('provinces', 'API\LocationController@provinces')->name('api-provinces');
// Route::get('regencies/{provinces_id}', 'API\LocationController@regencies')->name('api-regencies');

// Route::middleware('auth:api')->get('/user', 'UserController@AuthRouteAPI');



//Route::GET('/register/check', 'MarketController@check')->name('check-register');
// Route::GET('/provinces', 'Api\LocationController@Provinces')->name('api-provinces');
// Route::GET('/regencies/{province_id}', 'Api\LocationController@regencies')->name('api-regencies');

//  Route::middleware('auth:api')->get('/user', function (Request $request) {
//      return $request->user();
//  });
Route::get('/register/check', 'Auth\RegisterController@check')->name('api-register-check');
Route::GET('/provinces', 'Api\LocationController@Provinces')->name('api-provinces');
Route::GET('/regencies/{province_id}', 'Api\LocationController@Regencies')->name('api-regencies');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});