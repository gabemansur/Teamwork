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

Route::get('/individual-task-results', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@showTaskResults',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/end-individual-task', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@endTask',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::post('/mark-individual-response-complete', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'AjaxController@markIndividualResponseComplete',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);


Route::get('/group-login-allowed', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'AjaxController@groupLoginAllowed',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/check-task-completion', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'AjaxController@checkTaskCompletion',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::post('/store-task-data', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'AjaxController@storeTaskData',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/participant-experiment-end', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@endExperiment',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/team-role-intro', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@teamRoleIntro',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/team-role', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@teamRole',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::post('/team-role', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@saveTeamRole',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/team-role-end', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@teamRoleEnd',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/big-five-intro', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@bigFiveIntro',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/big-five', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@bigFive',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::post('/big-five', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@saveBigFive',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/big-five-end', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@bigFiveEnd',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/memory-individual-intro', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@memoryIntro',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/memory-individual', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@memory',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::post('/memory-individual', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@saveMemory',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/rmet-individual', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@eyes',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::post('/rmet-individual', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@saveEyes',
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

Route::get('/optimization-individual-alt-intro', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@optimizationAltIntro',
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

Route::post('/optimization-individual-final', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@saveOptimizationFinalGuess',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/shapes-individual-intro', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@shapesIntro',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/shapes-individual', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@shapesIndividual',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::post('/shapes-individual', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@saveShapesIndividual',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/shapes-individual-result', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@shapesIndividualResult',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/optimization-group', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'GroupTaskController@optimization',
	'roles' => ['Group'] // Only a logged in user can view this page
]);

Route::post('/optimization-group', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'GroupTaskController@saveOptimization',
	'roles' => ['Group'] // Only a logged in user can view this page
]);

Route::get('/get-prob-val', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'AjaxController@getProbVal',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/cryptography-intro', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'GroupTaskController@cryptographyIntro',
	'roles' => ['Group'] // Only a logged in user can view this page
]);

Route::get('/cryptography-individual-intro', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'IndividualTaskController@cryptographyIntro',
	'roles' => ['Participant'] // Only a logged in user can view this page
]);

Route::get('/cryptography', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'GroupTaskController@cryptography',
	'roles' => ['Group', 'Participant'] // Only a logged in user can view this page
]);

Route::post('/cryptography', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'GroupTaskController@saveCryptographyResponse',
	'roles' => ['Group', 'Participant'] // Only a logged in user can view this page
]);

Route::get('/cryptography-test', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'GroupTaskController@saveCryptographyResponse',
	'roles' => ['Group', 'Participant'] // Only a logged in user can view this page
]);

Route::post('/cryptography-end', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'GroupTaskController@endCryptographyTask',
	'roles' => ['Group', 'Participant'] // Only a logged in user can view this page
]);

Route::get('/participant-login', [
	'uses' => 'LoginController@participantLogin',
]);

Route::post('/participant-login', [
	'uses' => 'LoginController@postParticipantLogin',
]);

Route::get('/individual-login', [
	'uses' => 'LoginController@individualLogin',
]);

Route::post('/individual-login', [
	'uses' => 'LoginController@postIndividualLogin',
]);

Route::get('/group-login', [
	'uses' => 'LoginController@groupLogin',
]);

Route::post('/group-login', [
	'uses' => 'LoginController@postGroupLogin',
]);

Route::get('/group-create', [
	'uses' => 'LoginController@groupCreateLogin',
]);

Route::post('/group-create', [
	'uses' => 'LoginController@postGroupCreateLogin',
]);

Route::get('/group-add-participants', [
	'uses' => 'LoginController@groupAddParticipants',
]);

Route::post('/group-add-participants', [
	'uses' => 'LoginController@postGroupAddParticipants',
]);

// Testing Routes

Route::get('/optimization-test', [
  'uses' => 'AjaxController@testOptimization',
]);

Route::get('/memory-test', [
  'uses' => 'IndividualTaskController@testMemory',
]);
