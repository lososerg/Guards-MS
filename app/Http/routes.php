<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('warofdragons', 'WelcomeController@index');
Route::get('/', function() {
	return view('main');
});
Route::get('/noaccessgranted', function() {
	return 'Contact your head guard/admin to switch on your account!';
});
Route::get('home', ['middleware' => 'access', 'uses' => 'HomeController@index']);
Route::get('cases', ['middleware' => 'access', 'uses' => 'CasesController@index']);
Route::get('case/create', ['middleware' => 'access', 'uses' => 'CasesController@create']);
Route::get('cases/closed', ['middleware' => 'access', 'uses' => 'CasesController@loadClosedCases']);
Route::get('case/{id}', ['middleware' => 'access', 'uses' =>'CasesController@load']);
Route::post('case/update/{id}', ['middleware' => 'access', 'uses' =>'CasesController@update']);
Route::post('cases', ['middleware' => 'access', 'uses' => 'CasesController@store']);
Route::get('users', ['middleware' => 'access', 'uses' => 'UserController@index']);
Route::get('user/{id}', ['middleware' => 'access', 'uses' => 'UserController@show']);
Route::post('user/edit/{id}', ['middleware' => 'access', 'uses' => 'UserController@edit']);
Route::post('user/update/{id}', ['middleware' => 'access', 'uses' => 'UserController@upgrate']);
Route::get('cases/mydepartment', ['middleware' => 'access', 'uses' => 'CasesController@showMyDepartmentCases']);
Route::get('cases/helpdesk', ['middleware' => 'access', 'uses' => 'CasesController@showHelpDeskCases']);
Route::get('cases/mycases', ['middleware' => 'access', 'uses' => 'CasesController@showMyCases']);
Route::post('case/delete/{id}', ['middleware' => 'access', 'uses' => 'CasesController@delete']);
Route::post('comment/add', ['middleware' => 'access', 'uses' => 'CommentController@store']);
Route::get('cases/foradmins', ['middleware' => 'access', 'uses' => 'CasesController@casesForAdmins']);
Route::post('user/lang', ['middleware' => 'access', 'uses' => 'UserController@changeLanguage']);
Route::get('stats', ['middleware' => 'access', 'uses' => 'UserController@stats']);
Route::get('show/user/cases/inprogress/{id}', ['middleware' => 'access', 'uses' => 'CasesController@showUserCasesInProgress']);
Route::get('show/user/cases/new/{id}', ['middleware' => 'access', 'uses' => 'CasesController@showUserCasesNew']);
Route::get('show/user/cases/closed/{id}', ['middleware' => 'access', 'uses' => 'CasesController@showUserCasesClosed']);
Route::get('show/user/cases/created/{id}', ['middleware' => 'access', 'uses' => 'CasesController@showUserCasesCreated']);
Route::get('search', ['middleware' => 'access', 'uses' => 'CasesController@search']);
Route::get('structure/{server}/{race}', ['middleware' => 'access', 'uses' => 'UserController@loadGuardsStructure']);
Route::get('edit_fine/{id}', ['middleware' => 'access', 'uses' => 'CasesController@openFineEdit']);
Route::post('change/fine', ['middleware' => 'access', 'uses' => 'CasesController@changePenalty']);
Route::get('penalty/create/{id}', ['middleware' => 'access', 'uses' => 'PenaltyController@create']);
Route::get('penalty/edit/{id}', ['middleware' => 'access', 'uses' => 'PenaltyController@edit']);
Route::post('penalty/store', ['middleware' => 'access', 'uses' => 'PenaltyController@store']);
Route::post('penalty/update', ['middleware' => 'access', 'uses' => 'PenaltyController@update']);
Route::post('perpetrator/destroy/{id}', ['middleware' => 'access', 'uses' => 'PerpetratorController@destroy']);
Route::get('perpetrator/edit/{id}', ['middleware' => 'access', 'uses' => 'PerpetratorController@edit']);



Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);
