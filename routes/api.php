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

Route::get('/services/{day?}','ServiceController@index');
Route::get('/service/{id}','ServiceController@show');
Route::post('/service','ServiceController@store');
Route::put('/service/{id}','ServiceController@update');
Route::delete('/service/{id}','ServiceController@destroy');