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
    return redirect()->route('login');;
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/comments', 'CommentController@index')->name('comments');
Route::get('/comments/get-json', 'CommentController@getJson');
Route::get('/comments/get-count', 'CommentController@getCount');

Route::post('/comments-save', 'CommentController@store');
Route::delete('/comments', 'CommentController@delete'); 
Route::get('/comment-delete', 'CommentController@delete'); 

Route::get('/profile/edit', 'ProfileController@index');
Route::post('/profile/edit', 'ProfileController@update')->name('image.upload.post');

Route::get('/profile/id={id}', 'ProfileController@show');
Route::get('/profile', 'ProfileController@show');

Route::get('/get_regions', 'ResidenceController@getRegions');
Route::get('/get_city', 'ResidenceController@getCities');

Route::get('/answer', 'AnswerController@index');
Route::get('/answer-get', 'AnswerController@getYesNo');

Route::post('/getTimeline', 'TwitterController@getUserTimeline');

Auth::routes(['verify' => true]);