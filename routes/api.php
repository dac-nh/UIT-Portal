<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('/applied-students', 'AgentController@getAppliedStudentListAPI');
Route::get('/universities', function () {
    return \App\Models\University::all();
});
Route::get('/companies', function () {
    return \App\Models\Company::all();
});
Route::get('/skills', function () {
    return \App\Models\Skill::all();
});
Route::get('projects/', [
    'uses' => 'ProjectController@getProjectListAPI',
    'as' => 'projects.get_list'
]);
Route::post('/hiring-projects', 'ProjectController@getHiringProjectsListAPI');

Route::post('/applied-student-list', [
    'uses' => 'ProjectController@postAppliedStudentListAPI',
]);

Route::post('/in-progress-projects', 'ProjectController@getInProgressProjectsListAPI');
Route::post('/finished-projects', 'ProjectController@getFinishedProjectsListAPI');
Route::post('/applied-list-hiring-projects', 'CompanyController@getAppliedListHiringProjectAPI');
Route::post('/reject-apply', 'CompanyController@rejectApplyAPI');
Route::post('/confirm-join', 'CompanyController@confirmJoinAPI');
Route::post('/student/cv', 'CVController@getCVByStudent');
Route::post('/student/applied-list', 'StudentController@getAppliedListByStudent');
Route::post('/create/project','AgentController@createProjectAPI');
