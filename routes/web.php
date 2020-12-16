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

Route::group(['middleware'=>'language'],function ()
{
    Route::get('/', 'PagesController@index')->name('index');
Route::get('/home-health-care-about-us', 'PagesController@pages')->name('about-us');  
Route::get('/home-health-care-history', 'PagesController@pages')->name('history');
Route::get('/home-health-care-quality-measures', 'PagesController@pages')->name('quality-measures'); 
Route::get('/home-health-care-our-services', 'PagesController@pages')->name('our-services');
Route::get('/home-health-care-nursing-services', 'PagesController@pages')->name('nursing-services');
Route::get('/home-health-care-home-health-aide-and-home-maker-services', 'PagesController@pages')->name('health-aid-services');
Route::get('/home-health-care-physical-occupational-and-speech-therapy', 'PagesController@pages')->name('physical-occupational-services');
Route::get('/home-health-care-revival-university', 'PagesController@pages')->name('revival-university');
Route::get('/home-health-care-waiver-program', 'PagesController@pages')->name('waiver-program'); 
Route::get('/home-health-care-find-an-office', 'PagesController@find_location')->name('find-location');
Route::get('/home-health-care-company-contact-form', 'PagesController@company_contact_form')->name('company-contact-form'); 
Route::get('/home-health-care-maryland-contact-form', 'PagesController@maryland_contact_form')->name('maryland-contact-form'); 
Route::get('/home-health-care-annandale-contact-form', 'PagesController@annandale_contact_form')->name('annandale-contact-form'); 
Route::get('/home-health-care-richmond-contact-form', 'PagesController@richmond_contact_form')->name('richmond-contact-form'); 
Route::get('/home-health-care-houston-contact-form', 'PagesController@houston_contact_form')->name('houston-contact-form'); 
Route::get('/home-health-care-careers', 'PagesController@pages')->name('careers');
Route::get('/home-health-care-resources', 'PagesController@pages')->name('resources');   
Route::get('/home-health-care-contact-us', 'PagesController@contact')->name('contact'); 
Route::post('/enquiry', 'PagesController@enquiry')->name('enquiry');

Route::get('/home-health-care-schedule-an-assessment', 'PagesController@schedule_an_assessment')->name('schedule'); 
Route::get('/home-health-care-insurance-accepted', 'PagesController@insurance_accepted')->name('insurance-accepted'); 
Route::get('/home-health-care-meet-our-staff', 'PagesController@meet_our_staff')->name('meet-our-staff'); 
Route::get('/home-health-care-submit-your-referrals', 'PagesController@submit_referrals')->name('submit-referrals'); 
Route::get('/home-health-care-clients-testimonials', 'PagesController@pages')->name('testimonials');   

Route::any('/revival/{route}', 'PagesController@dynamic_pages');
 
});


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
	
	//Slider management
	Route::get('/slider_list', 'SliderController@ajax_list')->name('slider_list'); 
	Route::put('/sliders/status/{id}', 'SliderController@status')->name('sliders.status');
	Route::resource('sliders', 'SliderController');

	//Slider management
	Route::get('/enquiry_list', 'EnquiryController@ajax_list')->name('enquiry_list');  
	Route::resource('enquiries', 'EnquiryController');    
	
	
	//Role management
	Route::get('/role_list', 'RoleController@ajax_list')->name('role_list');
	Route::resource('roles', 'RoleController'); 
});

Route::get('setlocale/{locale}',function($lang){
       \Session::put('locale',$lang);
       return redirect()->back();   
});

