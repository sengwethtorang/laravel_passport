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
// Access Token
Route::post('login', 'Api\AuthController@getAccessToken'); 
Route::post('refresh_token', 'Api\AuthController@getAccessTokenByRefreshToken');
// End Access Token

Route::group(['middleware'=>'auth:api','locale'],function(){

    Route::get('user', function(Request $request){
        return response()->json([
            'status' => true,
            'data' => $request->user()
        ]);
    });
    


});
