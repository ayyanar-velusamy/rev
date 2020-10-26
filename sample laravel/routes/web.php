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

Route::get('/', function () { return redirect('login');  /*return view('welcome'); */ });

Auth::routes(['register'=>false]);
Route::get('password/set/{token}', 'Auth\ResetPasswordController@showSetForm');
Route::post('password/set', 'Auth\ResetPasswordController@setPassword')->name('set_password');
Route::post('password/reset', 'Auth\ResetPasswordController@resetPassword')->name('reset_password');
Route::get('verify/email/{token}', 'Auth\ResetPasswordController@verifyEmail');

Route::group(['middleware'=>'auth'], function(){	
	Route::get('/home', 'DashboardController@index')->name('home');
	Route::get('/dev_dashboard', 'DashboardController@dev_dashboard')->name('dev_dashboard');
	Route::get('/approval_graph', 'DashboardController@approval_graph')->name('approval_graph');
	Route::get('/library_graph', 'DashboardController@library_graph')->name('library_graph');
	Route::get('/top_five_users', 'DashboardController@top_five_point_users')->name('top_five_point_users');
	Route::get('/milestone_graph', 'DashboardController@milestone_graph')->name('milestone_graph');
	Route::get('/user_signup_graph', 'DashboardController@user_signup_graph')->name('user_signup_graph');
	Route::get('/user_login_graph', 'DashboardController@user_login_graph')->name('user_login_graph');
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
	
	
	//Role management
	Route::get('/role_list', 'RoleController@ajax_list')->name('role_list');
	Route::resource('roles', 'RoleController');
	
	
	//Group management
	Route::get('/groups/group_list', 'GroupController@ajax_list')->name('group_list');
	Route::get('/groups/member_list/{id?}', 'GroupController@member_list')->name('groups.member_list');
	Route::post('/groups/add_member', 'GroupController@store_member')->name('groups.add_member');
	Route::post('/groups/make_admin', 'GroupController@make_admin')->name('groups.make_admin');
	Route::post('/groups/remove_member', 'GroupController@remove_member')->name('groups.remove_member');
	Route::post('/groups/new_admin', 'GroupController@new_admin')->name('groups.new_admin');
	Route::get('/groups/get_members_list', 'GroupController@group_members_list')->name('groups.get_members_list');
	Route::get('/groups/get_journeys_list', 'GroupController@group_journeys_list')->name('groups.get_journeys_list');
	Route::get('/groups/user_group_list', 'GroupController@user_group_list')->name('user_group_list');
	Route::post('/group_emp_list', 'GroupController@group_user_list')->name('group_user_list');
	Route::get('/groups/{id}/shared_board', 'GroupController@shared_board')->name('groups.shared_board');
	Route::get('/groups/{id}/load_post', 'GroupController@load_post')->name('groups.load_post');
	Route::get('/groups/load_post_comment/{id}', 'GroupController@load_post_comment')->name('groups.load_post_comment');
	Route::get('/groups/load_replay_comment/{id}', 'GroupController@load_replay_comment')->name('groups.load_replay_comment');
	Route::post('/groups/store_post', 'GroupController@store_post')->name('groups.store_post');
	Route::post('/groups/update_post/{id}', 'GroupController@update_post')->name('groups.update_post');
	Route::get('/groups/get_post/{id}', 'GroupController@get_post')->name('groups.get_post');
	Route::post('/groups/store_comment','GroupController@store_post_comment')->name('groups.store_comment');
	Route::post('/groups/update_comment/{id}', 'GroupController@update_comment')->name('groups.update_comment');
	Route::delete('/groups/post/{id}', 'GroupController@delete_post')->name('groups.delete_post');
	Route::delete('/groups/comment/{id}', 'GroupController@delete_post_comment')->name('groups.delete_comment');
	Route::delete('/groups/leave/{id}', 'GroupController@leave_group')->name('groups.leave_group');
	Route::get('/groups/create/{id?}', 'GroupController@create');
	Route::get('/groups/show/{group}/passport', 'GroupController@show')->name('groups.passport');
	Route::resource('groups', 'GroupController');
	
	//Organization management
	Route::resource('organization-chart', 'OrganizationController');
	Route::post('check_node', 'OrganizationController@check_node');
	Route::get('organization_list', 'OrganizationController@organization_list')->name('organization_list');

	
	//Journey management
	Route::get('/journey_list', 'JourneyController@ajax_list')->name('journey_list');
	Route::get('/journeys/{id}/assign', 'JourneyController@journey_assign')->name('journeys.assign');
	Route::get('/journeys/{id}/rating', 'JourneyController@journey_rating')->name('journeys.rating');
	Route::get('/journeys/add_to/{id}', 'JourneyController@add_to_my_learning_journey')->name('journeys.add_to');
	Route::get('/journeys/assigned/{id}/show/{type?}', 'JourneyController@assigned_journey_show')->name('journeys.assigned_journey_show');
	Route::get('/journeys/assigned/{id}/edit/{type?}', 'JourneyController@assigned_journey_edit')->name('journeys.assigned_journey_edit');
	Route::get('/journeys/{id}/show', 'JourneyController@my_journey_show')->name('journeys.my_journey');
	Route::post('/journeys/duplicate', 'JourneyController@duplicate')->name('journeys.duplicate');
	Route::post('/journeys/add_to', 'JourneyController@store_add_to_my_learning_journey')->name('journeys.store_add_to');	
	Route::post('/journeys/{id}/revoke', 'JourneyController@revoke_journey')->name('journeys.revoke_journey');
	Route::post('/journeys/{id}/ignore', 'JourneyController@ignore_journey')->name('journeys.ignore_journey');
	Route::post('/journeys/{id}/unignore', 'JourneyController@unignore_journey')->name('journeys.unignore_journey');
	Route::post('/journeys/store_assign', 'JourneyController@store_journey_assign')->name('journeys.store_assign');
	Route::post('/journeys/store_rating', 'JourneyController@store_journey_rating')->name('journeys.store_rating');
	Route::post('/journeys/assigned/{id}/delete/', 'JourneyController@delete_assigned_journey')->name('journeys.delete_assigned_journey');
	Route::get('/journeys/p/create', 'JourneyController@predefine_journey_create')->name('journeys.predefine_create');
	Route::get('/journeys/create/{id?}', 'JourneyController@create');
	Route::get('/journeys/break_down/{id}/{category}/{user_id?}', 'JourneyController@journey_break_down');
	Route::get('/journeys/{id}/total_assignee', 'JourneyController@get_total_assignee')->name('journeys.get_total_assignee');
	Route::get('/journeys/{id}/all_assignee', 'JourneyController@get_all_assignee')->name('journeys.get_all_assignee');
	Route::get('/journeys/possport_journey_list', 'JourneyController@possport_journey_list')->name('journeys.possport_journey_list');

	//Backfill milestone journey
	Route::get('/passport/{id}/milestone_count', 'JourneyController@passport_milestone_count')->name('journeys.passport_milestone_count');
	Route::get('/backfill_milestone', 'JourneyController@backfill_milestone')->name('journeys.backfill_milesotne');
	Route::get('/passport/journey/{id}/{user_id?}', 'JourneyController@passport_journey_view')->name('journeys.journey_view');
	Route::post('/store_backfill', 'JourneyController@backfill_store_milestone')->name('store_backfill_milestone');
	Route::post('/update_backfill/{id}', 'JourneyController@backfill_update_milestone')->name('update_backfill_milestone');
	Route::get('/backfill_milestone_list', 'JourneyController@backfill_milestone_list')->name('backfill_milestone_list');
	Route::get('/get_backfill_milestone/{id?}', 'JourneyController@get_backfill_milestone')->name('get_backfill_milestone');

	Route::get('/passport', 'JourneyController@passport')->name('passport');
	Route::get('/certificate_download/{id}/{type}', 'JourneyController@certificate_download')->name('journeys.certificate_download');
	Route::get('/journeys/{journey_list}/filter', 'JourneyController@journey_list_filter');
	Route::resource('journeys', 'JourneyController');
	
	//Milestone 
	Route::get('/milestone/{id?}', 'JourneyController@get_milestone')->name('journeys.get_milestone');
	Route::get('/milestone_detail/{id}/{user_id?}', 'JourneyController@get_milestone_detail')->name('journeys.get_milestone_detail');
	Route::get('/milestone/{id}/notes', 'JourneyController@get_milestone_note')->name('journeys.get_milestone_note');
	Route::post('/milestone/{id}/notes', 'JourneyController@update_milestone_note')->name('journeys.update_milestone_note');
	Route::get('/milestone_list', 'JourneyController@milestone_list')->name('milestone_list');
	Route::get('/backfill_miestone_list', 'JourneyController@backfill_miestone_list')->name('backfill_miestone_list');
	Route::post('/store_milestone', 'JourneyController@store_milestone')->name('store_milestone');
	Route::post('/update_milestone/{id}', 'JourneyController@update_milestone')->name('update_milestone');
	Route::post('/milestone/complete', 'JourneyController@complete_milestone')->name('journeys.complete_milestone');
	Route::post('/milestone/{id}/revoke', 'JourneyController@revoke_milestone')->name('journeys.revoke_milestone');
	Route::post('/milestone/{id}/ignore', 'JourneyController@ignore_milestone')->name('journeys.ignore_milestone');		
	Route::post('/milestone/{id}/unignore', 'JourneyController@unignore_milestone')->name('journeys.unignore_milestone');		
	Route::delete('/delete_milestone/{id}', 'JourneyController@destroy_milestone')->name('delete_milestone');
	
	//Peer and Colleagues management
	Route::get('/peers/peer_list', 'PeerController@ajax_list')->name('peers.peer_list');
	Route::get('/peers/journey/{id}', 'PeerController@journey_view')->name('peers.journey_view');
	Route::get('/peers/passport/{id}', 'PeerController@passport')->name('users.passport');
	Route::resource('/peers', 'PeerController');
	
	
	//Library management
	Route::get('/library_list', 'LibraryController@ajax_list')->name('library_list');
	Route::get('/library_block_list', 'LibraryController@render_ajax_block_list')->name('library_block_list');
	Route::get('/libraries/{id}/assign', 'LibraryController@content_assign')->name('libraries.assign');
	Route::post('/libraries/store_assign', 'LibraryController@store_content_assign')->name('libraries.store_assign');
	Route::post('/libraries/get_journey', 'LibraryController@get_journey')->name('libraries.get_journey');	
	Route::get('/libraries/add_to/{id}', 'LibraryController@add_to_my_journey_milestone')->name('libraries.add_to');
	Route::post('/libraries/add_to', 'LibraryController@store_add_to_my_journey_milestone')->name('libraries.store_add_to');
	Route::get('/libraries/get_meta_tags', 'LibraryController@get_url_meta_tags')->name('libraries.get_meta_tags');
	
	Route::resource('libraries', 'LibraryController');
	
	
	//Approval management
	Route::get('/approvals/milestone/{id}', 'ApprovalController@get_requested_milestone')->name('journeys.get_milestone');
	Route::get('/approvals/approval_list', 'ApprovalController@ajax_list')->name('approvals.approval_list');
	Route::post('/approvals/status/{id}', 'ApprovalController@status')->name('approvals.status');
	Route::resource('/approvals', 'ApprovalController');
	
	//Temp check management
	Route::get('/tempchecks/{id}/assign', 'TempcheckController@assign')->name('tempchecks.assign');
	Route::post('/tempchecks/store_assign', 'TempcheckController@store_assign')->name('tempchecks.store_assign');
	Route::get('/tempchecks/trend/list', 'TempcheckController@trend_index')->name('tempchecks.trend_index');
	Route::get('/tempchecks/assigned/list', 'TempcheckController@assigned_index')->name('tempchecks.assigned_index');
	Route::get('/tempchecks/trend_list', 'TempcheckController@trend_list')->name('tempchecks.trend_list');
	Route::get('/tempchecks/{id}/trend/{user_id}', 'TempcheckController@trend')->name('tempchecks.trend');
	Route::get('/tempchecks/{id}/trend_graph/{user_id}', 'TempcheckController@trend_graph')->name('tempchecks.trend_graph');
	Route::get('/tempchecks/{id}/rating', 'TempcheckController@rating')->name('tempchecks.rating');
	Route::post('/tempchecks/store_rating', 'TempcheckController@store_rating')->name('tempchecks.store_rating');
	Route::get('/tempchecks/assigned_list', 'TempcheckController@assigned_list')->name('tempchecks.assigned_list');
	Route::get('/tempchecks/tempcheck_list', 'TempcheckController@ajax_list')->name('tempchecks.tempcheck_list');	
	Route::resource('tempchecks', 'TempcheckController');

	Route::get('/reports/approval_list', 'ReportController@approval_report_list')->name('reports.approval_list');	
	Route::get('/reports/current_user_report', 'ReportController@current_user_report')->name('reports.current_user_report');	
	Route::get('/reports/group_report_list', 'ReportController@group_report_list')->name('reports.group_report_list');	
	Route::get('/reports/user_activity_report', 'ReportController@user_activity_report')->name('reports.user_activity_report');	
	Route::get('/reports/tempcheck_report_list', 'ReportController@tempcheck_report_list')->name('reports.tempcheck_report_list');	
	Route::resource('reports', 'ReportController');
});

