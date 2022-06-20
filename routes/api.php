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
    Route::post('password/reset', 'App\Http\Controllers\AuthController@sendReset');
    Route::post('password/forgot-password','App\Http\Controllers\AuthController@sendResetLink');
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('/refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::get('/user-profile', 'App\Http\Controllers\AuthController@userProfile');    
});

Route::group(['middleware' => 'api', 'prefix' => 'postagens'
],
function($posts)
{
  Route::get('/homeapp', 'App\Http\Controllers\PostagensController@getAllPostagens');
  Route::get('/view/{id}', 'App\Http\Controllers\PostagensController@getPostagens');
  Route::post('/create', 'App\Http\Controllers\PostagensController@createPostagens');
  Route::put('/update/{id}', 'App\Http\Controllers\PostagensController@updatePostagens');
  Route::delete('/delete/{id}', 'App\Http\Controllers\PostagensController@deletePostagens');
});


