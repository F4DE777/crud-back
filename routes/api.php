<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


Route::get('/login', "UserController@login");

Route::group(['middleware' => 'jwt.auth','prefix' => 'auth'], function () {
    Route::get('/get-user-data', "UserController@getUserData");
    Route::get('/get-all-users', "UserController@getAllUsers");
    Route::get('/get-all', "UserController@getAll");
    Route::post('/sign-up', "UserController@signUp");
    Route::post('/edit', "UserController@edit");
    Route::post('/delete', "UserController@delete");
    Route::post('me', 'UserController@me');
    Route::get('/', "UserController@index");

});


