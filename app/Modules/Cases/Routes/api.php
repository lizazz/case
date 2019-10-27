<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/cases/rates', 'CaseController@index');
Route::post('/cases/show', 'CaseController@getCases');
Route::get('/cases/top', 'CaseController@top');
