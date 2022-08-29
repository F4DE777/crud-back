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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::get('/', "UserController@index");

Route::get('/login', "UserController@login");
Route::get('/get-user-data', "UserController@getUserData");
Route::get('/get-all-users', "UserController@getAllUsers");
Route::post('/sign-up', "UserController@signUp");
Route::post('/edit', "UserController@edit");
Route::post('/delete', "UserController@delete");




