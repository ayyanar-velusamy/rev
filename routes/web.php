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

Route::get('/', 'PagesController@index')->name('index');
Route::get('/home-health-care-about-us', 'PagesController@about')->name('about-us');
Route::get('/home-health-care-history', 'PagesController@history')->name('history');
Route::get('/home-health-care-quality-measures', 'PagesController@quality_measures')->name('quality-measures');

Route::get('/home-health-care-our-services', 'PagesController@our_services')->name('our-services');
Route::get('/home-health-care-nursing-services', 'PagesController@nursing_services')->name('nursing-services');
Route::get('/home-health-care-home-health-aide-and-home-maker-services', 'PagesController@health_aid_services')->name('health-aid-services');
Route::get('/home-health-care-physical-occupational-and-speech-therapy', 'PagesController@physical_occupational_services')->name('physical-occupational-services');
Route::get('/home-health-care-revival-university', 'PagesController@revival_university')->name('revival-university');
Route::get('/home-health-care-waiver-program', 'PagesController@waiver_program')->name('waiver-program');

Route::get('/home-health-care-careers', 'PagesController@careers')->name('careers');
Route::get('/home-health-care-resources', 'PagesController@resources')->name('resources');
Route::get('/home-health-care-contact-us', 'PagesController@contact')->name('contact');
 

Route::get('/admin', function () { return redirect('login');  /*return view('welcome'); */ });
Auth::routes(['register'=>false]);
Route::get('password/set/{token}', 'Auth\ResetPasswordController@showSetForm');
Route::post('password/set', 'Auth\ResetPasswordController@setPassword')->name('set_password');
Route::post('password/reset', 'Auth\ResetPasswordController@resetPassword')->name('reset_password');
Route::get('verify/email/{token}', 'Auth\ResetPasswordController@verifyEmail');

Route::group(['middleware'=>'auth'], function(){	
	Route::get('/home', 'DashboardController@index')->name('home');
	Route::resource('/dashboard', 'DashboardController'); 
	
	//User management
	Route::get('/user_list', 'UserController@ajax_list')->name('user_list');
	Route::put('/users/status/{id}', 'UserController@status')->name('users.status');
	Route::post('/users/grade_list', 'UserController@grade_list')->name('users.grade_list');
	Route::post('/bulk_upload', 'UserController@bulk_upload')->name('bulk_upload');
	Route::get('/profile', 'UserController@profile_view')->name('profile_view');
	Route::get('/profile/edit', 'UserController@profile_edit')->name('profile_edit');
	Route::post('users/NotifMarkAsRead', 'UserController@NotifMarkAsRead')->name('NotifMarkAsRead');
	Route::get('users/check_user_status', 'UserController@check_user_status')->name('check_user_status');
	Route::post('/change_password', 'UserController@change_password')->name('change_password');
	Route::post('/profile_update', 'UserController@profile_update')->name('users.profile_update');
	Route::resource('users', 'UserController');
	
	//Page management
	Route::get('/page_list', 'PageManagementController@ajax_list')->name('page_list'); 
	Route::put('/pages/status/{id}', 'PageManagementController@status')->name('pages.status');
	Route::resource('pages', 'PageManagementController');    
	
	//Page management
	Route::get('/slider_list', 'SliderController@ajax_list')->name('slider_list'); 
	Route::put('/sliders/status/{id}', 'SliderController@status')->name('sliders.status');
	Route::resource('sliders', 'SliderController');    
	
	
	//Role management
	Route::get('/role_list', 'RoleController@ajax_list')->name('role_list');
	Route::resource('roles', 'RoleController'); 
});

