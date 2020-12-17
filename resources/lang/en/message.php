<?php 

return [
	"something_went_wrong"			=>	"Something Went Wrong!",
	"unauthorized_access"			=>	"Unauthorized Access!",
	
	//Pages Module
	'enquiry_save_success' 			=> '{enquiry} Form Submitted Successfully',
    'enquiry_save_failed'  			=> '{enquiry} Form Submit Failed',
	
	//Auth module
	"login_success"					=>  "Hello {username}, You have Successfully signed in",
	"logout_success"				=>  "Sign out Successful",
	"login_failed"					=>  "Please try again!",
	"account_inactive"				=>  "Account Inactive",
	"password_reset_request_success"=>  "The reset password link has been sent to your register email ID",
	"password_reset_success"		=>	"Password Reset Successfully",
	"password_set_success"			=>	"Password Set Successfully",
		
	'mail_not_send'					=> 'Mail not sent',
	
	'user_not_send' 				=> 'User not found',
	'user_create_success' 			=> '{username} Added Successfully',
    'user_create_failed'  			=> '{username} Add Failed',
	'user_update_success' 			=> '{username} Updated Successfully',
    'user_update_failed'  			=> '{username} Update Failed',
	'user_delete_success' 			=> '{username} Deleted Successfully',
    'user_delete_failed'  			=> '{username} Delete Failed',
	'user_bulk_upload_success' 		=> 'User Bulk Upload Successfully',
	'user_bulk_upload_partially_success' => 'There seems to be a trouble while importing few users',
    'user_bulk_upload_failed'  		=> 'User bulk upload failed',
    'current_user_delete'  			=> 'Deletion of currently logged in user is not allowed :(',
    'user_activate_success'  		=> '{username} Activated Successfully',
    'user_inactivate_success'  		=> '{username} Inactivated Successfully',
    'user_require_organization_chart' => 'Must Create Organization Chart',
	'user_email_exist' 				=> 'User Email ID Already Exist',	
	'user_new_email_verified' 		=> '{username} Verified Successfully',
	
	'profile_update_success' 		=> 'Profile Updated Successfully',
	'profile_update_failed' 		=> 'Profile Update Failed',

	'password_change_success' 		=> 'Password Updated Successfully',
	'password_change_failed' 		=> 'Password Update Failed',
	
	'page_create_success' 			=> '{page} Added Successfully',
    'page_create_failed'  			=> '{page} Add Failed',
	'page_update_success' 			=> '{page} Updated Successfully',
    'page_update_failed'  			=> '{page} Update Failed',
	'page_activate_success'  		=> '{page} Activated Successfully',
    'page_inactivate_success'  		=> '{page} Inactivated Successfully',
	'page_delete_success' 			=> '{page} Deleted Successfully',
    'page_delete_failed'  			=> '{page} Delete Failed',
	
	'slider_create_success' 			=> '{slider} Added Successfully',
    'slider_create_failed'  			=> '{slider} Add Failed',
	'slider_update_success' 			=> '{slider} Updated Successfully',
    'slider_update_failed'  			=> '{slider} Update Failed',
	'slider_activate_success'  			=> '{slider} Activated Successfully',
    'slider_inactivate_success'  		=> '{slider} Inactivated Successfully',
	'slider_delete_success' 			=> '{slider} Deleted Successfully',
    'slider_delete_failed'  			=> '{slider} Delete Failed',
	
	'group_admin_user_inactive' 	=> '{username} has dependencies', //'Group Admin Not Allowed to Inactivate',	
	'approval_pending_user_inactive'=> '{username} has dependencies', //'{username} Has Pending Approval,So Not Allowed to Inactivate',
	'group_admin_user_delete' 		=> '{username} has dependencies', //'Group Admin Not Allowed to Delete',	
	'approval_pending_user_delete' 	=> '{username} has dependencies', //'{username} Has Pending Approval,So Not Allowed to Delete',
	
	'organization_update_success' 	=> 'Organizational Chart Updated Successfully',
    'organization_update_failed'  	=> 'Organizational Chart Update Failed',
	
	'role_create_success' 		=> '{role} Role Added Successfully',
    'role_create_failed'  		=> '{role} Role Add Failed',
	'role_update_success' 		=> '{role} Role Updated Successfully',
    'role_update_failed'  		=> '{role} Role Update Failed',
	'role_delete_success' 		=> '{role} Role Deleted Successfully',
    'role_delete_failed'  		=> '{role} Role Delete Failed',
    'role_not_found'  			=> 'Role not found',
    'role_not_exist'  			=> 'Role Name not Exist',
	'role_unable_to_delete'		=> '{role} Role Assigned to User, So Unable to Delete',
	'role_unable_to_inactive'	=> '{role} Role Assigned to User, So Unable to Inactive',
	'role_has_active_users'		=> '{role} Role has active employees', 
];