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

Route::get('/get-group-task', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'GroupTaskController@getTask',
	'roles' => ['Group'] // Only a logged in user can view this page
]);

Route::get('/get-individual-task', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@getTask',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/unscramble-words-group', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'GroupTaskController@unscrambleWords',
	'roles' => ['Group'] // Only a logged in user can view this page
]);

Route::get('/participant-login', [
	'uses' => 'LoginController@participantLogin',
]);

Route::post('/participant-login', [
	'uses' => 'LoginController@postParticipantLogin',
]);

Route::get('/group-login', [
	'uses' => 'LoginController@groupLogin',
]);

Route::post('/group-login', [
	'uses' => 'LoginController@postGroupLogin',
]);
