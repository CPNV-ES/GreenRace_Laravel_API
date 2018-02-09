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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// get all
Route::get('categories', 'CategoryController@index');
// get by id
Route::get('category/{category}', 'CategoryController@show');
// create
Route::post('category', 'CategoryController@store');
// modify
Route::put('category/{category}', 'CategoryController@update');
// delete
Route::delete('category/{category}', 'CategoryController@delete');
