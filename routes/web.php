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

Route::get('/', function () {
    return view('welcome');
});

Route::get('tasks/{task}/create', 'TasksController@create')->name('tasks.create_child');
Route::post('tasks/{task}', 'TasksController@store')->name('tasks.store_child');
Route::resources([
    'tasks' => 'TasksController',
]);