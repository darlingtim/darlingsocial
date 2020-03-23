<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();
//Route::get('/', function () {
   // return view('welcome');
//});

// View the dashboard
Route::get('/dashboard', 'DashboardController@index')->name('Dashboard');
// View all Todo lists
Route::get('/todo','TodoController@index');
// View the form for creating a Todo
Route::get('/createTodo', 'TodoController@createForm');
// view a single Todo
Route::get('/todo/{$id}');

// creating and saving  a todo list
Route::post('/todo', 'TodoController@createTodo');
// editing a todo list
Route::put('/todo/{$id}', 'TodoController@editTodo');

// deleting a todo list
Route::delete('/todo/{$id}', 'TodoController@deleteTodo');

