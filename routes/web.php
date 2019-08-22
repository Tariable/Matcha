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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->middleware('verified')->name('home');
Route::get('/photos/create', 'PhotoController@create')->middleware('verified');
Route::post('/photos', 'PhotoController@store');
Route::get('/photos/{user}', 'PhotoController@show');

Route::get('/profiles/create', 'ProfilesController@create');
Route::post('/profiles', 'ProfilesController@store');
Route::get('/profiles/{id}/create', 'ProfilesController@edit');
Route::put('/profiles/{id}', 'ProfilesController@update');
Route::delete('/profiles/{id}', 'ProfilesController@destroy');

