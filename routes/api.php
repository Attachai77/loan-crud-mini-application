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


Route::post('/loan/create', 'LoanController@store');
Route::get('/loan/edit/{id}', 'LoanController@edit');
Route::post('/loan/update/{id}', 'LoanController@update');
Route::delete('/loan/delete/{id}', 'LoanController@delete');
Route::get('/loans', 'LoanController@index');