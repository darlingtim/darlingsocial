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







// normal Authenticatation Route
//Route::post('v1/register', 'Auth\RegisterController@register');
//Route::post('v1/login', 'Auth\LoginController@login');
// Authentication Route
Route::post('v1/login', 'Api\v1\ApiController@login');
Route::post('v1/register', 'Api\v1\ApiController@register');

Route::group(['prefix' => 'v1', 'middleware'=>'auth.jwt'], function () {
    //logout route
    Route::get('logout', 'Api\v1ApiController@logout');
    //Routes for Tasks
    Route::get('tasks', 'Api\v1\TaskController@index');
    Route::get('tasks/{id}', 'Api\v1\TaskController@show');
    Route::post('tasks', 'Api\v1\TaskController@store');
    Route::put('tasks/{id}', 'Api\v1\TaskController@update');
    Route::delete('tasks/{id}', 'Api\v1\TaskController@destroy');

    //Routes for Aticles...
    Route::get('articles', 'Api\v1\ArticleController@index');
    Route::get('articles/{id}', 'Api\v1\ArticleController@show');
    Route::post('articles', 'Api\v1\ArticleController@store');
    Route::put('articles/{id}', 'Api\v1\ArticleController@update');
    Route::delete('articles/{id}', 'Api\v1\ArticleController@delete');

    // Routes for Todos

    Route::get('notes', 'Api\v1\NoteController@index');
    Route::get('notes/{id}', 'Api\v1\NoteController@show');
    Route::post('notes', 'Api\v1\NoteController@store');
    Route::put('notes/{id}', 'Api\v1\NoteController@update');
    Route::delete('notes/{id}', 'Api\v1\NoteController@destroy');


});


//implicit route model binding

/*Route::get('articles', 'ArticleController@index');
Route::get('articles/{article}', 'ArticleController@show');
Route::post('articles', 'ArticleController@store');
Route::put('articles/{article}', 'ArticleController@update');
Route::delete('articles/{article}', 'ArticleController@delete');
*/
