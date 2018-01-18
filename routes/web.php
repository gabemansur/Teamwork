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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'TestController@test',
	'roles' => ['researcher'] // Only a logged in user can view this page
]);

Route::get('/participant-login', [
	'uses' => 'LoginController@participantLogin',
]);

Route::post('/player-login', [
	'uses' => 'LoginController@postParticipantLogin',
]);
