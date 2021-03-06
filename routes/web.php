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
    return redirect('/recs');
});

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['verified']], function () {

    Route::get('/about', function() {
        return view('about.about');
    });

    Route::get('/photos/last/{profileId}', 'PhotoController@getLastPhoto');
    Route::get('/photos/{profileId}', 'PhotoController@show');
    Route::post('/photos', 'PhotoController@store');
    Route::delete('/photos/{photoId}', 'PhotoController@destroy');

    Route::get('/profiles/all', 'ProfileController@get');
    Route::get('/profiles/create', 'ProfileController@create')->middleware('firstTime');
    Route::post('/profiles', 'ProfileController@store');
    Route::get('/profiles/edit', 'ProfileController@edit')->middleware('allowEdit');
    Route::post('/profiles/update', 'ProfileController@update');
    Route::delete('/profiles/{id}', 'ProfileController@destroy');

    Route::get('/preferences', 'PreferenceController@index');
    Route::get('/preferences/create', 'PreferenceController@create')->middleware('firstTime');
    Route::post('/preferences', 'PreferenceController@store');
    Route::get('/preferences/edit', 'PreferenceController@edit')->middleware('allowEdit');
    Route::post('/preferences/update', 'PreferenceController@update');

    Route::post('/ban/{id}', 'BanController@store');
    Route::post('/like/{id}', 'LikeController@store');
    Route::get('/like/all', 'LikeController@getWhoLikedMe');

    Route::get('/recs/all', 'RecommendationController@getRecs');
    Route::get('/recs/{id}', 'RecommendationController@getProfile');
    Route::get('/recs', 'RecommendationController@show')->middleware('profileExists');

    Route::get('/chats', 'ChatController@getChats');
    Route::get('/chats/{chatId}', 'ChatController@getMessages');

    Route::post('/report', 'ReportController@store');

    Route::get('/messages', 'MessageController@index');
    Route::post('/messages', 'MessageController@store');
    Route::get('/messages/getAllChats', 'MessageController@getChats');
});

Route::get('login/github', 'Auth\LoginController@redirectToProvider');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');

