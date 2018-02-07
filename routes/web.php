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

Route::get('/group-experiment-end', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'GroupTaskController@endExperiment',
	'roles' => ['Group'] // Only a logged in user can view this page
]);


Route::get('/get-individual-task', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@getTask',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/end-individual-task', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@endTask',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/store-task-data', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@storeTaskData',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/participant-experiment-end', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@endExperiment',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/unscramble-words-intro', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'GroupTaskController@unscrambleWordsIntro',
	'roles' => ['Group'] // Only a logged in user can view this page
]);

Route::get('/unscramble-words', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'GroupTaskController@unscrambleWords',
	'roles' => ['Group'] // Only a logged in user can view this page
]);

Route::post('/unscramble-words', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'GroupTaskController@scoreUnscrambleWords',
	'roles' => ['Group'] // Only a logged in user can view this page
]);

Route::get('/brainstorming-individual-intro', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@brainstormingIntro',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/brainstorming-individual', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@brainstorming',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::post('/brainstorming-individual', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@scoreBrainstorming',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/optimization-individual-intro', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@optimizationIntro',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/optimization-individual', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@optimization',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::post('/optimization-individual', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@saveOptimizationGuess',
	'roles' => ['Participant'] // Only a logged in user can view this page
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
