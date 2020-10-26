<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Group;
use App\Model\GroupUserList;
use App\Model\User;
use App\Model\ChartSidebar;

use App\Http\Requests\StoreGroupPost;
use App\Http\Requests\UpdateGroupPut;
use App\Http\Requests\StoreMemberPost;
use App\Http\Requests\StoreSharedBoardPost;
use App\Http\Requests\UpdateSharedBoardPut;
use App\Http\Requests\StoreSharedCommentPost;


use App\Authorizable;

class GroupController extends BaseController
{
	
	use Authorizable;
	
	Public function __construct(){
		parent::__construct();
	}
	
	//Datatable conditional filters 
	private function groupfilterCondition(Request $request, $whereArray){
		
		if(isset($request->group_id)){
			$condition['field'] = 'groups.id';
			$condition['condition'] = '=';
			$condition['value'] = $request->group_id;
			$whereArray[] = $condition;
		}

		if(isset($request->created_by)){
			$condition['field'] = 'created_by';
			$condition['condition'] = '=';
			$condition['value'] = $request->created_by;
			$whereArray[] = $condition;
		}
		
		if(isset($request->admin_id)){
			$condition['field'] = 'admin.admin_id_filter';
			$condition['value'] = $request->admin_id;	
			$whereArray['FIND_IN_SET'][] = $condition;			
		}		

		if(isset($request->member_count)){
			$condition['field'] = 'members.member_count';
			$condition['condition'] = '=';
			$condition['value'] = ($request->member_count == 0) ? null : $request->member_count;
			$whereArray[] = $condition;
		}

		if(isset($request->journey_count)){
			$condition['field'] = 'journeys.journey_count';
			$condition['condition'] = '=';
			$condition['value'] = ($request->journey_count == 0) ? null : $request->journey_count;
			$whereArray[] = $condition;
		}	
		
		if(isset($request->created_date)){
			$condition['field'] = 'created_at';
			//$condition['value'] = parseDateRange($request->created_date);
			$created_date = json_decode($request->created_date,true); 
			$condition['value'] = [$created_date['start'].' 00:00:00', $created_date['end'].' 23:59:59'];
			$whereArray['between'][] = $condition;
		}		
		return $whereArray;
	}
	
	public function ajax_list(Request $request)
    {
		
		$data = $whereArray = array();
		
		$group_collection = Group::join(DB::raw('(SELECT id, CONCAT(first_name," ",last_name) as created_name FROM users) as created'),'created.id','=','groups.created_by','left')
		->join(DB::raw('(SELECT ml.group_id, GROUP_CONCAT(u.id SEPARATOR "---") as admin_id, GROUP_CONCAT(u.id) as admin_id_filter, GROUP_CONCAT(CONCAT(u.first_name," ",u.last_name) SEPARATOR "---") as admin_name FROM users as u LEFT JOIN group_user_lists as ml ON u.id = ml.user_id WHERE ml.is_admin = 1 AND ml.deleted_at IS NULL GROUP BY ml.group_id) as admin'),'admin.group_id','=','groups.id','left')
		->join(DB::raw('(SELECT type_ref_id as group_id, COUNT(*) as journey_count FROM journeys WHERE type="group" AND deleted_at IS NULL GROUP BY type_ref_id) as journeys'),'journeys.group_id','=','groups.id','left')
		->join(DB::raw('(SELECT group_id, GROUP_CONCAT(user_id) as group_member_ids , COUNT(user_id) as member_count FROM group_user_lists WHERE deleted_at IS NULL GROUP BY group_id) as members'),'members.group_id','=','groups.id','left');
		
		if(!is_admin()){
			$group_collection->whereRaw('(groups.visibility = "public" OR FIND_IN_SET('.user_id().',members.group_member_ids))');
		}
		
		$group_collection->select('groups.id as group_id','groups.group_name','members.member_count','members.group_member_ids','admin.admin_name','admin.admin_id','groups.created_at','groups.created_by','journeys.journey_count','created.created_name');		
		
		$whereArray = $this->groupfilterCondition($request, $whereArray);		
		
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){				
				if($key === 'between'){				
					foreach($where as $k=>$v){
						$group_collection->whereBetween($v['field'],$v['value']);
					}
				}elseif($key === 'FIND_IN_SET'){				
					foreach($where as $k=>$v){
						$group_collection->whereRaw('FIND_IN_SET('.$v['value'].','.$v['field'].')');
					}
				}
				else{				
					$group_collection->where($where['field'],$where['condition'],$where['value']);
				}
			} 
		}	

		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$group_collection->where(function($query) use ($search_for, $request){
				$query->orWhere('groups.group_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('admin.admin_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('created.created_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere(DB::raw("DATE_FORMAT(groups.created_at, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
			});			
		}
		
		//echo $group_collection->toSql(); exit;
		$groups = $group_collection->get();
		//pr($groups,1);
		$action = $expand = "";
        return datatables()->of($groups)->addColumn('action', function($row) use($action,$expand) {
			
			$action .='<a href="'.route('groups.show',[encode_url($row->group_id)]).'" title="View" class="btn btn-blue">View</a>';
			
			if($this->user->hasPermissionTo('edit_groups')){
				$action .='<a href="'.route('groups.edit',[encode_url($row->group_id)]).'" title="Edit" class="btn btn-lightblue">Edit</a>';
			}
			
			if(is_group_member($row->group_id)){		
				$expand .='<a href="javascript:" onclick="leaveGroup('."'".encode_url($row->group_id)."'".','."'".$row->group_name."'".')" title="Leave Group" class="btn btn-green">Leave Group</a>';
			}
			
			if(is_group_member($row->group_id) || is_admin()){
				$expand .='<a href="'.route('groups.shared_board',[encode_url($row->group_id)]).'" title="Shared Board" class="btn btn-lightblue">Shared Board</a>';
			}
			
			if($this->user->hasPermissionTo('delete_groups')){
				$expand .='<a href="javascript:" onclick="deleteGroup('."'".encode_url($row->group_id)."'".','."'".$row->group_name."'".')" title="Delete" class="btn btn-red">Delete</a>';
			}
			
			if($expand != ""){
				$action .='<span class="expand-dot"><i class="icon-Expand animation" title="More" ></i><div class="btn-dropdown"> <ul class="list-unstyled">'.$expand.'</ul> </div></span>';
			}
			
			return $action;
        })->addColumn('admin_name', function($row){
			$admin_name = "";
			$admin = explode('---',$row->admin_name);
			$admin_id = explode('---',$row->admin_id);
			if(!empty($admin)){
				foreach($admin as $key=>$name){
					if($admin_id[$key] == user_id()){
						$admin_name .= __('lang.my_self');
					}else{
						$admin_name .= '<p><span class="maxname">'.$name.'</span></p>';
					}
				}				
			}			
			return $admin_name;
		})->addColumn('user_count', function($row){
			return ($row->member_count != "") ? $row->member_count : 0;
		})->addColumn('journey_count', function($row){
			return ($row->journey_count != "") ? $row->journey_count : 0;
		})->addColumn('created_by', function($row){
			if($row->created_by == user_id()){
				return __('lang.my_self');
			}else{
				return '<span class="maxname">'.$row->created_name.'</span>';
			}
		})->addColumn('created_at', function($row){
			return get_date($row->created_at);
		})->make(true);
		
    }
	
	public function group_members_list(Request $request){
		
		$group_id = decode_url($request->group_id);
		
		$members = GroupUserList::join('groups as g', 'g.id', '=', 'group_user_lists.group_id')
		->join(DB::raw('(SELECT id, CONCAT(first_name," ",last_name) as member_name, email, designation FROM users) as u'),'u.id','=','group_user_lists.user_id','left')
		->join(DB::raw('(SELECT user_id, COUNT(*) as milestone_completed_count FROM milestone_assignments WHERE status="completed" GROUP BY user_id) as ma'),'ma.user_id','=','group_user_lists.user_id','left')
		->where('g.id',$group_id)
		->whereNull('group_user_lists.deleted_at')
		->select('g.id as group_id','g.group_name','u.id as user_id','u.member_name','u.email','u.designation','group_user_lists.is_admin','ma.milestone_completed_count')
	    ->get();
		
		
		$action ="";
		$expand ="";
        return datatables()->of($members)->addColumn('action', function($row) use($action, $expand) {
			$action .='<a href="'.route('users.passport',[encode_url($row->user_id)]).'" class="btn btn-blue">View Passport</a>';
			
			if(is_admin() || is_group_admin($row->group_id)){
				if($row->is_admin != 1 && (is_admin() || is_group_admin($row->group_id))){
					$action .='<a href="javascript:;" onclick="makeAsAdmin(\''.encode_url($row->user_id).'\',\''.encode_url($row->group_id).'\',\''.$row->member_name.'\',\''.$row->group_name.'\')" class="btn btn-lightblue">Make Admin</a>';
				}
			}
			if(is_admin() || is_group_admin($row->group_id)){
				if($row->user_id != user_id() && (is_admin() || is_group_admin($row->group_id))){
					$action .='<a href="javascript:;" onclick="removeMember(\''.encode_url($row->user_id).'\',\''.encode_url($row->group_id).'\',\''.$row->member_name.'\',\''.$row->group_name.'\')" class="btn btn-darkgreen">Remove</a>';
				}
			}						
			return $action;			
		})->addColumn('member_name', function($row){
			$admin_span = "<p><span class='groupAdmin'>(Admin)</span></p>";
			if($row->user_id == user_id()){
				$member_name = __('lang.my_self');  
		    }else{
				$member_name = ucfirst($row->member_name);
		    };
			return (($row->is_admin != 1) ? $member_name : $member_name.$admin_span);			
		})->addColumn('email', function($row){
			return $row->email;
		})->addColumn('designation', function($row){
			return ($row->designation != "") ? ucfirst($row->designation) : '-';
		})->addColumn('milestone_completed_count', function($row){
			return ($row->milestone_completed_count != "") ? $row->milestone_completed_count : '-';
		})->make(true);
	}

	public function user_group_list(Request $request){

		$user_id = decode_url($request->user_id);
		
		$groups = Group::join(DB::raw('(SELECT group_id, GROUP_CONCAT(DISTINCT user_id) as group_member_ids FROM group_user_lists WHERE deleted_at IS NULL GROUP BY group_id) as members'),'members.group_id','=','groups.id','left')->whereRaw('(groups.visibility = "public" OR FIND_IN_SET('.user_id().',members.group_member_ids))')->whereRaw('FIND_IN_SET('.$user_id.',members.group_member_ids)')->select(['groups.id as group_id','groups.group_name'])->orderBy('groups.group_name','asc')->get();
		
		$action ="";
        return datatables()->of($groups)->addColumn('action', function($row) use($action) {
			$action .='<a href="'.route('groups.passport',[encode_url($row->group_id)]).'" class="btn btn-blue">View Group</a>';

			return $action;			
		})->addColumn('group_name', function($row){
			return ucfirst($row->group_name);
		})->make(true);
	}	
	
	//Group learning journey ajax list	
	public function group_journeys_list(Request $request)
    {
		$group_id = decode_url($request->group_id);
		
		$data = $whereArray = array();
					
		$whereArray[0]['field'] = 'j.journey_type_id';
		$whereArray[0]['condition'] = '=';
		$whereArray[0]['value'] = 3;
		
		$whereArray[1]['field'] = 'j.type';
		$whereArray[1]['condition'] = '=';
		$whereArray[1]['value'] = 'group';
		
		$whereArray[2]['field'] = 'j.type_ref_id';
		$whereArray[2]['condition'] = '=';
		$whereArray[2]['value'] = $group_id;
		
		$journeys = DB::table('journeys as j');
		$journeys->join('milestones as m','m.journey_id','=','j.id','left');
		$journeys->join(DB::raw('(SELECT id, CONCAT(first_name," ",last_name) as assigned_name FROM users) as u'),'u.id','=','j.created_by','left');
		
		$journeys->join(DB::raw('(SELECT journey_id, milestone_count, SUM(completed_milestone_count) as completed_milestone_count,
		ROUND(((SUM(completed_milestone_count)/ SUM(milestone_count))* 100)) AS complete_percentage FROM journey_assignment_view group by journey_id ) as jav'),'jav.journey_id','=','j.id','left');

		$journeys->select([
		'j.id as journey_id',		
		'j.journey_name',
		'j.created_by',
		'j.type',
		'j.type_ref_id',
		DB::raw('MAX(m.end_date) as targeted_complete_date'),
		'jav.milestone_count',
		'jav.completed_milestone_count',
		'jav.complete_percentage',
		'u.assigned_name',
		DB::raw('(SELECT status FROM journey_assignments WHERE journey_id = j.id AND status = "revoked" LIMIT 1) as revoked'
		),
		'j.created_at as created_at']);
        		
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){
				$journeys->where($where['field'],$where['condition'],$where['value']);
			} 
		}

		$journeys->groupBy('j.id');
		$journeyData = $journeys->get();
		//pr($journeyData,1);
		
		foreach($journeyData as $key => $row){
		    $action = "";
			
			$action .='<a href="'.route('journeys.my_journey',[encode_url($row->journey_id)]).'" title="View" class="btn btn-blue">View</a>';
			
		
			if($this->user->hasPermissionTo('edit_journeys') && $row->created_by == user_id()){
				$action .='<a href="'.route('journeys.edit',[encode_url($row->journey_id)]).'" title="Edit" class="btn btn-lightblue">Edit</a>';
			}
			
			if($row->revoked != 'revoked' && is_group_admin($group_id)){
					$action .= '<button type="button" title="Revoke" onclick="revokeJourney('."'".encode_url($row->journey_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->journey_name."'".')" class="btn btn-darkgreen">Revoke</button>';
			}			
			
			if($row->created_by == user_id()){
				$assigned_name = __('lang.my_self');  
		    }else{
				$assigned_name = ucfirst($row->assigned_name);
		    };
		   
           $data[$key]['id']        	= ''; 
		   $data[$key]['journey_name']		= ucfirst($row->journey_name); 
		   $data[$key]['milestone_count']		= $row->milestone_count;
		   $data[$key]['assigned_by']		= $assigned_name;
		   $data[$key]['assigned_date']		= get_date($row->created_at); 
		   $data[$key]['targeted_complete_date']		= get_date($row->targeted_complete_date); 
           $data[$key]['progress']  		= ($row->complete_percentage != "") ? $row->complete_percentage." %" : "-";		   
		   $data[$key]['action']    		= $action; 
	   }
	   return datatables()->of($data)->make(true);
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		if(is_admin()){
				$groups = Group::select(['id','group_name'])->orderBy('group_name','asc')->get();
		}else{
			$groups = Group::join(DB::raw('(SELECT group_id, GROUP_CONCAT(DISTINCT user_id) as group_member_ids FROM group_user_lists WHERE is_admin = 1 AND deleted_at IS NULL GROUP BY group_id) as members'),'members.group_id','=','groups.id','left')->whereRaw('(groups.visibility = "public" OR FIND_IN_SET('.user_id().',members.group_member_ids))')->select(['groups.id','groups.group_name'])->orderBy('groups.group_name','asc')->get();
		}
		
		//All Group creator list
		$created_by = Group::leftjoin('users','users.id','=','groups.created_by')
		->select('users.id as user_id',DB::raw('CONCAT(users.first_name," ",users.last_name) as created_name'))->orderBy('created_name','asc')->get()->unique('user_id');
		
		//All Group admin list		
		$admins = User::leftjoin('group_user_lists as ml','ml.user_id','=','users.id')
		->select('users.id as user_id',DB::raw('CONCAT(users.first_name," ",users.last_name) as admin_name'),'ml.group_id','ml.is_admin')
		->where('ml.is_admin',1)->whereNull('ml.deleted_at')->orderBy('admin_name','asc')
		->get()->unique('user_id');
		
		//Group wise members Count
		$member_count = GroupUserList::whereNull('deleted_at')
		->select(DB::raw('COUNT(*) as member_count'))		
		->groupBy('group_id')->orderBy('member_count','asc')->get()
		->unique('member_count')->pluck('member_count','member_count');
 
		//Group wise journey Count
		$journey_count = \App\Model\Journey::whereType('group')->whereNull('deleted_at')
		->select(DB::raw('COUNT(*) as journey_count'))
		->groupBy('type_ref_id')->orderBy('journey_count','asc')->get()
		->unique('journey_count')->pluck('journey_count','journey_count');
		
        return view('group_management/group_list',compact('groups','admins','created_by','member_count','journey_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id="")
    {
	    if($id != ""){
			$group = Group::findOrFail(decode_url($id));
	    }else{
			$group = [];
		}	
		
       $org_datas = ChartSidebar::all('id','set_id','set_name');
       
       return view('group_management/group_add',compact('org_datas','group'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupPost $request)
    {
		if(isset($request->primary_id) && $request->primary_id != ""){
			$group_info = Group::findOrFail(decode_url($request->primary_id));
		}else{
			$group_info = new Group();
		}
		
		$group_info->group_name 		= $request->group_name;
		$group_info->group_description 	= $request->group_description;
		$group_info->visibility 		= $request->visibility;
		$group_info->created_by 		= user_id();	
		
        if($group_info->save()){
		   $this->add_member($group_info->id, user_id(), 1);
           $this->response['status']   = true;
		   $this->response['group_id'] = encode_url($group_info->id);
           $this->response['message']  = lang_message('group_create_success','group',$request->group_name);
        }else{
            $this->response['status'] = false;
            $this->response['message'] = lang_message('group_create_failed','group',$request->group_name);
        }
    
		return $this->response();
    }

	private function add_member($group_id, $user_id, $is_admin = 0 ){
		$user_data = array();
		$user_data['group_id'] =  $group_id;
		$user_data['user_id']  =  $user_id;
		$user_data['is_admin'] =  $is_admin;
		if(GroupUserList::updateOrCreate($user_data)){
			return true;
		}
		return false;
	}
		
    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$group = array();
		
		if(is_admin()){
			$group = Group::findOrFail(decode_url($id));
		}else{
			$groups = Group::join(DB::raw('(SELECT group_id, GROUP_CONCAT(DISTINCT user_id) as group_member_ids FROM group_user_lists WHERE deleted_at IS NULL GROUP BY group_id) as members'),'members.group_id','=','groups.id','left')->where('groups.id',decode_url($id))->whereRaw('(groups.visibility = "public" OR FIND_IN_SET('.user_id().',members.group_member_ids))')->get();
			if($groups->count() > 0){
				$group = $groups->first();
			}
		}
	
		if(!empty($group) && $this->user->hasPermissionTo('view_groups')){
			return view('group_management/group_view',compact('group'));
		}else{
			return redirect(route('groups.index'));
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$group = array();
		
		if(is_admin()){
			$group = Group::findOrFail(decode_url($id));
		}else{
			$groups = Group::join(DB::raw('(SELECT group_id, GROUP_CONCAT(DISTINCT user_id) as group_member_ids FROM group_user_lists WHERE deleted_at IS NULL GROUP BY group_id) as members'),'members.group_id','=','groups.id','left')->where('groups.id',decode_url($id))->whereRaw('(groups.visibility = "public" OR FIND_IN_SET('.user_id().',members.group_member_ids))')->get();
			if($groups->count() > 0){
				$group = $groups->first();
			}
		}
	
		if(!empty($group) && ($this->user->hasPermissionTo('edit_groups'))){
			return view('group_management/group_edit',compact('group'));
		}else{
			return redirect(route('groups.index'));
		}
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGroupPut $request, Group $group)
    {
		if($this->user->hasPermissionTo('edit_groups')){
			$group->group_name 			= $request->group_name;
			$group->group_description 	= $request->group_description;
			$group->visibility 			= $request->visibility;
			$group->updated_by 			= user_id();	
			
			if($group->save()){
			   $this->response['status']   = true;
			   $this->response['message']  = lang_message('group_update_success','group',$request->group_name);
			}else{
				$this->response['status'] = false;
				$this->response['message'] = lang_message('group_update_failed','group',$request->group_name);
			}
		}else{
				$this->response['status'] = false;
				$this->response['message'] = lang_message('unauthorized_access');
		}
    	return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::findOrFail(decode_url($id));
		$group_id 	= $group->id;
		$group_name = $group->group_name;
		if($this->user->hasPermissionTo('delete_groups')){
			if($group->delete()){
				$user_ids = GroupUserList::whereNull('deleted_at')->Where('group_id',decode_url($id))->pluck('user_id');			
				GroupUserList::whereNull('deleted_at')->Where('group_id',decode_url($id))->delete();
				
				if(\App\Model\Journey::whereType('group')->where('type_ref_id',$group_id)->delete()){
					\App\Model\Milestone::whereType('group')->where('type_ref_id',$group_id)->delete();
				}
				
				$users = User::whereIn('id',$user_ids)->where('id','!=',user_id())->whereStatus('active')->get();
				foreach($users as $user){
					if($user){	
						//Email Notification
						\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\GroupDeleteEmail(['user_name'=>$user->full_name,'deleted_name'=>auth()->user()->full_name,'group_id'=>$group_id,'group_name'=>$group_name]));
						
						//Web notification
						\Notification::send($user, new \App\Notifications\GroupDeleteNotification(['group_id'=>$group_id,'group_name'=>$group_name]));
					}
				}
				
				$this->response['status']   = true;
				$this->response['message']  = lang_message('group_delete_success','group',$group_name);
			}else{
				$this->response['status']   = false;
				$this->response['message']  = lang_message('group_delete_failed','group',$group_name);
			}
		}else{
				$this->response['status'] = false;
				$this->response['message'] = lang_message('unauthorized_access');
		}
		return $this->response();
    }
	
	public function new_admin(Request $request)
    {
		$group_id = decode_url($request->group_id);
		$user_id = $request->user_id;		
		$current_admin_id = $request->admin_id;		
        $group = Group::findOrFail($group_id);
		
		if(GroupUserList::whereNull('deleted_at')->where('group_id',$group_id)->where('user_id',$user_id)->update(['is_admin'=>1])){	
		
		   GroupUserList::whereNull('deleted_at')->where('group_id',$group_id)->where('user_id',$current_admin_id)->delete();		
		   
           $this->response['status'] = true;
           $this->response['action'] = 'new_admin';		   
           $this->response['message'] = lang_message('assign_group_admin_success','username',$request->name);
		   
		   if($group->visibility == 'private' && !is_admin())
			$this->response['redirect'] = route('groups.index');
				
		   if($user_id != user_id()){
			$this->new_admin_notification($user_id, $group_id, $request->name);
			$this->make_admin_notification($user_id, $group_id, $request->name);
		   }
        }else{
            $this->response['status'] = false;
            $this->response['message'] = lang_message('assign_group_admin_failed','username',$request->name);
        }		
		return $this->response();
    }	
	
	private function new_admin_notification($user_id, $group_id, $group_name){
		
		//Member leave web notification to the Group Members
		$user_ids = GroupUserList::whereNull('deleted_at')->where(['group_id'=>$group_id])->where('user_id','!=',user_id())->where('user_id','!=',$user_id)->pluck('user_id');
		
		$users = User::whereIn('id',$user_ids)->get();
		
		//Admin Leave notification to all member
		\Notification::send($users, new \App\Notifications\GroupLastAdminLeaveNotification(['group_id'=>$group_id, 'group_name' =>$group_name]));
		
		//Admin Leave notification to new admin
		$admin_user = User::findOrFail($user_id);
		\Notification::send($admin_user, new \App\Notifications\GroupLastAdminLeaveNotification(['group_id'=>$group_id, 'group_name' =>$group_name]));
		
		//New admin notification to all group members
		\Notification::send($users, new \App\Notifications\GroupNewAdminNotification(['group_id'=>$group_id, 'group_name' =>$group_name,'admin_name'=>$admin_user->full_name]));
		
		return true;
	}
	
	public function make_admin(Request $request)
    {
		$group_id = decode_url($request->group_id);
		$user_id = decode_url($request->user_id);		
		if(is_admin() || is_group_admin($group_id)){			
			if(GroupUserList::whereNull('deleted_at')->where('group_id',$group_id)->where('user_id',$user_id)->update(['is_admin'=>1])){
			   $this->make_admin_notification($user_id, $group_id, $request->group_name);
			   $this->response['status'] = true;
			   $this->response['message'] = lang_message('make_group_admin_success','username',$request->name);
			}else{
				$this->response['status'] = false;
				$this->response['message'] = lang_message('make_group_admin_failed','username',$request->name);
			}
		}else{
			$this->response['status'] = false;
			$this->response['message'] = lang_message('unauthorized_access');
		}
		return $this->response();
    }
	
	private function make_admin_notification($user_id, $group_id, $group_name){
		$user = User::findOrFail($user_id);
		if($user){	
			//Email Notification
			\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\GroupAdminAddEmail(['user_name'=>$user->full_name,'added_name'=>auth()->user()->full_name,'group_id'=>$group_id,'group_name'=>$group_name]));
			
			//Web notification
			\Notification::send($user, new \App\Notifications\GroupAdminAddNotification(['group_id'=>$group_id,'group_name'=>$group_name]));
		}
		return true;
	}
		
	public function store_member(StoreMemberPost $request){
	    $new_members = explode(',',$request->member_id);
	    $group_id = decode_url($request->group_id);
		
		if(is_admin() || is_group_admin($group_id)){
			$group = Group::findOrFail($group_id);
			if(!empty($new_members)){
				$user_ids = array();			
				foreach($new_members as $k=>$id){
					 if($this->add_member($group_id, $id)){
						if($id != user_id()){
							array_push($user_ids,$id);						
							//Group new member email notification
							$user = User::findOrFail($id);
							if($user){
								\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\GroupMemberAddEmail(['user_name'=>$user->full_name,'added_name'=>auth()->user()->full_name,'group_id'=>$group->id,'group_name'=>$group->group_name]));
							}
						}
					 }
				}
				
				//Send group member web notification
				if(!empty($user_ids)){		
					$users = User::whereIn('id',$user_ids)->get();
					//Web Notification
					\Notification::send($user, new \App\Notifications\GroupMemberAddNotification(['group_id'=>$group->id,'group_name'=>$group->group_name]));
				}	 
			}
			$this->response['status']  = true;
			$this->response['action']  = 'add_member';
			$this->response['message'] = lang_message('add_group_member_success','group',$group->group_name);
		}else{
			$this->response['status'] = false;
			$this->response['message'] = lang_message('unauthorized_access');
		}	
		return $this->response();
	}	
	
	public function member_list($id="")
    {
		$members_list = $group_user_ids = array();
		
		if($id !="" ){
			$members_list = User::leftjoin('group_user_lists as ml','ml.user_id','=','users.id')
			->select('users.id as user_id',DB::raw('CONCAT(users.first_name," ",users.last_name) as user_name'),'ml.group_id','ml.is_admin')
			->where('ml.group_id',decode_url($id))
			->whereNull('ml.deleted_at')
			->get();
			
			$group_user_ids= $members_list->pluck('user_id');
		}
		
		$users_list = User::whereNotIn('id',$group_user_ids)->select('id','first_name','last_name')->get();
		
		$this->response['status']  = true;
		$this->response['data']    = ['members_list'=>$members_list, 'users_list'=>$users_list];
		$this->response['message'] = lang_message('get_group_member_list');

		return $this->response();
    }
	
	public function shared_board($id)
    {
		$group_info_data = Group::where('id',decode_url($id))->whereNull('deleted_at')->get();
		if(($group_info_data->count() > 0) && (is_public_group(decode_url($id)) || is_admin())){
			$journeys = \App\Model\Journey::whereType('group')->where('type_ref_id',decode_url($id))->pluck('journey_name','id');

			$posts = \App\Model\GroupPost::Where('group_id',$group_info_data->first()->id)->orderBy('id','desc')->get();
			//->paginate(3); 
			$group_info = $group_info_data->first();
			return view('group_management/shared_board',compact('group_info','posts','journeys'));
		}else{
			return redirect(route('groups.index'));
		}
    }
	
	public function load_post($id){
		$group_info = Group::findOrFail(decode_url($id));
        $posts = \App\Model\GroupPost::Where('group_id',$group_info->id)->orderBy('id','desc')->get();   
		return view('group_management/shared_board_posts',compact('group_info','posts'));
	}
	
	public function load_post_comment($id){
		$post = \App\Model\GroupPost::findOrFail(decode_url($id)); 
		return view('group_management/shared_board_comments',compact('post'));
	}	
	
	public function load_replay_comment($id){
		$comments = \App\Model\Comment::findOrFail($id)->replies;  
		$comment_id = $id;
		$post_id = $comments->first()->commentable_id; 
		return view('group_management/shared_board_replay_comments',compact('post_id','comment_id','comments'));
	}	
	
	public function get_post($id){
		
		$this->response['status'] = true;
		$this->response['data'] = \App\Model\GroupPost::findOrFail(decode_url($id));
        $this->response['message'] = lang_message('get_post_success');
		
		return $this->response();
	}
	
	public function store_post(StoreSharedBoardPost $request)
    {
        $post =  new \App\Model\GroupPost;
		
        $post->group_id 	= decode_url($request->group_id);
        $post->journey_id 	= $request->journey_id;
        $post->content 		= $request->get('content');
        $post->created_by 	= user_id();
        		
		if($post->save()){
			
			//Send Post web notification to the Group Members
			$user_ids = GroupUserList::whereNull('deleted_at')->where(['group_id'=>$post->group_id])->where('user_id','!=',user_id())->pluck('user_id');
			$users = User::whereIn('id',$user_ids)->get();
			\Notification::send($users, new \App\Notifications\GroupPostNotification(['post_id'=>$post->id,'group_id'=>$post->group_id, 'group_name' =>$request->group_name]));

					
            $this->response['status'] = true;
			$this->response['action'] = 'store_post';
           $this->response['message'] = lang_message('group_post_add_success');

        }else{
            $this->response['status'] = false;
            $this->response['message'] = lang_message('group_post_add_failed');;
        }
		
		return $this->response();
    }
	
	public function update_post(UpdateSharedBoardPut $request, $id)
    {
        $post =  \App\Model\GroupPost::findOrFail(decode_url($id));
        $post->content 		= $request->get('content');
        $post->updated_by 	= user_id();
        		
		if($post->save()){
            $this->response['status'] = true;
            $this->response['action'] = 'update_post';
            $this->response['message'] = lang_message('group_post_update_success');
        }else{
            $this->response['status'] = false;
            $this->response['message'] = lang_message('group_post_update_failed');;
        }		
		return $this->response();
    }
	
	public function store_post_comment(StoreSharedCommentPost $request)
    {
		unset($this->response['comment_id']);
        $comment = new \App\Model\Comment;
		if($request->is_replay_comment == 'true'){
			$comment->parent_id = $request->get('comment_id',Null);
			$this->response['comment_id'] = $request->comment_id;
		}
		
        $comment->comment = $request->get('comment');
        $comment->user()->associate($request->user());
        $post = \App\Model\GroupPost::find($request->get('post_id'));
		
		if($post->comments()->save($comment)){
			
			//Send Post replay web notification to the Post creator
			if($post->created_by != user_id()){
				$user = User::findOrFail($post->created_by);
				\Notification::send($user, new \App\Notifications\GroupPostCommentNotification(['post_id'=>$post->id,'group_id'=>$post->group_id]));
			}
			
			$this->response['post_id'] = encode_url($request->post_id);
			$this->response['action']  = 'store_comment';
			$this->response['status']  = true;
			$this->response['message'] = lang_message('group_comment_success');
        }else{
            $this->response['status'] = false;
            $this->response['message'] = lang_message('group_comment_failed');
        }		
		return $this->response();
    }
	
	public function update_comment(StoreSharedCommentPost $request, $id)
    {
        $comment = \App\Model\Comment::findOrFail(decode_url($id));
        $comment->comment = $request->get('comment');
        		
		if($comment->save()){
            $this->response['status'] = true;
			$this->response['post_id'] = encode_url($request->post_id);
            $this->response['action'] = 'update_comment';
            $this->response['message'] = lang_message('group_comment_update_success');
        }else{
            $this->response['status'] = false;
            $this->response['message'] = lang_message('group_comment_update_failed');;
        }		
		return $this->response();
    }
	
	public function delete_post($id){
		
		$post = \App\Model\GroupPost::findOrFail(decode_url($id));
		
		if($post->delete()){
			$this->response['status']   = true;
			$this->response['message']  = lang_message('post_delete_success');
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('post_delete_failed');
		}
		return $this->response();
	}
	
	public function delete_post_comment($id){		
		$comment = \App\Model\Comment::findOrFail(decode_url($id));
		
		if($comment->delete()){
			$this->response['status']   = true;
			$this->response['message']  = lang_message('comment_delete_success');
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('comment_delete_failed');
		}
		return $this->response();
	}
	
	public function remove_member(Request $request){
		
		$group_id = decode_url($request->group_id);
		$user_id = decode_url($request->user_id);	
		if(is_admin() || is_group_admin($group_id)){
			$admin_list = GroupUserList::whereNull('deleted_at')->where('group_id',$group_id)->where('is_admin',1);
			if($admin_list->count() > 1){
				GroupUserList::whereNull('deleted_at')->where('group_id',$group_id)->where('user_id',$user_id)->delete();			
				$this->remove_member_notification($user_id, $group_id, $request->group_name);
				$this->response['status']   = true;
				$this->response['message']  = lang_message('remove_group_member_success','username',$request->name);
			}else{
				if(is_group_admin($group_id, $user_id)){
					if(GroupUserList::whereNull('deleted_at')->where('group_id',$group_id)->count() > 1){
						$this->response['status']    = false;
						$this->response['member_id'] = $user_id;
						$this->response['member_name'] = \App\Model\User::findOrFail($user_id)->full_name;
						$this->response['group_name']= $request->group_name;
						$this->response['message']   = lang_message('select_any_one_as_admin');
					}else{
						$this->response['status']   = false;
						$this->response['message']  = lang_message('atleast_one_member_reuqired');
					}
				}else{
					if(GroupUserList::whereNull('deleted_at')->where('group_id',$group_id)->where('user_id',$user_id)->delete()){
						$this->remove_member_notification($user_id, $group_id, $request->group_name);
						$this->response['status']   = true;
						$this->response['message']  = lang_message('remove_group_member_success','username',$request->name);
					}else{
						$this->response['status']   = false;
					}
				}
			}
		}else{
			$this->response['status'] = false;
			$this->response['message'] = lang_message('unauthorized_access');
		}		
		return $this->response();
	}

	private function remove_member_notification($user_id, $group_id, $group_name){
		if($user_id != user_id()){
			$user = User::findOrFail($user_id);
			if($user){	
				//Email Notification
				\Illuminate\Support\Facades\Mail::to([['name'=>"'".$user->full_name."'",'email'=>$user->email]])->send(new \App\Mail\GroupMemberRemoveEmail(['user_name'=>$user->full_name,'removed_name'=>auth()->user()->full_name,'group_id'=>$group_id,'group_name'=>$group_name]));
				
				//Web notification
				\Notification::send($user, new \App\Notifications\GroupMemberRemoveNotification(['group_id'=>$group_id,'group_name'=>$group_name]));
			}
		}
	}
	
	public function leave_group(Request $request, $id){
		$admin_list = GroupUserList::whereNull('deleted_at')->where('group_id',decode_url($id))->where('is_admin',1);
		$group = Group::findOrFail(decode_url($id));
			if($admin_list->count() > 1){
				GroupUserList::whereNull('deleted_at')->where('group_id',decode_url($id))->where('user_id',user_id())->delete();
				$this->response['status']   = true;				
				$this->response['message']  = __('message.leaved_group_success');
				$this->leave_member_notification(decode_url($id), $request->group_name);
				
				if($group->visibility == 'private' && !is_admin())
				$this->response['redirect'] = route('groups.index');
			}else{
				if(is_group_admin(decode_url($id), user_id())){
					if(GroupUserList::whereNull('deleted_at')->where('group_id',decode_url($id))->count() > 1){
						$this->response['status']    = false;
						$this->response['member_id'] = user_id();
						$this->response['member_name'] = "You";
						$this->response['group_name']= $request->group_name;
						$this->response['message']   = lang_message('select_any_one_as_admin');
					}else{
						$this->response['status']   = false;
						$this->response['message']  = lang_message('atleast_one_member_reuqired');
					}
				}else{
					GroupUserList::whereNull('deleted_at')->where('group_id',decode_url($id))->where('user_id',user_id())->delete();
					$this->response['status']   = true;
					$this->response['message']  = lang_message('leaved_group_success');
					$this->leave_member_notification(decode_url($id), $request->group_name);
					
					if($group->visibility == 'private' && !is_admin())
					$this->response['redirect'] = route('groups.index');
				}
			}
		return $this->response();
	}
	
	//Function to send member leave notification to all group members
	//Input : group name and id
	//Output: NA
	private function leave_member_notification($group_id, $group_name){
		//Member leave web notification to the Group Members
		$user_ids = GroupUserList::whereNull('deleted_at')->where(['group_id'=>$group_id])->where('user_id','!=',user_id())->pluck('user_id');
		$users = User::whereIn('id',$user_ids)->get();
		\Notification::send($users, new \App\Notifications\GroupMemberLeaveNotification(['group_id'=>$group_id, 'group_name' =>$group_name]));
	}
}
