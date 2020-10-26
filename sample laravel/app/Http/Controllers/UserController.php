<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

use App\Authorizable;
use ZipArchive;

use App\Http\Requests\StoreUserPost;
use App\Http\Requests\UpdateUserPut;
use App\Http\Requests\StoreUserBulkUploadPost;

use App\Mail\UserInviteEmail;
use App\Mail\UserActivateMail;
use App\Mail\UserInactivateMail;
use App\Mail\UserDeleteEmail;
use App\Mail\UserEmailIdChangeVerificationEmail;
use App\Mail\UserEmailIdChangeNotifyEmail;

use App\Notifications\WelcomeNotification;

use App\Model\User;
use App\Model\Permission;
use App\Model\Role;
use App\Model\OrganizationChart;
use App\Model\ChartSidebar;
use App\Model\UserGrade;

use App\Notifications\UserRoleChange;

class UserController extends BaseController
{
	use Authorizable;
	
	Public function __construct(){
		parent::__construct();
	}
	
	public function NotifMarkAsRead(Request $request)
	{
		$notification = auth()->user()->notifications()->find($request->notif_id);
		if($notification) {
			$notification->markAsRead();
			$this->response['status']   = true;
		}else{
			$this->response['status']   = false;
		}		
		return $this->response();
	}
	
	
	public function ajax_list(Request $request)
    {
		$data = $whereArray = array();
				
		$users = DB::table('users');
		$users->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id');
		$users->join('roles', 'roles.id', '=', 'model_has_roles.role_id','left');				
		$users->select('users.id as id','users.first_name','users.last_name','users.email','users.mobile','roles.name as role','users.status');		
		$users->whereNull('users.deleted_at');
		$users->whereNotIn('users.id',[1,$this->user->id]);
		
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){
				$users->where($where['field'],$where['condition'],$where['value']);
			} 
		}
		
		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$users->where(function($query) use ($search_for){
				$query->where('users.first_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.last_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.email', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.mobile', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.status', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('roles.name', 'LIKE', '%'.$search_for.'%');
			});			
		}
		$users->orderBy('users.id', 'DESC');
		//$users->groupBy('users.id');
		$userData = $users->get();
		
		
		
		foreach($userData as $key => $row){
		   $action = "";
		   $full_name = $row->first_name." ".$row->last_name;
		   
		   $action .='<a title="View" href="'.route('users.show',[encode_url($row->id)]).'" class="btn btn-blue '.$row->status.'">View</a>';
			
			if($this->user->hasPermissionTo('edit_users')){
				$action .='<a title="Edit" href="'.route('users.edit',[encode_url($row->id)]).'" class="btn btn-lightblue">Edit</a>';
			}

			if($this->user->hasPermissionTo('delete_users')){
				$action .='<button type="button" title="Delete"  onclick="deleteUser('."'".encode_url($row->id)."'".','."'".$row->status."'".','."'".$full_name."'".')" class="btn btn-red">Delete</button>';
			}			   
		   
           $data[$key]['id']        = ''; 
		   $data[$key]['full_name'] = $full_name;
		   $data[$key]['email']		= $row->email; 
		   $data[$key]['mobile']	= $row->mobile; 
           $data[$key]['role'] 		= $row->role; 
           $data[$key]['status']    = ucfirst($row->status); 
		   $data[$key]['action']    = $action; 
	   }
	   
	   return datatables()->of($data)->make(true);
		
		//$action ="";
		
		// $users = User::with(array('roles'=>function($query){
			// $query->select('name');
		// }))->whereNull('deleted_at')->whereNotIn('id',[1,user_id()]);
		
		//User::whereNull('deleted_at')->get()->except([1,$this->user->id]) 
		
		// $users = DB::table('users as u')
				// ->join('model_has_roles as mhs', 'mhs.model_id', '=', 'u.id','left')
				// ->join('roles as r', 'r.id', '=', 'mhs.role_id','left')
				// ->select('u.id as id',DB::raw('CONCAT(first_name," ",last_name) as full_name'),'u.email','u.mobile','r.name as role','u.status')
				// ->whereNull('u.deleted_at')
				// ->whereNotIn('u.id',[1,$this->user->id]);				
	
        // return datatables()->of(User::whereNull('deleted_at')->get()->except([1,$this->user->id]))->addColumn('action', function($row) use($action) {
			
			// $action .='<a title="View" href="'.route('users.show',[encode_url($row->id)]).'" class="btn btn-blue '.$row->status.'">View</a>';
			
			// if($this->user->hasPermissionTo('edit_users')){
				// $action .='<a title="Edit" href="'.route('users.edit',[encode_url($row->id)]).'" class="btn btn-lightblue">Edit</a>';
			// }

			// if($this->user->hasPermissionTo('delete_users')){
				// $action .='<a title="Delete" href="void:" onclick="deleteUser('."'".encode_url($row->id)."'".','."'".$row->status."'".','."'".$row->full_name."'".')" class="btn btn-red">Delete</a>';
			// }
			
			// return $action;
        // })->addColumn('role', function($row){
			// return $row->role; //$row->roles()->first()->name;
		// })->addColumn('status', function($row){
			// return ucfirst($row->status);
		// })->addColumn('full_name', function($row){
			// return $row->full_name;
		// })->make(true);
    }
	
	//Function to list out app users
	//Input : NA
	//Output : render user list view
	public function index()
	{
		if (OrganizationChart::all()->count() <= 0) {
            return redirect()->route('organization-chart.index')->with('error_message', __('message.user_require_organization_chart'));
		}
						
		return view('user_management.list');
	}

	//Function to render user add view
	//Input : NA
	//Output : render view
	public function create()
	{
		$roles = Role::whereStatus('active')->pluck('name', 'id');
		$org_data = ChartSidebar::all('id','set_id','set_name');
		return view('user_management.add', compact('roles','org_data'));
	}

	//Function to create/store the app user
	//Input : Request/Post data
	//Output : status message
	public function store(StoreUserPost $request)
	{
		$user = new User();
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->email    	= $request->email;
        $user->password 	= Hash::make(str_random(35));
        $user->mobile   	= $request->mobile;
		//$user->status   	= $request->status;
        $user->designation  = $request->designation;
        $user->team  		= $request->team;
        $user->department  	= $request->department;
        
        if ($request->hasFile('image')) {
            $user->image = $this->profileUpload($request);
        }
              
        if($user->save()){
			
			$this->set_user_grade($request->gradeId, $user->id);
			
			$this->syncPermissions($request, $user);
			
			$this->response['status']   = true;
			$this->response['message']  = str_replace("{username}",$request->first_name." ".$request->last_name,__('message.user_create_success'));
			$this->response['redirect'] = route('users.index');
			
			try{
				//User Invite mail notification
				Mail::to($user)->send(new UserInviteEmail($user));
				//$user->notify(new WelcomeNotification($user));
			}
			catch(\Exception $e){ // Using a generic exception
				$this->response['message']  = __('message.mail_not_send');
			}
		}else{
			$this->response['status']   = false;
			$this->response['message']  = str_replace("{username}",$request->first_name." ".$request->last_name,__('message.user_create_failed'));
		}

        return $this->response();
	}
	
	//Function to assign the grade to app user
	private function set_user_grade($gradeId, $user_id){

		UserGrade::where('user_id',$user_id)->delete();
		$count_id = 0;
		foreach($gradeId as $key => $row)
		{
		   $emp_grade_data[$count_id]['user_id'] = $user_id;
		   $emp_grade_data[$count_id]['chart_name_id'] = $key;
		   $emp_grade_data[$count_id]['chart_value_id'] = $row;
		   $count_id++;
		}		   
	    UserGrade::insert($emp_grade_data);
		return;
	}
	
	//Function to render the app user view page
	//Input : User id
	//Output : render view page
	public function show($id)
    {
        $user = User::findOrFail(decode_url($id));
		$org_data = ChartSidebar::all('id','set_id','set_name');
		$user_grade =  UserGrade::where(['user_id' => decode_url($id)])->select('chart_name_id','chart_value_id')->get();
        return view('user_management.show', compact('user','org_data','user_grade'));
    }

	//Function to render the app user edit page
	//Input : User id
	//Output : render edit page
	public function edit($id)
	{
		$user = User::findOrFail(decode_url($id));
        $roles = Role::whereStatus('active')->pluck('name', 'id');
        $permissions = Permission::all('name', 'id');
		$user_grade =  UserGrade::where(['user_id' => decode_url($id)])->select('chart_name_id','chart_value_id')->get();
		$org_data = ChartSidebar::all('id','set_id','set_name');
		
        return view('user_management.edit', compact('user','roles','permissions','org_data','user_grade'));
	}

	//Function to update the app user
	//Input : Request/Post data
	//Output : status message
	public function update(UpdateUserPut $request, User $user)
	{
		//$user = User::findOrFail($user->id);
		
		$currentRole 		= $user->roles()->pluck('id');
		$existing_status 	= $user->status;
		
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;        
        $user->mobile   	= $request->mobile;
		$user->status   	= $request->status;
		$user->designation  = $request->designation;
        $user->team  		= $request->team;
        $user->department  	= $request->department;
       
        if ($request->hasFile('image')) {
            $user->image = $this->profileUpload($request);
        }
		
		$update = true;
		if($existing_status != $request->status && $request->status == 'inactive'){
			if($user->is_group_admin()){
				$update = false;
				$this->response['status']   = false;
				$this->response['message']  = lang_message('group_admin_user_inactive','username',$user->full_name);
			}elseif($user->has_pending_approval()){
				$update = false;
				$this->response['status']   = false;
				$this->response['message']  = lang_message('approval_pending_user_inactive','username',$user->full_name);
			}
		}
		if($update){
			if($user->save()){
				$this->set_user_grade($request->gradeId, $user->id);
				
				// if(empty($currentRole) || $currentRole[0] != $request->roles[0] ){
					// //User role change notification
					// $user->notify(new UserRoleChange($user));
				// }
				
				if($user->email  != $request->email && $user->id != user_id()){
					
					$user->change_email = $request->email;
					$user->change_email_token = app('auth.password.broker')->createToken($user);
					$user->changed_at = get_db_date_time();
					$user->save();
					
					//User Email Change Notify mail notification
					Mail::to($user->email)->send(new UserEmailIdChangeNotifyEmail($user));
					
					//User Email Change Verify mail notification
					Mail::to($user->change_email)->send(new UserEmailIdChangeVerificationEmail($user));
				}
				
				//Profile update noftification
				if($user->id != user_id())
				$user->notify(new \App\Notifications\ProfileUpdateNotification($user));
				
				if($existing_status != $request->status){
					if($request->status == 'active'){
						//User Activate mail notification
						Mail::to($user)->send(new UserActivateMail($user));
					}else{
						//User Inactivate mail notification
						Mail::to($user)->send(new UserInactivateMail($user));
					}				
				}
			
				// Handle the user roles
				$this->syncPermissions($request, $user);

				$this->response['status']   = true;
				$this->response['message']  = str_replace("{username}",$request->first_name." ".$request->last_name,__('message.user_update_success'));
				$this->response['redirect'] = route('users.index');
			}else{
				$this->response['status']   = false;
				$this->response['message']  = str_replace("{username}",$request->first_name." ".$request->last_name,__('message.user_update_failed'));
			}
		}
        return $this->response();
	}

	//Function to delete the app user
	//Input : User Id
	//Output : status message
	public function destroy($id)
	{
		
		$user = User::findOrFail(decode_url($id));
		if(auth()->user()->id == $user->id ) {
			$this->response['status']   = false;
            $this->response['message']  = lang_message('current_user_delete');
            $this->response['redirect'] = back();
		}elseif($user->is_group_admin()){
			$this->response['status']   = false;
			$this->response['message']  = lang_message('group_admin_user_delete','username',$user->full_name);
		}elseif($user->has_pending_approval()){
			$this->response['status']   = false;
			$this->response['message']  = lang_message('approval_pending_user_delete','username',$user->full_name);
		}else{
			if(User::find($user->id)->delete() ) { 
				try{
					
					//User delete mail notification
					Mail::to($user)->send(new UserDeleteEmail($user));
					
					//Delete set/reset password Token
					\App\Model\PasswordReset::whereEmail($user->email)->delete();
					
					//Update the email with prefix deleted
					$deleted_user = User::find($user->id);				
					$deleted_user->email = 'deleted_'.$deleted_user->email;
					$deleted_user->save();
				}
				catch(\Illuminate\Database\QueryException $e){
					//Update the email with prefix random
					$deleted_user = User::find($user->id);				
					$deleted_user->email = rand(10000,99999).'_'.$deleted_user->email;
					$deleted_user->save();
					$e->getMessage();
				}	
				$this->response['status']   = true;
				$this->response['message']  = str_replace("{username}",$user->first_name." ".$user->last_name,__('message.user_delete_success'));
				$this->response['redirect'] = route('users.index');
			} else {
				$this->response['status']   = false;
				$this->response['message']  = str_replace("{username}",$user->first_name." ".$user->last_name,__('message.user_delete_failed'));
			}
		}
		return $this->response();
	}

	//Function to manage/update roles and permissions
	//Input : roles and Permissions
	//Output : return user details
	private function syncPermissions(Request $request, $user)
	{
		// Get the submitted roles
		$roles = $request->get('roles', []);
		$permissions = $request->get('permissions', []);

		// Get the roles
		$roles = Role::find($roles);

		// check for current role changes
		if( ! $user->hasAllRoles( $roles ) ) {
			// reset all direct permissions for user
			$user->permissions()->sync([]);
		} else {
			// handle permissions
			$user->syncPermissions($permissions);
		}

		$user->syncRoles($roles);
		return $user;
	}
	
	//Function to store the user profile image 
	private function profileUpload($request){
        
           $request->image->store('public/user-uploads/avatar');

           $file_name = $request->image->hashName();
    
            // resize the image to a width of 300 and constrain aspect ratio (auto height)
            // $img = Image::make('user-uploads/avatar/'.$file_name);
            // $img->resize(300, null, function ($constraint) {
            //     $constraint->aspectRatio();
            // });
            // $img->save();

            return $file_name;
    }
	
	//Function to create user by bulk import 
	//Input : CSV/Zip file
	//Output: NA
	public function bulk_upload(StoreUserBulkUploadPost $request){
		$prefix = "";
		$importData_arr = array();		
		if($request->hasFile('bulkimphrcsv')) {
		
			$csv = $request->file('bulkimphrcsv');
			
			$filename 	= $csv->getClientOriginalName();
			
			// File upload location
			$location = 'csv_uploads';
			  
			// Upload file
			$csv->move($location,$filename);

			// Import CSV to Database
			$filepath = public_path($location."/".$filename);

			// Reading file
			$file = fopen($filepath,"r");
			 
			  $i = 0;
			  while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
				 $num = count($filedata);
				 
				 // Skip first row (Remove below comment if you want to skip the first row)
				 if($i == 0){
					$i++;
					continue; 
				 }
				 for ($c=0; $c < $num; $c++) {
					$importData_arr[$i][] = $filedata[$c];
				 }
				 $i++;
			  }
			  fclose($file);
		}

		if($request->hasFile('bulkimphrzip')) {

			$zip = $request->file('bulkimphrzip');
			$zip_filename 	= $zip->getClientOriginalName();

			// File upload location
			$location_zip = 'zip_uploads/';
				  
			// Upload zip file
			$zip->move($location_zip,$zip_filename);
			$prefix = md5(rand());			
   		    $allowed_ext = array('jpeg','jpg', 'png');
			
			$path = ['source_path'=> $location_zip, 'destination_path'=>'storage/user-uploads/avatar/'];
			$this->zip_validate_and_store($path, $zip_filename, $prefix, $allowed_ext);
			 
			 // $filezippath = public_path($location_zip.$zip_filename);
			  // $zip = new \ZipArchive();
			  // $x = $zip->open($filezippath);
			  // if ($x === true) {
				// $zip->extractTo('storage/user-uploads/avatar'); 
				// $zip->close();
				// unlink($filezippath);
			  // }
		}
		
		if(!empty($importData_arr)){
			 $user_count = $succes_count =  $fail_count = 0;
			 
			 foreach($importData_arr as $importData){
				 try 
				 {
					// Check if role exist or not
					$role = Role::whereName(trim($importData['4']))->get();
					
					if($role->count() > 0){
						$user = new User();				
						$user->first_name   = trim($importData['0']);
						$user->last_name    = trim($importData['1']);
						$user->password 	= Hash::make(str_random(35));
						$user->email    	= trim($importData['2']);
						$user->mobile   	= trim($importData['3']);
						$user->designation	= trim($importData['6']);
						$user->department	= trim($importData['7']);
						$user->team   		= trim($importData['8']);
						$user->image   		= (trim($importData['9']) != "") ? $prefix.'_'.trim($importData['9']) : "";
					
						if($user->save()){
							$succes_count++;
							//Assign a role to user 
							$user->syncRoles($role->first());

							// Get and assign grade
							$grade = OrganizationChart::where('node_name',trim($importData['5']))->get();
							if($grade->count() > 0){
								$chart[$grade->first()->set_id] = $grade->first()->id;
								$this->set_user_grade($chart, $user->id);
							}
										
							//User Invite mail notification
							Mail::to($user)->send(new UserInviteEmail($user));
						}
					}else{						
						$this->response['failed_items'][$fail_count]['email'] = $importData['2'];
						$this->response['failed_items'][$fail_count]['error'] = __('message.role_not_exist');
						$fail_count++;
					}
				  }
				  catch(\Illuminate\Database\QueryException $e){
						$this->response['failed_items'][$fail_count]['email'] = $importData['2'];
						$this->response['failed_items'][$fail_count]['error'] = __('message.user_email_exist');
						$fail_count++;
						$e->getMessage();
				  }			  
			  }
			if($fail_count == 0){
				$this->response['status']   = true;
				$this->response['bulk_upload']   = true;
				$this->response['message']  = __('message.user_bulk_upload_success'); 
			}elseif($succes_count == 0){
				$this->response['status']   = false;
				$this->response['bulk_upload_error']   = true;
				$this->response['message']  = __('message.user_bulk_upload_failed');
			}else{
				$this->response['status']   = false;
				$this->response['bulk_upload_error']   = true;
				$this->response['message']  = __('message.user_bulk_upload_partially_success'); 
			}
		}else{
			$this->response['status']   = false;
			$this->response['message']  = __('message.user_bulk_upload_failed');
		}
        return $this->response();
    }
	
	private function zip_validate_and_store($path, $zip_filename, $prefix = "",$allowed_ext = array()){
   
		$array = explode(".", $zip_filename);  
        $name = $array[0]; 
		$location = $path['source_path'] . $zip_filename; 
		$zip = new ZipArchive; 
		if($zip->open($location))  
		{  
			$zip->extractTo($path['source_path'].$name);  
			$zip->close();  
		}
		 $files = scandir($path['source_path'] . $name);
		
		 //$name is extract folder from zip file  
		 foreach($files as $file)  
		 { 		 
			$arr = explode(".", $file);					
			if(count(array_filter($arr)) > 0){
				$file_ext = $arr[1];				  
				if(in_array($file_ext, $allowed_ext))  
				{  
					$new_name = $prefix.'_'.$arr[0].'.'. $file_ext;  
					copy($path['source_path'].$name.'/'.$file, $path['destination_path'] . $new_name);				
					unlink($path['source_path'].$name.'/'.$file);  
				} 
			}
		 }  
		 unlink($location);  
		 rmdir($path['source_path'].$name);  
	}
	 
	//Function to Activate and Inativate the App User 
	//Input : User ID and status
	//Output: NA
	public function status(Request $request, $id){
		
		$user = User::findOrFail(decode_url($id));
		
		$update = true;
		if($user->status != $request->status && $request->status == 'inactive'){
			if($user->is_group_admin()){
				$update = false;
				$this->response['status']   = false;
				$this->response['message']  = lang_message('group_admin_user_inactive','username',$user->full_name);
			}elseif($user->has_pending_approval()){
				$update = false;
				$this->response['status']   = false;
				$this->response['message']  = lang_message('approval_pending_user_inactive','username',$user->full_name);
			}
		}
		
		if($update){
			if($user){
				$user->status = $request->status;
				if($user->save()){
					if($request->status == 'active'){
						//User Activate mail notification
						Mail::to($user)->send(new UserActivateMail($user));
						$this->response['message']  = str_replace("{username}",$user->first_name." ".$user->last_name,__('message.user_activate_success'));
					}else{
						//User Inactivate mail notification
						Mail::to($user)->send(new UserInactivateMail($user));
						$this->response['message']  = str_replace("{username}",$user->first_name." ".$user->last_name,__('message.user_inactivate_success'));
					}
					$this->response['status']   = true;
				}else{
					$this->response['status']   = false;
					$this->response['message']  = __('message.something_went_wrong');
				}
			}else{
				$this->response['status']   = false;
				$this->response['message']  = __('message.user_not_send');
			}
		}
		
		return $this->response();
	}
	
	//Function to view App User Profile
	//Input : NA
	//Output: render profile view
	public function profile_view(){
		
		$user = User::findOrFail(user_id());
        $roles = Role::pluck('name', 'id');
        $permissions = Permission::all('name', 'id');
		$user_grade =  UserGrade::where(['user_id' => user_id()])->select('chart_name_id','chart_value_id')->get();
		$org_data = ChartSidebar::all('id','set_id','set_name');
		
        return view('user_management.profile_view', compact('user','roles','permissions','org_data','user_grade'));
	}
	
	//Function to edit App User Profile
	//Input : NA
	//Output: render profile edit
	public function profile_edit(){
		
		$user = User::findOrFail(user_id());
        $roles = Role::pluck('name', 'id');
        $permissions = Permission::all('name', 'id');
		$user_grade =  UserGrade::where(['user_id' => user_id()])->select('chart_name_id','chart_value_id')->get();
		$org_data = ChartSidebar::all('id','set_id','set_name');
		
        return view('user_management.profile_edit', compact('user','roles','permissions','org_data','user_grade'));
	}
	
	//Function to edit App User Profile
	//Input : NA
	//Output: render profile edit
	public function change_password(\App\Http\Requests\StoreChangePasswordPost $request){
		$user = auth()->user();		
		if($user){
			$user->password = Hash::make($request->password);
			$user->save();
			$this->response['status'] = true;
			$this->response['action'] = 'change_password';
			$this->response['message'] = __('message.password_change_success');
		}else{
			$this->response['status'] = false;
			$this->response['message'] = __('message.something_went_wrong');
		}
		
		return $this->response();
	}
	
	
	//Function to profile_update the app user
	//Input : Request/Post data
	//Output : status message
	public function profile_update(\App\Http\Requests\StoreProfileEditPost $request)
	{
		$user = auth()->user();
		
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;        
        $user->mobile   	= $request->mobile;
		$user->designation  = $request->designation;
       
        if ($request->hasFile('image')) {
            $user->image = $this->profileUpload($request);
        }
		
		if($user->save()){
			$this->response['status']   = true;
			$this->response['message']  = lang_message('profile_update_success');
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('profile_update_failed');
		}
        return $this->response();
	}	
	
	//Function to return app Grade
	//Input : user_id / NA
	//Output: return grade list
	public function grade_list(Request $request){
		
		$org_data = ChartSidebar::all('id','set_id','set_name');		
		$grade_list = OrganizationChart::all('node_id','node_name','node_parent','set_id');
		
		if($org_data->count() > 0){
			
			$this->response['status']   = true;
			
			if($request->user_id){
				
				if($request->user_id == 'view' || $request->user_id == 'edit'){
					$user_id = user_id();
				}else{
					$user_id = decode_url($request->user_id);
				}
				
				$this->response['user_grade']= UserGrade::where('user_id', $user_id)->where('chart_value_id','!=',null)->select(['chart_name_id as set_id','chart_value_id as node_id'])->get();
			}			
			
			$this->response['data']   	= ['org_data'=>$org_data, 'grade_list' => $grade_list];
			$this->response['message']  = __('');
		}else{
			$this->response['status']   = false;
			$this->response['message']  = __('');
		}
		return $this->response();
		
	}
    
	public function check_user_status(){
		$this->response['status'] = true;
		if(\Auth::check()){
			$this->response['user_status'] = auth()->user()->status;
		}else{
			$this->response['user_status'] = "inactive";
		}
		return $this->response();
	}

}
