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
  
  
/*Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});*/

Route::group(['middleware' => 'api','prefix' => 'auth'
], 
function ($router) {
    Route::post('/login', 'App\Http\Controllers\AuthController@login');
    Route::post('/register', 'App\Http\Controllers\AuthController@register');
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('/refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::get('/user-profile', 'App\Http\Controllers\AuthController@userProfile');    
});


