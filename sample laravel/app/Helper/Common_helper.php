<?php

if (! function_exists('pr')) {
    function pr($data, $exit = false)
    {
        echo "<pre>";
		print_r($data);
		echo "</pre>";
		
		if($exit){
			exit;
		}
    }
}

if(!function_exists('moduleJs')){

    function moduleJs($dir= "", $file = ""){
        if($dir != "" && $file != ""){
            echo includeJs($dir, $file);
        }else{
            list($controller, $method) = GetActionControllerAndMethodName();
          
            //Include contoller js 
            echo includeJs($controller, $controller);
    
            //Include method js 
            echo includeJs($controller, $method);
        }
    }
}

if(!function_exists('parseDateRange')){
    function parseDateRange($date, $db_format = true){
		$d = explode('-',$date);		
		if($db_format){
			return [get_db_date($d[0]).' 00:00:00',get_db_date($d[1]).' 23:59:59'];
		}  
		return [$d[0],$d[1]];	
    }
}

if(!function_exists('GetActionControllerAndMethodName')){
    function GetActionControllerAndMethodName(){
        $routeArray = request()->route()->getAction();
        $controllerAction = class_basename($routeArray['controller']);
        list($controller, $method) = explode('@', $controllerAction);
        $controller = strtolower(str_replace('Controller','',$controller));

        return [$controller,$method];
    }
}

if(!function_exists('GetActionMethodName')){
    function GetActionMethodName(){
        $routeArray = request()->route()->getAction();
        $controllerAction = class_basename($routeArray['controller']);
        list($controller, $method) = explode('@', $controllerAction);
        return $method;
    }
}

if(!function_exists('includeJs')){
    function includeJs($dir,$file){
        if (file_exists(public_path('js/'.$dir.'/'.$file.'.js'))){
            return "<script src=".asset('js/'.$dir.'/'.$file.'.js')."></script>";
        }
    }
}

// Appication response helper
if(!function_exists('res')){
    function res($data){

       if(isset($data['redirect'])){
             $data['action'] = 'redirect';
             $data['url']    = $data['redirect'];
       } 

       if(request()->ajax()){
           echo json_encode($data);
       }else{
           $status = ($data['status']) ? 'success' : 'error';
           return redirect(url($data['url']))->with($status, $data['message']);
       } 
    }
}

function encode_url($data){
	return Auth::user()->encode_url($data);  
}

function decode_url($data){
	return Auth::user()->decode_url($data);  
}

function user_id(){
	return (isset(Auth::user()->id)) ? Auth::user()->id : 0;  
}

function is_admin(){
	return (Auth::user()->hasRole('Admin')) ? true : false;  
}

function is_group_admin($group_id = "", $user_id = ""){
	$cond['user_id'] = ($user_id == "") ? user_id() : $user_id;
	if($group_id != ""){ $cond['group_id'] = $group_id; }
	$group = \App\Model\GroupUserList::where($cond)->where(['is_admin'=>1])->whereNull('deleted_at');
	return ($group->count() > 0) ? true : false;  
}

function is_group_member($group_id = "", $user_id = ""){
	$cond['user_id'] = ($user_id == "") ? user_id() : $user_id;
	if($group_id != ""){ $cond['group_id'] = $group_id; }
	$group = \App\Model\GroupUserList::where($cond)->whereNull('deleted_at');
	return ($group->count() > 0) ? true : false;  
}

function is_public_group($group_id, $user_id = ""){	
	$cond_user_id = ($user_id == "") ? user_id() : $user_id;
	
	$group = \App\Model\Group::join(DB::raw('(SELECT group_id, GROUP_CONCAT(DISTINCT user_id) as group_member_ids FROM group_user_lists WHERE deleted_at IS NULL GROUP BY group_id) as members'),'members.group_id','=','groups.id','left')->where('groups.id',$group_id)->whereRaw('(groups.visibility = "public" OR FIND_IN_SET('.$cond_user_id.',members.group_member_ids))');	
	return ($group->count() > 0) ? true : false; 
}

function group_name($group_id){
	$group = \App\Model\Group::findOrFail($group_id);
	if($group){
		return ucfirst($group->group_name);
	} 
	return "";
}

function date_differance($end_date, $start_date ="", $nagative = false){

	$diff = (strtotime($end_date) - strtotime($start_date));

	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	if($diff <= 0 && $nagative == false){
		return 0;
	}
	return ($years*365) + ($months*30) + $days; 
}

function get_date_time($datetime = ""){
	if($datetime == ""){
		return \Carbon\Carbon::now()->format('M d, Y, h:i A');
	}else{
		return \Carbon\Carbon::parse($datetime)->format('M d, Y, h:i A');
	}
}

function get_date($date = ""){
	if($date == ""){
		return \Carbon\Carbon::now()->format('M d, Y');
	}else{
		return \Carbon\Carbon::parse($date)->format('M d, Y');
	}
}

function get_db_date_time($datetime = ""){
	if($datetime == ""){
		return \Carbon\Carbon::now()->format('Y-m-d h:i:s');
	}else{
		return \Carbon\Carbon::parse($datetime)->format('Y-m-d h:i:s');
	}
}

function get_db_date($date = ""){
	if($date == ""){
		return \Carbon\Carbon::now()->format('Y-m-d');
	}else{
		return \Carbon\Carbon::parse($date)->format('Y-m-d');
	}
}

function back_url($url = ""){

	if($url == ""){
		return url('/');
	}
	
	if(url()->previous() == url()->current()){
		return $url;
	}else{
		
		$previous = url()->previous();		
		$current = url()->current();
		
		if(!str_contains($previous, url('/'))){
			return $url;
		}
		
		if(str_contains($previous, '/groups') && str_contains($previous, '/passport')){
			return $url;
		}
		
		if((str_contains(\Request::route()->getName(),'show') || str_contains($current, '/show')) && str_contains($previous, '/edit')){
			return $url;
		} 
		
		return url()->previous();
	}
}

//***********************************//
	//Assign journey to users
	function generate_duplicate_journeys($users, $request, $type){

		$key = array_keys($users);
		$journey_id = decode_url($request->journey_id);
		$journey = \App\Model\Journey::findOrFail($journey_id);
		
		$journey_details = [];		
		if($journey->journey_type_id == 1){
			
			$details[] = array(
					'journey_id'		=>	$journey_id,
					'payment_type'		=>	$request->payment_type,
					'journey_status'	=>	$journey->status,
					'journey_type_id'	=>	1,
					'milestone_id'		=>	$request->milestone_id,
					'notes'  	   		=>  $request->notes
					);
			$journey_details[$key[0]['ref_id']]['journey_id'] 		 = $journey_id;
			$journey_details[$key[0]['ref_id']]['journey_name'] 	 = $journey->journey_name;
			$journey_details[$key[0]['ref_id']]['milestone_details'] = $details;
			
		}else{
			$total_j_duplicate = array_unique(array_map(function($i){ return $i['ref_id']; }, $users));
			foreach($total_j_duplicate as $dup_k=>$dup_v){	
			
				//Duplicate the Journey
				$journey_copy 					= $journey->replicate();
				$journey_copy->parent_id 		= $journey_id;
				$journey_copy->journey_type_id 	= ($request->assignment_type == "add_to") ? 1 : 3;	
				$journey_copy->type 			= $type;
				$journey_copy->type_ref_id 		= $dup_v;
				$journey_copy->created_by 		= user_id();
				
				if($request->j_visibility){
					$journey_copy->visibility 	= $request->j_visibility;
				}
				
				if($request->j_read){
					$journey_copy->read 		= $request->j_read;
				}
				
				if($journey_copy->save()){
					$new_journey_id = $journey_copy->id;
					$new_journey_name = $journey_copy->journey_name;
					$new_journey_status = $journey_copy->status;
					$new_journey_type_id = $journey_copy->journey_type_id;
					$assignment_type = $request->get('assignment_type','my');
					$milestone_ref_ids = $milestone_payment_type = $milestone_titles = [];
					//Duplicate the Milestones
					if($journey->milestones){
						foreach($journey->milestones as $milestone){
							$milestone_copy 			= $milestone->replicate();
							$milestone_copy->parent_id 	= $milestone->id;
							$milestone_copy->journey_id = $journey_copy->id;
							$milestone_copy->start_date = get_db_date_time();
							$milestone_copy->end_date 	= get_db_date($request->target_date[$milestone->id]);
							$milestone_copy->read 		= $request->read[$milestone->id];
							$milestone_copy->visibility = $request->visibility[$milestone->id];
							$milestone_copy->type 		= $type;
							$milestone_copy->type_ref_id= $dup_v;
							$milestone_copy->created_by = user_id();
							$milestone_copy->price 		= (isset($request->price[$milestone->id])) ? $request->price[$milestone->id] : $milestone_copy->price;
							$milestone_copy->approver_id = (isset($request->approver_id[$milestone->id])) ? $request->approver_id[$milestone->id] : $milestone_copy->approver_id;
							
							if($milestone_copy->save()){
								$milestone_titles[$milestone->id] = $milestone_copy->title;
								$milestone_ref_ids[$milestone->id] = $milestone_copy->id;
								$milestone_payment_type[$milestone->id] = $milestone_copy->payment_type;
							}				
						}
					}
				}
				
				$details = array();			
				foreach($request->milestone_id as $key=>$val){
					$details[] = array(
						'journey_id'		=>	$new_journey_id,
						'milestone_id'		=>	$milestone_ref_ids[$val],
						'milestone_name'	=>	$milestone_titles[$val],
						'journey_status'	=>	$new_journey_status,
						'journey_type_id'	=>	$new_journey_type_id,
						'assignment_type'	=>	$assignment_type,
						'payment_type'		=>	$milestone_payment_type[$val],
						'notes'  	   		=>  $request->notes[$key]
						);
				}
				$journey_details[$dup_v]['journey_id']        = $new_journey_id;
				$journey_details[$dup_v]['journey_name'] 	  = $new_journey_name;
				$journey_details[$dup_v]['milestone_details'] = $details;
			}
		}
		return $journey_details;
	}
	
	//Assign journey to users
	function assign_journey($users, $journey_id, $journey_name){
		
		$data = $response = [];
		$type_ref_id = null;
		if(!empty($users)){
			
			foreach($users as $k=>$v){
				$exist = \App\Model\JourneyAssignment::where(['journey_id'=>$journey_id,'user_id'=>$v['user_id']])->get();
				if(count($exist) == 0){
					$data[] = array(
						'journey_id' 	=> $journey_id,
						'user_id'	 	=> $v['user_id'],
						'type'	 		=> 'user',
						'type_ref_id'	=> $v['ref_id'],
						'created_by' 	=> user_id(),
						'created_at'   	=> get_db_date_time()
						);
				}
			}
				
			if(\App\Model\JourneyAssignment::insert($data)) {  
				$response['status']   = true;
				$response['message']  = lang_message('journey_assigned_success','journey',$journey_name);
			} else {
				$response['status']   = false;
				$response['message']  = lang_message('journey_assigned_failed','journey',$journey_name);
			}
		}else{
			$response['status']   = false;
			$response['message']  = lang_message('journey_user_not_found');
		}
		return $response;
	}
	
	
	//Assign journey to users
	function library_assign_journey($users, $journey_id, $type){
		
		$data = $response = [];
		$type_ref_id = null;
		if(!empty($users)){			
			foreach($users as $k=>$v){
				$exist = \App\Model\JourneyAssignment::where(['journey_id'=>$journey_id,'user_id'=>$v['user_id'],'created_by'=>user_id(),'assignment_type'=>'library'])->get();
				if(count($exist) == 0){
					$data[] = array(
						'journey_id' 	=> $journey_id,
						'user_id'	 	=> $v['user_id'],
						'type'	 		=> $type,
						'type_ref_id'	=> $v['ref_id'],
						'assignment_type'=>	'library',
						'created_by' 	=> user_id(),
						'created_at'   	=> get_db_date_time()
						);
				}
			}
				
			if(\App\Model\JourneyAssignment::insert($data)) {  
				$response['status']   = true;
			} else {
				$response['status']   = false;
			}
		}else{
			$response['status']   = false;
			$response['message']  = lang_message('journey_user_not_found');
		}
		return $response;
	}
	
	//Assign journey to users
	function assign_journey_to_user($users, $request, $type){
			
		$journey_details = generate_duplicate_journeys($users, $request, $type);
		
		$data = $response = [];
		$type_ref_id = null;
		if(!empty($users)){
			$notification_details = array();
			foreach($users as $k=>$v){
				$journey_id = $journey_details[$v['ref_id']]['journey_id'];
				$journey_name = $journey_details[$v['ref_id']]['journey_name'];
				$user_id = $v['user_id'];
				$ref_id  = $v['ref_id'];
				$exist = \App\Model\JourneyAssignment::where(['journey_id'=>$journey_id,'user_id'=>$user_id])->get();
				if(count($exist) == 0){
					$data[] = array(
						'journey_id' 		=> $journey_id,
						'user_id'	 		=> $user_id,
						'type'	 			=> $type,
						'assignment_type'	=> $request->get('assignment_type','my'),				
						'type_ref_id'		=> $ref_id,
						'created_by' 		=> user_id(),
						'created_at'   		=> get_db_date_time()
						);
						
					if(!empty($journey_details[$ref_id]['milestone_details'])){
						foreach($journey_details[$ref_id]['milestone_details'] as $detail){
							assign_milestone_to_user($user_id, $ref_id, $detail, $type);
						}
					}
					$notification_details[$journey_id][] = $user_id;
				}
			}
				
			if(\App\Model\JourneyAssignment::insert($data)) {  
						
				pdj_assign_email_and_web_notificaiton($notification_details);
				
				$response['status']   = true;
				$response['message']  = lang_message('journey_assigned_success','journey',$journey_name);
			} else {
				$response['status']   = false;
				$response['message']  = lang_message('journey_assigned_failed','journey',$journey_name);
			}
		}else{
			$response['status']   = false;
			$response['message']  = lang_message('journey_user_not_found');
		}
		return $response;
	}
	
	function pdj_assign_email_and_web_notificaiton($notification_details){
		
		if(!empty($notification_details)){
			$noti_user_ids = array();
			foreach($notification_details as $j_id => $user_ids){
				//Send email Notification
				if(!empty($user_ids)){
					foreach($user_ids as $user_id){
						//Skip the current user email
						if($user_id != user_id()){											
							$journey = \Illuminate\Support\Facades\DB::table('journey_assignment_view')->where('journey_id',$j_id)->where('user_id',$user_id)->get()->first();
							if($journey){					
								$user = \App\Model\User::where('id',$user_id)->where('status','active')->get()->first();							
								\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\PDJAssignEmail($journey));
							}
							array_push($noti_user_ids,$user_id);
						}
					}
				}
				
				//Web notification
				$journey_web_noti = \Illuminate\Support\Facades\DB::table('journey_assignment_view')->where('journey_id',$j_id)->select(['journey_id','journey_name','assigned_name'])->get()->first();
				if($journey_web_noti){					
					$users = \App\Model\User::whereIn('id',$noti_user_ids)->where('status','active')->get();
					\Notification::send($users, new \App\Notifications\PDJAssignNotification ($journey_web_noti));
				}
			}
		}
	}
	
	
	function alj_email_and_web_notificaiton($journey_id, $action = ""){
		
		if($action == "revoked" || $action == "updated"){
			$user_ids = array();		
			$journey_col = \Illuminate\Support\Facades\DB::table('journey_assignment_view')
			->where('journey_id',$journey_id);
			if($action == "updated"){
				$journey_col->where('assigned_status','!=','revoked');
			}			
			$journey = $journey_col->select(['user_id','user_name','journey_id','journey_name','read','assigned_name','milestone_count'])->get();
			
			if(!empty($journey)){
				foreach($journey as $user_journey){
					//Skip the current user email
					if($user_journey->user_id != user_id()){						
						//Send email Notification
						if($action == 'revoked'){
							$user = \App\Model\User::where('id',$user_journey->user_id)->where('status','active')->get()->first();
							\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\ALJRevokeEmail($user_journey));
						}
						array_push($user_ids,$user_journey->user_id);
					}
				}
							
				//Web notification
				$journey_web_noti = $journey->first();
				if(!empty($user_ids) && $journey_web_noti){					
					$users = \App\Model\User::whereIn('id',$user_ids)->where('status','active')->get();
					if($action == 'revoked'){
						\Notification::send($users, new \App\Notifications\ALJRevokeNotification ($journey_web_noti));
					}elseif($action == 'updated'){
						\Notification::send($users, new \App\Notifications\ALJEditNotification ($journey_web_noti));
					}
				}
			}
		}
		
		if($action == 'deleted'){
			$user_ids = array();
			$journey = \Illuminate\Support\Facades\DB::table('journey_assignments as ja')
			->join('journeys as j','j.id','=','ja.journey_id','left')
			->join(\Illuminate\Support\Facades\DB::raw('(SELECT ma.user_id, COUNT(ma.user_id) as milestone_count FROM milestones as m LEFT JOIN  milestone_assignments as ma ON m.id = ma.milestone_id WHERE m.deleted_at IS NULL AND ma.status != "revoked" GROUP BY ma.user_id) as mc'),'mc.user_id','=','ja.user_id','left')
			->join('users as u','u.id','=','ja.user_id','left')
			->join('users as u1','u1.id','=','ja.created_by','left')
			->where('ja.journey_id',$journey_id)
			->select(['ja.user_id','ja.journey_id','j.journey_name','j.read',\Illuminate\Support\Facades\DB::raw('CONCAT(u.first_name," ",u.last_name) as user_name'),\Illuminate\Support\Facades\DB::raw('CONCAT(u1.first_name," ",u1.last_name) as assigned_name'),'mc.milestone_count'])->get();
			
			if(!empty($journey)){
				foreach($journey as $user_journey){
					//Skip the current user email
					if($user_journey->user_id != user_id()){						
						//Send email Notification
						$user = \App\Model\User::where('id',$user_journey->user_id)->where('status','active')->get()->first();
						\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\ALJDeleteEmail($user_journey));
						array_push($user_ids,$user_journey->user_id);
					}
				}
							
				//Web notification
				$journey_web_noti = $journey->first();
				if(!empty($user_ids) && $journey_web_noti){					
					$users = \App\Model\User::whereIn('id',$user_ids)->where('status','active')->get();
					\Notification::send($users, new \App\Notifications\ALJDeleteNotification ($journey_web_noti));
				}
			}
		}
		
		if($action == 'ignored' || $action == 'assigned' || $action == 'complete'){
			$journey = \Illuminate\Support\Facades\DB::table('journey_assignment_view')
			->where('journey_id',$journey_id)
			->select(['created_by','journey_id','journey_name','read','assigned_name','milestone_count','j_type','j_type_ref_id'])->get()->first();
			if($journey->created_by != user_id()){
				$user = \App\Model\User::findOrFail($journey->created_by);	
				$journey->user_name = $user->full_name;
				
				$journey_web_noti['journey_id'] 	= $journey->journey_id;				
				$journey_web_noti['journey_name'] 	= $journey->journey_name;	
				$journey_web_noti['type'] 			= $journey->j_type;	
				$journey_web_noti['type_ref_id'] 	= $journey->j_type_ref_id;	
				
				if($action == 'assigned'){
					\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\ALJUnIgnoreEmail($journey));
					
					\Notification::send($user, new \App\Notifications\ALJUnIgnoreNotification ($journey_web_noti));
				}
				
				if($action == 'ignored'){
					\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\ALJIgnoreEmail($journey));
					
					\Notification::send($user, new \App\Notifications\ALJIgnoreNotification ($journey_web_noti));
				}
				
				if($action == 'complete'){
					\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\ALJCompleteEmail($journey));
					
					\Notification::send($user, new \App\Notifications\ALJCompleteNotification ($journey_web_noti));
				}			
				
			}
		}
	}
	
	function alj_milestone_email_and_web_notificaiton($milestone_id, $action = ""){
		
		if($action == "revoked" || $action == "updated" || $action == "deleted"){
			$user_ids = array();
				
			$assignment_col = \App\Model\MilestoneAssignment::join('milestones as m', 'm.id', '=', 'milestone_assignments.milestone_id','left')
			->join('content_types as ct', 'ct.id', '=', 'm.content_type_id')
			->join('journeys as j', 'j.id', '=', 'm.journey_id')
			->where('milestone_assignments.milestone_id',$milestone_id);
			if($action != "deleted"){
				$assignment_col->whereNull('m.deleted_at');
			}
			if($action == "updated" || $action == "deleted"){
				$assignment_col->where('milestone_assignments.status','!=','revoked');
			}
			$assignments = $assignment_col->select(['milestone_assignments.user_id','m.id as milestone_id','m.title','m.read','m.payment_type','m.difficulty','m.visibility','ct.name as content_type','j.journey_name','m.journey_id'])
			->get();
			if(!empty($assignments)){
				foreach($assignments as $user_assignment){
					//Skip the current user email
					if($user_assignment->user_id != user_id()){						
						//Send email Notification
						if($action == 'revoked'){
							$user = \App\Model\User::where('id',$user_assignment->user_id)->where('status','active')->get()->first();
							$user_assignment->user_name = $user->full_name;
							\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\ALJMilestoneRevokeEmail($user_assignment));
						}
						
						if($action == 'deleted'){
							$user = \App\Model\User::where('id',$user_assignment->user_id)->where('status','active')->get()->first();
							$user_assignment->user_name = $user->full_name;
							\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\ALJMilestoneDeleteEmail($user_assignment));
						}
						array_push($user_ids,$user_assignment->user_id);
					}
				}
							
				//Web notification
				$assignment_web_noti = $assignments->first();
				if(!empty($user_ids) && $assignment_web_noti){					
					$users = \App\Model\User::whereIn('id',$user_ids)->where('status','active')->get();
					if($action == 'revoked'){
						\Notification::send($users, new \App\Notifications\ALJMilestoneRevokeNotification ($assignment_web_noti));
					}elseif($action == 'updated'){
						\Notification::send($users, new \App\Notifications\ALJMilestoneEditNotification ($assignment_web_noti));
					}elseif($action == 'deleted'){
						\Notification::send($users, new \App\Notifications\ALJMilestoneDeleteNotification ($assignment_web_noti));
					}
				}
			}
		}
		
		if($action == 'ignored' || $action == 'assigned' || $action == 'complete'){
			
			$milestone_collection = \App\Model\MilestoneAssignment::join('milestones as m', 'm.id', '=', 'milestone_assignments.milestone_id','left')
			->join('content_types as ct', 'ct.id', '=', 'm.content_type_id')
			->join('journeys as j', 'j.id', '=', 'm.journey_id')
			->whereNull('m.deleted_at')
			->where('milestone_assignments.milestone_id',$milestone_id);
			if($action == 'complete'){
				$milestone_collection->where('milestone_assignments.user_id',user_id());
			}
			$milestone = $milestone_collection->select(['milestone_assignments.user_id','m.id as milestone_id','m.type as m_type','m.type_ref_id as m_type_ref_id','m.title','m.read','m.payment_type','m.difficulty','m.visibility','ct.name as content_type','milestone_assignments.rating','milestone_assignments.point','j.journey_name','m.journey_id','m.created_by'])
			->get()->first();
			
			if($milestone->created_by != user_id()){
				$user = \App\Model\User::findOrFail($milestone->created_by);	
				
				$milestone_web_noti['journey_id'] 		= $milestone->journey_id;				
				$milestone_web_noti['journey_name'] 	= $milestone->journey_name;				
				$milestone_web_noti['milestone_id'] 	= $milestone->milestone_id;				
				$milestone_web_noti['milestone_name'] 	= $milestone->title;	
				$milestone_web_noti['type'] 			= $milestone->m_type;	
				$milestone_web_noti['type_ref_id'] 		= $milestone->m_type_ref_id;	
				$milestone_web_noti['point'] 			= $milestone->point;	
				$milestone_web_noti['rating'] 			= $milestone->rating;	
				
				$milestone->user_name = $user->full_name;
				if($action == 'assigned'){
					\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\ALJMilestoneUnIgnoreEmail($milestone));
					
					\Notification::send($user, new \App\Notifications\ALJMilestoneUnIgnoreNotification ($milestone_web_noti));
				}
				
				if($action == 'ignored'){
					\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\ALJMilestoneIgnoreEmail($milestone));
					
					\Notification::send($user, new \App\Notifications\ALJMilestoneIgnoreNotification ($milestone_web_noti));
				}
				
				if($action == 'complete'){
					\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\ALJMilestoneCompleteEmail($milestone));
									
					\Notification::send($user, new \App\Notifications\ALJMilestoneCompleteNotification ($milestone_web_noti));
				
					$milestone->user_name = auth()->user()->full_name;
					\Illuminate\Support\Facades\Mail::to([['name'=>"'".auth()->user()->full_name."'",'email'=>auth()->user()->email]])->send(new \App\Mail\PointEmail($milestone));
					
					$milestone_web_noti['total_point'] = content_type_wise_points(user_id())['total_points'];
					\Notification::send(\App\Model\User::findOrFail(user_id()), new \App\Notifications\PointNotification($milestone_web_noti));
				}			
				
			}
		}
	}
	
	//Assign milestones to users
	function assign_milestone_to_user($user_id, $ref_id, $details, $type){
		$data = $response = [];
		
		 if(!empty($details)){
			 $exist = \App\Model\MilestoneAssignment::where(['milestone_id'=>$details['milestone_id'],'user_id'=>$user_id])->get();
			if(count($exist) == 0){
				$data[] = array(
					'user_id'	 		=> $user_id,
					'type'	 			=> $type,
					'type_ref_id'		=> $ref_id,
					'journey_id' 		=> $details['journey_id'],
					'milestone_id' 		=> $details['milestone_id'],
					'assignment_type' 	=> $details['assignment_type'],
					'notes'				=> $details['notes'],
					'created_by' 		=> user_id(),
					'created_at'   		=> get_db_date_time()
					);
			}
			
			if(!empty($data) && \App\Model\MilestoneAssignment::insert($data)) {
				
				if($details['payment_type'] != 'free' && $details['journey_type_id'] != 2 && $details['journey_status'] === 'active'){
					approval_request($details['milestone_id']);
				}	
					
				$response['status']   = true;
				$response['milestone']    = true;
				$response['message']  = lang_message('milestone_assigned_success','milestone',$details['milestone_name']);
			} else {
				$response['status']   = false;
				$response['user_id']   = $user_id;
				$response['message']  = lang_message('milestone_assigned_failed','milestone',$details['milestone_name']);
			}
		 }else{
			$response['status']   = false;
			$response['message']  = lang_message('milestone_user_not_found');
		 }
		 return $response;
	}
	
	//Assign milestones to users
	function approval_request($milestone_id){
		
		$exist = \App\Model\Approval::where(['milestone_id'=>$milestone_id])->get();
		if(count($exist) == 0){
			if(\App\Model\Approval::create(['milestone_id'=>$milestone_id,'created_by'=>user_id()])) {  
				$data = array();
				$milestone = \App\Model\Milestone::findOrFail($milestone_id);
				
				if($milestone){
					$data['title'] = $milestone->title;
					$data['creator'] = $milestone->creator();
				}
					
				$notify_users = \App\Model\User::findOrFail($milestone->approver_id);
				
				//Approval request notification to approver
				if($notify_users->id != user_id())
				$notify_users->notify(new \App\Notifications\MilestoneApprovalRequestNotification($data));
				
				return true;
			} else {
				return false;
			}
		}
		return true;		
	}
	
	//Assign milestones to users
	function milestone_approval_price($milestone_id){
		
		$milestone = \App\Model\Milestone::where(['id'=>$milestone_id])->first();
		$assigned = \App\Model\MilestoneAssignment::where(['milestone_id'=>$milestone_id])->get();
		
		if($milestone){
			if($assigned){
				return round(($milestone->price * count($assigned)),2);
			}
		}
		return 0;		
	}
	
	//get milestone count
	function get_milestone_count($journey_id, $user_id=""){
		
		$milestone_count = \App\Model\MilestoneAssignment::where(['journey_id'=>$journey_id]);
		if($user_id != ""){
			$milestone_count->where(['user_id'=>$user_id]);
		}
		return $milestone_count->count();		
	}
	
	function profile_image($file_name){
	  if($file_name != "" && file_exists( public_path().'/storage/user-uploads/avatar/'.$file_name)){
        return asset('storage/user-uploads/avatar/'.$file_name);
      }else{
         return asset('images/user_profile.png');
      }
	}
	
	function journeyAvgRating($journey_id){
		
		$avg = \App\Model\MilestoneAssignment::join('milestones as m', 'm.id', '=', 'milestone_assignments.milestone_id','left')
		->whereNull('m.deleted_at')
		->where('m.journey_id',$journey_id)
		->where('milestone_assignments.status','completed')
		->select([\Illuminate\Support\Facades\DB::raw('AVG(milestone_assignments.rating) as avg_rating')])->groupBy('m.journey_id')
		->get();
		if(!empty($avg)){
			return round(($avg->first()->avg_rating),2);
		}
		return 0;
	}
	
	function jouney_break_down($journey_id, $journey_type_id, $user_id = '', $deleted_at = "", $category,$visibility, $assignment_type){
				
		$milestones = DB::table('milestones as m');
		$milestones->join('milestone_assignments as ma','ma.milestone_id','=','m.id','left');
		$milestones->join('content_types as ct','ct.id','=','m.content_type_id','left');
		
		if($visibility != 'all'){
			$milestones->where('m.visibility','=','public');
		}
		
		if($category == "owner"){
			if($assignment_type == ""){
				$milestones->where(function($q){			 
					$q->orWhere('ma.assignment_type','library')
					->orWhere('ma.assignment_type','predefined');
				});
			}else{
				$milestones->where('ma.assignment_type',$assignment_type);	
			}
		}				
		if($deleted_at == ""){
			$milestones->whereNull('m.deleted_at');
		}else{
			$milestones->where('ma.status','=','completed');
		}
		$milestones->where('m.journey_id',$journey_id);
		if($user_id != "" && $journey_type_id != 2){
			$milestones->where('ma.status','!=','revoked');
			$milestones->where('ma.user_id',$user_id);
		}
		$milestones->select(['m.journey_id','m.id as milestone_id','m.title as milestone_name','m.description','ct.name as content_name',DB::raw('COUNT(DISTINCT ma.user_id) as assigned_count'),DB::raw('SUM(CASE WHEN (ma.status = "completed") THEN 1 ELSE 0 END) as completed_count'),DB::raw('GROUP_CONCAT(DISTINCT ma.user_id) as user_id'),DB::raw('GROUP_CONCAT(DISTINCT ma.status) as assigned_status'),DB::raw('GROUP_CONCAT(CONCAT_WS("--",ma.user_id,ma.completed_date)) as user_comp_date'),DB::raw('GROUP_CONCAT(CONCAT_WS("--",ma.user_id,ma.point)) as user_point'),DB::raw('GROUP_CONCAT(CONCAT_WS("--",ma.user_id,ma.rating)) as user_rating'),DB::raw('ROUND(((SUM(CASE WHEN (ma.status = "completed") THEN 1 ELSE 0 END))/(COUNT(DISTINCT ma.user_id)))*100) as completed_percentage')]);
		$milestones->groupBy('m.id');
		
		return $milestones->get();	 
    }
	
	function content_type_wise_points($user_id){
		
		$points = $return_data = array();
		$point_data = DB::select('SELECT m.content_type_id, COUNT(DISTINCT CONCAT(m.id,ma.user_id)) as milestone_count, SUM(ma.point) as points FROM milestones as m LEFT JOIN  milestone_assignments as ma ON m.id = ma.milestone_id WHERE ma.status = "completed" AND ma.user_id = :user_id  GROUP BY m.content_type_id',['user_id'=>$user_id]);
		
		$total_data = DB::select('SELECT ma.user_id, COUNT(DISTINCT CONCAT(m.id,ma.user_id)) as milestone_count FROM milestones as m LEFT JOIN  milestone_assignments as ma ON m.id = ma.milestone_id WHERE m.deleted_at IS NULL AND ma.status != "revoked" AND ma.user_id = :user_id  GROUP BY ma.user_id',['user_id'=>$user_id]);

		$points['total_milestone_count'] = 0;
		$points['completed_milestone_count'] = 0;
		$points['total_points'] = 0;
		
		if($point_data){
			foreach($point_data as $data){
				$points[$data->content_type_id] = $data;
				$points['total_points'] += $data->points; 
				$points['completed_milestone_count'] += $data->milestone_count; 
			}
		}
		foreach(array_fill(1,7,"") as $key => $type){
			if(isset($points[$key])){
				unset($points[$key]->content_type_id);
				$return_data[$key] = $points[$key];
			}else{
				$return_data[$key] = (Object) ['milestone_count'=>0,'points'=>0];
			}
		}
		if($total_data){
			$return_data['total_milestone_count'] = $total_data[0]->milestone_count;
		}
		$return_data['completed_milestone_count'] = $points['completed_milestone_count'];
		$return_data['total_points'] = $points['total_points'];
		
		return $return_data;
	}
	
	function calclulatePoints($milestone_id,$completed_time){
		$points = 0;
		$completed_date = get_db_date($completed_time);

		$milestone_data = \App\Model\MilestoneAssignment::join('milestones as m', 'm.id', '=', 'milestone_assignments.milestone_id','left')
		->join('journeys as j', 'j.id', '=', 'milestone_assignments.journey_id','left')
		->whereNull('m.deleted_at')
		->where('milestone_assignments.user_id',user_id())
		->where('milestone_assignments.milestone_id',$milestone_id)
		->select(['j.journey_type_id','m.difficulty','m.end_date','m.read'])
		->groupBy('milestone_assignments.id')
		->get();
		if($milestone_data->count() >0){
			$milestone = $milestone_data->first();
			$date_diff = date_differance($milestone->end_date,$completed_date, true);			
			if($milestone->journey_type_id == 1){
				$points += ($date_diff == 0) ? 2 : 0;
				$points += ($date_diff > 0)  ? 3 : 0;
				$points += ($milestone->difficulty == 'beginner')     ? 1 : 0;
				$points += ($milestone->difficulty == 'intermediate') ? 2 : 0;
				$points += ($milestone->difficulty == 'advanced')     ? 3 : 0;
			}else{
				$points += ($date_diff < 0)  ? 1 : 0;
				$points += ($date_diff == 0) ? 6 : 0;
				$points += ($date_diff > 0)  ? 9 : 0;
				$points += ($milestone->difficulty == 'beginner')     ? 3 : 0;
				$points += ($milestone->difficulty == 'intermediate') ? 6 : 0;
				$points += ($milestone->difficulty == 'advanced')     ? 9 : 0;
				$points += ($milestone->read == 'optional')   ? 3 : 0;
				$points += ($milestone->read == 'compulsory') ? 5 : 0;
			}
		}
		return $points;
	}

	function file_get_contents_curl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	
	function get_url_meta_tags($url){
		$tags = $res =  array();
		$html = file_get_contents_curl($url);
		$title = "";
		//parsing begins here:
		$doc = new DOMDocument();
		@$doc->loadHTML($html);
		$nodes = $doc->getElementsByTagName('title');
		if($nodes->length > 0){
			$title = $nodes->item(0)->nodeValue;
		}
		$meta = $doc->getElementsByTagName('meta');
		if($meta){
			foreach ($meta as $element) {
				$tag = [];
				foreach ($element->attributes as $node) {
					$tag[$node->name] = $node->value;
				}
				$tags []= $tag;
			}
		}

		$des_keys 		= ['Description','description','og:description'];
		$keyword_keys   = ['keyword','keywords','Keyword','Keywords','og:keyword','og:keywords'];
		$provider_keys  = ['author','Author','provider','Provider','og:author','og:provider'];
		$length_keys    = ['length','Length','minutes','Minutes','minute','Minute','og:minute','og:minutes','og:length'];

		$res['url'] = $url;
		$res['title'] = $title;
		if(!empty($tags)){
			foreach ($tags as $tg_value) {
				$content = "";
				$content = (isset($tg_value['content']) && $tg_value['content'] != "") ? $tg_value['content'] : '';
				if(isset($tg_value['name']) && (in_array($tg_value['name'],$des_keys))){
					$res['description'] = $content;		
				}
				if(isset($tg_value['name']) && (in_array($tg_value['name'],$keyword_keys))){
					$res['keywords'] = $content;		
				}
				if(isset($tg_value['name']) && (in_array($tg_value['name'],$provider_keys))){
					$res['provider'] = $content;			
				}
				if(isset($tg_value['name']) && (in_array($tg_value['name'],$length_keys))){
					$res['length'] = $content;			
				}		
			}
		}

		return $res;
	}
	
	function lang_message($message_key ="", $oldTxt ="", $newTxt = ""){		
		if($oldTxt != "" && $newTxt != "" && $message_key != ""){
			return str_replace("{".$oldTxt."}",$newTxt,__('message.'.$message_key));
		}if($message_key != ""){
			return __('message.'.$message_key);
		}else{
			return "";
		}
	}
	
	function jounrey_certificate_link($journey_id, $file_path = false){
		
	  $file_name = encode_url(user_id()).'_'.$journey_id;
	  
	  if($file_name != "" && file_exists( public_path().'/storage/certificates/journey/'.$file_name.'.pdf')){
		  
		if($file_path){			
			return storage_path('app/public/certificates/journey/'.$file_name.'.pdf');
		}
		
        return asset('storage/certificates/journey/'.$file_name.'.pdf');
      }else{
		  
		$journey = \Illuminate\Support\Facades\DB::table('passport_journey_view as j')->where('user_id',user_id())->where('journey_id',decode_url($journey_id))->select(['journey_name','completed_date'])->get()->first();
	
		$journey->user_name = auth()->user()->full_name;
		
		PDF::loadView('certificates.journey', compact('journey'))->setWarnings(false)->save('storage/certificates/journey/'.$file_name.'.pdf');
		
		if($file_path){			
			return storage_path('app/public/certificates/journey/'.$file_name.'.pdf');
		}
		
		return asset('storage/certificates/journey/'.$file_name.'.pdf');
      }
	}
	
	function milestone_certificate_link($milestone_id, $file_path = false){
		
	  $file_name = encode_url(user_id()).'_'.$milestone_id;
	  
	  if($file_name != "" && file_exists( public_path().'/storage/certificates/milestone/'.$file_name.'.pdf')){
		
		if($file_path){			
			return storage_path('app/public/certificates/milestone/'.$file_name.'.pdf');
		}
		
        return asset('storage/certificates/milestone/'.$file_name.'.pdf');
      }else{
		$milestone = \App\Model\Milestone::withTrashed()->join('milestone_assignments as ma', 'milestones.id', '=', 'ma.milestone_id','left')->where('ma.user_id',user_id())->where('ma.milestone_id',decode_url($milestone_id))->select(['milestones.title as milestone_name','ma.completed_date'])->get()->first();

		$milestone->user_name = auth()->user()->full_name;
		PDF::loadView('certificates.milestone', compact('milestone'))->setWarnings(false)->save('storage/certificates/milestone/'.$file_name.'.pdf');
		
		if($file_path){			
			return storage_path('app/public/certificates/milestone/'.$file_name.'.pdf');
		}
		return asset('storage/certificates/milestone/'.$file_name.'.pdf');
      }
	}
	
	
	function get_tempcheck_survay_dates($startDate, $endDate, $frequney, $frequney_day){
		$startDate = new DateTime($startDate);
		$endDate = new DateTime($endDate);
		$day = ['sun'=>0,'mon'=>1,'tue'=>2,'wed'=>3,'thu'=>4,'fri'=>5,'sat'=>6];
		$dates = array();
		$i = 1;
		while ($startDate <= $endDate) {
			if($frequney == 'weekly'){
				if ($startDate->format('w') == $day[$frequney_day]) {
					$dates[] = $startDate->format('Y-m-d');
				}
			}elseif($frequney == 'bi-weekly'){
				if ($startDate->format('w') == $day[$frequney_day] && (($i % 2) == 0)) {
					$dates[] = $startDate->format('Y-m-d');					
				}
				$i++;
			}else{
				if ($startDate->format('d') == $frequney_day) {
					$dates[] = $startDate->format('Y-m-d');
				}
			}
			$startDate->modify('+1 day');
		}

		return $dates;
	}

//**********************************************//
