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

use Illuminate\Support\Facades\Auth;

Route::get('/', [
    'uses' => 'PublicViewController@home',
    'as' => 'home'
]);
/**
 * AGENT
 */
Route::get('/manage-uni', [
    'uses' => 'AgentController@getUniManagement',
    'as' => 'getUniManagement'
]);
Route::get('/manage-lecturer', [
    'uses' => 'AgentController@getLecturerManagement',
    'as' => 'getLecturerManagement'
]);
Route::post('/export/student', [
    'uses' => 'AgentController@exportStudentList',
    'as' => 'exportStudentList'
]);
Route::post('/export/applied-students', [
    'uses' => 'AgentController@exportAppliedStudentListAPI',
    'as' => 'exportAppliedList'
]);
Route::get('/applied-students', [
    'uses' => 'AgentController@getAppliedStudentView',
    'as' => 'getAppliedList'
]);
Route::get('/create-lecture-account', [
    'uses' => 'AgentController@getCreateLecture',
    'as' => 'getCreateLecture'
]);
Route::post('/create-lecture-account', [
    'uses' => 'AgentController@createLecture',
    'as' => 'createLecture'
]);
Route::get('/create-company-account', [
    'uses' => 'AgentController@getCreateCompanyAgent',
    'as' => 'getCreateCompanyAgent'
]);
Route::post('/create-company-account', [
    'uses' => 'AgentController@createCompanyAgent',
    'as' => 'createCompanyAgent'
]);
Route::get('/manage-project', [
    'uses' => 'AgentController@getManageProjectView',
    'as' => 'getManageProjectView'
]);

/**
 * COMPANY
 */
Route::get('/manage-company', [
    'uses' => 'CompanyController@getCompanyManagement',
    'as' => 'getCompanyManagement'
]);
Route::get('/project-hiring/{id}', [
    'uses' => 'CompanyController@getProjectHiring',
    'as' => 'getProjectHiring'
]);
// 16-12-2016: Dac: getlist all university
Route::get('get-list-universities', [
    'uses'=>'UniversityController@getListUniversity'
]);
/**
 * PROJECT
 */
Route::post('projects/{project_id}/apply', [
    'uses' => 'ProjectController@postApplyProject',
    'as' => 'projects.apply_post'
]);
Route::post('projects/{project_id}/apply/{student_id}/saveFile', [
    'uses' => 'ProjectController@postApplyProject_saveFile',
    'as' => 'projects.apply_post.saveFile'
]);


Route::get('projects/{project_id}/', [
    'uses' => 'ProjectController@getProjectDetail',
    'as' => 'projects.get_detail'
]);

Route::post('projects/{project_id}/nominate', [
    'uses' => 'ProjectController@postNominateStudent',
    'as' => 'projects.nominateStudent'
]);

Route::get('projects/{project_id}/apply', [
    'uses' => 'ProjectController@getApplyProject',
    'as' => 'projects.apply_get'
]);

Route::get('hiring-projects/', [
    'uses' => 'ProjectController@getHiringProjectsView',
    'as' => 'getHiringProjectsView'
]);
Route::get('finished-projects/', [
    'uses' => 'ProjectController@getHiringProjectsView',
    'as' => 'getFinishedProjectsView'
]);
Route::get('in-progress-projects/', [
    'uses' => 'ProjectController@getHiringProjectsView',
    'as' => 'getInProgressProjectsView'
]);

Route::post('cancelRegister/{project_id}', [
    'uses' => 'ProjectController@postCancelRegister',
    'as' => 'postCancelRegister'
]);

Route::get('manage-student', [
    'uses' => 'StudentController@getManageStudentView',
    'as' => 'getManageStudent'
]);
Route::post('confirmRegister/{project_id}', [
    'uses' => 'ProjectController@postConfirmRegister',
    'as' => 'postConfirmRegister'
]);

//Lay danh sach sinh vien
Route::get('list-student', [
    'uses' => 'StudentController@getListStudentView',
    'as' => 'getListStudent'
]);

Route::post('list-student', [
    'uses' => 'StudentController@getListStudent',
    'as' => 'getListStudent'
]);

//Lay danh sach doanh nghiep
Route::get('list-company', [
    'uses' => 'CompanyController@getListCompanyView',
    'as' => 'getListCompany'
]);

Route::post('list-company', [
    'uses' => 'CompanyController@postListCompany',
    'as' => 'postListCompany'
]);

//Tim kiem sinh vien
Route::post('list-student/search', [
    'uses' => 'StudentController@searchStudent',
    'as' => 'searchStudent'
]);

/**
 * STUDENT PROFILE
 */
Route::get('profile_student/{student_id}', [
    'uses' => 'StudentController@getStudentInfo',
    'as' => 'getStudentInfo'
]);
Route::post('user/profile/{id}', [
    'middleware' => 'isAllowedComment',
    'uses' => 'StudentController@postCommentUserDetail',
    'as' => 'comment_user_detail'
]);
Route::post('user/profile/{id}/update-profile', [
    'middleware' => 'isActiveJs',
    'uses' => 'StudentController@postUpdateStudentProfile'
]);
Route::post('user/profile/{id}/update-intro', [
    'middleware' => 'isActiveJs',
    'uses' => 'StudentController@postUpdateIntro'
]);


/**
 * AUTHENTICATION
 */
Auth::routes();
// 03-11-2016: Dac: register and login
Route::get('/sign-in', [
    'uses' => 'UserController@getSignIn',
    'as' => 'sign_in'
]);
Route::get('/sign-up', [
    'uses' => 'UserController@getSignUp',
    'as' => 'sign_up'
]);
Route::post('/sign-up', [
    'uses' => 'UserController@postSignUpUser',
    'as' => 'post_sign_up'
]);
Route::post('/sign-in', [
    'uses' => 'UserController@postSignIn',
    'as' => 'post_sign_in'
]);
Route::post('/google-sign-in', [
    'uses' => 'UserController@postGoogle',
    'as' => 'google_sign_in'
]);
Route::post('logout', [
    'uses' => 'Auth\LoginController@logout',
    'as' => 'sign_out'
]);
// Password Reset Routes...
Route::get('password/reset', [
    'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::get('password/reset/{token}', [
    'uses' => 'Auth\ResetPasswordController@showResetForm'
]);
Route::get('user/check-password-token/{token}', [
    'uses' => 'UserController@getCheckTokenPassword',
    'as' => 'check_token_password'
]);
Route::post('user/set-password-token', [
    'uses' => 'UserController@postSetPasswordToken',
    'as' => 'set_password_token'
]);
Route::post('password/email', [
    'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);

Route::post('password/reset', [
    'uses' => 'Auth\ResetPasswordController@reset'
]);

/**
 * CV
 */
Route::get('list-cv/{student_id}', [
    'uses' => 'CVController@getListCVView',
    'as' => 'getListCVView'
]);

Route::post('student/{student_id}/saveCV', [
    'uses' => 'CVController@postSaveCV',
    'as' => 'cvs.saveCV'
]);

Route::post('student/{student_id}/deleteCV', [
    'uses' => 'CVController@postDeleteCV',
    'as' => 'cvs.deleteCV'
]);

Route::post('student/{student_id}/editCV', [
    'uses' => 'CVController@postEditCV',
    'as' => 'cvs.editCV'
]);

/*
 * USER ROUTE
 */
Route::get('user/{id}', [
    'uses' => 'StudentController@getStudentProfile',
    'as' => 'get_user_detail'
]);
Route::get('user/profile/{id}', [
    'middleware' => 'checkUserRoleUserDetail',
    'uses' => 'StudentController@getStudentProfile',
    'as' => 'get_current_user_detail'
]);
Route::post('user/profile/{id}/change-avatar', [
    'middleware'=>'isActiveJs',
    'uses'=>'UserController@postChangeAvatar'
]);

// Create project
Route::get('create/project',[
   'uses' => 'AgentController@getCreateProjectView',
    'as' => 'getCreateProjectView'
]);
/**
 * ADMIN
 */
Route::get('admin', function(){
    return view('admin.logHistoryUserLogin');
});