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
Route::group(['prefix' => 'v1'], function(){
  /*Route::middleware('auth:api')->get('/user', function (Request $request) {
      return $request->user();
  });*/
  // logged routes
  Route::group(['middleware' => ['auth:api']], function(){
    // login
    Route::get('/user', function (Request $request){ return $request->user();});

    // Categories routes
    // create
    Route::post('category', 'CategoryController@store');
    // modify
    Route::put('category/{category}', 'CategoryController@update');
    Route::patch('category/{category}', 'CategoryController@update');
    // delete
    Route::delete('category/{category}', 'CategoryController@delete');

    // Trips routes
    // create
    Route::post('trip', 'TripController@store');
    // modify
    Route::put('trip/{trip}', 'TripController@update');
    Route::patch('trip/{trip}', 'TripController@update');
    // delete
    Route::delete('trip/{trip}', 'TripController@delete');

    // Vehicle routes
    // create
    Route::post('vehicle', 'VehicleController@store');
    // modify
    Route::put('vehicle/{vehicle}', 'VehicleController@update');
    Route::patch('vehicle/{vehicle}', 'VehicleController@update');
    // delete
    Route::delete('vehicle/{vehicle}', 'VehicleController@delete');
  });
  // Categories routes
  // get all
  Route::get('categories', 'CategoryController@index');
  // get by id
  Route::get('category/{category}', 'CategoryController@show');

  // Trips routes
  // get all
  Route::get('trips', 'TripController@index');
  // get by id
  Route::get('trip/{trip}', 'TripController@show');

  // Vehicle routes
  // get all
  Route::get('vehicles', 'VehicleController@index');
  // get by id
  Route::get('vehicle/{vehicle}', 'VehicleController@show');

});
