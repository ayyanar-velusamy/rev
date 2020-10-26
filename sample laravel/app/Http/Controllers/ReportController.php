<?php
namespace App\Http\Controllers;
use App\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends BaseController
{
	use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//*******user activity filter start *********
		$point_filter = \App\Model\User::join(DB::raw('(SELECT ma.user_id, COUNT(DISTINCT CONCAT(m.id,ma.user_id)) as completed_milestone_count, COALESCE(SUM(ma.point),0) as points_earned FROM milestone_assignments as ma LEFT JOIN  milestones as m ON m.id = ma.milestone_id WHERE ma.status = "completed" GROUP BY ma.user_id) as rate'),'rate.user_id','=','users.id','left')->whereNull('users.deleted_at')->select('rate.completed_milestone_count','rate.points_earned')->get();
		
		$journey_count_filter = \App\Model\User::join(DB::raw('(SELECT pjv.user_id, COALESCE(COUNT(DISTINCT pjv.journey_id),0) as total_journey_count, SUM(CASE WHEN pjv.complete_percentage = 100 THEN 1 ELSE 0 END) as completed_journey_count FROM passport_journey_view as pjv GROUP BY pjv.user_id) as j'),'j.user_id','=','users.id','left')->whereNull('users.deleted_at')->select('j.total_journey_count','j.completed_journey_count')->orderBy('total_journey_count','asc')->get();
		
		$user_filter = \App\Model\User::whereNull('deleted_at')->get();		
		//*******user activity filter end *********
		
		
		$groups = \App\Model\Group::select(['id','group_name'])->orderBy('group_name','asc')->get();		
		
		//All Group creator list
		$group_created_by = \App\Model\Group::leftjoin('users','users.id','=','groups.created_by')
		->select('users.id as user_id',DB::raw('CONCAT(users.first_name," ",users.last_name) as created_name'))->orderBy('created_name','asc')->get()->unique('user_id');		
	
		//Group wise members Count
		$group_member_count = \App\Model\GroupUserList::whereNull('group_user_lists.deleted_at')
		->join('groups','groups.id','=','group_user_lists.group_id')->whereNull('groups.deleted_at')
		->select(DB::raw('COUNT(*) as member_count'))		
		->groupBy('group_id')->orderBy('member_count','asc')->get()
		->unique('member_count')->pluck('member_count','member_count');
		
		//Group wise admin Count
		$group_admin_count = \App\Model\GroupUserList::whereNull('group_user_lists.deleted_at')
		->join('groups','groups.id','=','group_user_lists.group_id')->whereNull('groups.deleted_at')
		->where('group_user_lists.is_admin',1)
		->select(DB::raw('COUNT(*) as member_count'))		
		->groupBy('group_id')->orderBy('member_count','asc')->get()
		->unique('member_count')->pluck('member_count','member_count');
 
		//Group wise journey Count
		$group_journey_count = \App\Model\Journey::whereType('group')->whereNull('deleted_at')
		->select(DB::raw('COUNT(*) as journey_count'))
		->groupBy('type_ref_id')->orderBy('journey_count','asc')->get()
		->unique('journey_count')->pluck('journey_count','journey_count');
		
		//Group wise Milestone Count
		$group_milestone_count = \App\Model\Milestone::whereType('group')->whereNull('deleted_at')
		->select(DB::raw('COUNT(*) as milestone_count'))
		->groupBy('type_ref_id')->orderBy('milestone_count','asc')->get()
		->unique('milestone_count')->pluck('milestone_count','milestone_count');
		
		
		$tempcheck_assigned_filter = \App\Model\TempcheckAssignment::join('users','users.id','=','tempcheck_assignments.created_by')->select(['users.id as user_id','users.first_name','users.last_name'])->orderBy('users.first_name','asc')->groupBy('users.id')->get();
		
		$tempcheck_assignee_filter = \App\Model\TempcheckAssignment::join('users','users.id','=','tempcheck_assignments.user_id')->where('tempcheck_assignments.created_by',user_id())->select(['users.id as user_id','users.first_name','users.last_name'])->orderBy('users.first_name','asc')->groupBy('users.id')->get();
		
		$temp_rating_filter = \App\Model\Tempcheck::join(DB::raw('(SELECT user_id, created_by, tempcheck_id, AVG(rating) as rating FROM tempcheck_assignments Group by tempcheck_id,user_id) as assignment'),'assignment.tempcheck_id','=','tempchecks.id')->groupBy('tempchecks.id')->select(['assignment.rating'])->orderBy('assignment.rating','asc')->get();
		
		$temp_question_filter = \App\Model\Tempcheck::select(['question'])->orderBy('question','asc')->get();
		
		
		$content_types  = \App\Model\ContentType::whereStatus('active')->orderBy('name','asc')->get();
		
		$approval_milestones 		= \App\Model\Approval::milestones();
		
		$approval_requested_by  	= \App\Model\Approval::requested_by()->unique('user_id');
		
		$approval_requested_for 	= \App\Model\Approval::requested_for_grouped();
		
		$approval_journeys 			= \App\Model\Approval::journeys()->unique('journey_name');
		
		$approval_by_price 			= \App\Model\Approval::filter_by_price()->unique('price');
		
		$approval_approvers 		= \App\Model\Approval::approvers();
		
		$grade_filter = \App\Model\OrganizationChart::all();
		
		$role_filter = \App\Model\Role::whereNull('deleted_at')->get();
		
        return view('report_management.report_list',compact('user_filter','point_filter','groups','group_created_by','group_member_count','group_admin_count','group_journey_count','group_milestone_count','tempcheck_assigned_filter','tempcheck_assignee_filter','approval_journeys','approval_by_price','approval_approvers','approval_requested_for','approval_requested_by','approval_milestones','content_types','journey_count_filter','grade_filter','role_filter','temp_rating_filter','temp_question_filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

	//Datatable conditional filters 
	private function userActivityReprotfilterCondition(Request $request, $whereArray){
		
		if(isset($request->first_name)){
			$condition['field'] = 'users.first_name';
			$condition['condition'] = '=';
			$condition['value'] = $request->first_name;
			$whereArray[] = $condition;
		}

		if(isset($request->last_name)){
			$condition['field'] = 'users.last_name';
			$condition['condition'] = '=';
			$condition['value'] = $request->last_name;
			$whereArray[] = $condition;
		}
		
		if(isset($request->last_login_at)){
			$condition['field'] = 'users.last_login_at';
			$last_login_at = json_decode($request->last_login_at,true); 
			$condition['value'] = [$last_login_at['start'].' 00:00:00', $last_login_at['end'].' 23:59:59'];
			$whereArray['between'][] = $condition;
		}
		if(isset($request->points_earned)){
			$condition['field'] = 'rate.points_earned';
			$condition['condition'] = '=';
			$condition['value'] = ($request->points_earned == 0) ? null : $request->points_earned;
			$whereArray[] = $condition;
		}

		if(isset($request->completed_milestone_count)){
			$condition['field'] = 'rate.completed_milestone_count';
			$condition['condition'] = '=';
			$condition['value'] = ($request->completed_milestone_count == 0) ? null : $request->completed_milestone_count;
			$whereArray[] = $condition;
		}
		
		if(isset($request->total_journey_count)){
			$condition['field'] = 'j.total_journey_count';
			$condition['condition'] = '=';
			$condition['value'] = ($request->total_journey_count == 0) ? null : $request->total_journey_count;
			$whereArray[] = $condition;
		}
		
		if(isset($request->completed_journey_count)){
			$condition['field'] = 'j.completed_journey_count';
			$condition['condition'] = '=';
			$condition['value'] = $request->completed_journey_count;
			$whereArray[] = $condition;
		}

		return $whereArray;
	}
	
	public function user_activity_report(Request $request)
    {
		
		$data = $whereArray = array();
				
		$activity_collection = \App\Model\User::join(DB::raw('(SELECT ma.user_id, COUNT(DISTINCT CONCAT(m.id,ma.user_id)) as completed_milestone_count, COALESCE(SUM(ma.point),0) as points_earned FROM milestone_assignments as ma LEFT JOIN  milestones as m ON m.id = ma.milestone_id WHERE ma.status = "completed" GROUP BY ma.user_id) as rate'),'rate.user_id','=','users.id','left')
		->join(DB::raw('(SELECT pjv.user_id, COALESCE(COUNT(DISTINCT pjv.journey_id),0) as total_journey_count, SUM(CASE WHEN pjv.complete_percentage = 100 THEN 1 ELSE 0 END) as completed_journey_count FROM passport_journey_view as pjv GROUP BY pjv.user_id) as j'),'j.user_id','=','users.id','left');		
		$activity_collection->whereNull('users.deleted_at');
		$activity_collection->select('users.id as user_id','users.image','users.first_name','users.last_name','users.designation','users.last_login_at','rate.completed_milestone_count','rate.points_earned','j.total_journey_count','j.completed_journey_count');
		
		$whereArray = $this->userActivityReprotfilterCondition($request, $whereArray);
				
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){				
				if($key === 'between'){				
					foreach($where as $k=>$v){
						$activity_collection->whereBetween($v['field'],$v['value']);
					}
				}elseif($key === 'FIND_IN_SET'){				
					foreach($where as $k=>$v){
						$activity_collection->whereRaw('FIND_IN_SET('.$v['value'].','.$v['field'].')');
					}
				}
				else{				
					$activity_collection->where($where['field'],$where['condition'],$where['value']);
				}
			} 
		}	

		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$activity_collection->where(function($query) use ($search_for){
				$query->orWhere('users.first_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.last_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.designation', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('rate.points_earned', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('rate.completed_milestone_count', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('j.total_journey_count', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('j.completed_journey_count', 'LIKE', '%'.$search_for.'%');
				$query->orWhere(DB::raw("DATE_FORMAT(users.last_login_at, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
			});				
		}
		
		//echo $activity_collection->toSql(); exit;
		$user_activity = $activity_collection->get();
		//pr($user_activity,1);
		$action = "";
        return datatables()->of($user_activity)->addColumn('first_name', function($row){
			return $row->first_name;
		})->addColumn('last_name', function($row){
			return $row->last_name;
		})->addColumn('last_login', function($row){
			return ($row->last_login_at != "") ? get_date($row->last_login_at) : '-';
		})->addColumn('completed_milestone_count', function($row){
			return ($row->completed_milestone_count != '') ? $row->completed_milestone_count : 0;
		})->addColumn('total_journey_count', function($row){
			return ($row->total_journey_count != '') ? $row->total_journey_count : 0;
		})->addColumn('completed_journey_count', function($row){
			return ($row->completed_journey_count != '') ? $row->completed_journey_count : 0;
		})->addColumn('points_earned', function($row){
			return ($row->points_earned != '') ? $row->points_earned : 0;
		})->make(true);
		
    }

	//Datatable conditional filters 
	private function currentUserReprotfilterCondition(Request $request, $whereArray){
		
		if(isset($request->first_name)){
			$condition['field'] = 'users.first_name';
			$condition['condition'] = '=';
			$condition['value'] = $request->first_name;
			$whereArray[] = $condition;
		}

		if(isset($request->last_name)){
			$condition['field'] = 'users.last_name';
			$condition['condition'] = '=';
			$condition['value'] = $request->last_name;
			$whereArray[] = $condition;
		}
		
		if(isset($request->mobile)){
			$condition['field'] = 'users.mobile';
			$condition['condition'] = '=';
			$condition['value'] = $request->mobile;
			$whereArray[] = $condition;
		}
		
		if(isset($request->email)){
			$condition['field'] = 'users.email';
			$condition['condition'] = '=';
			$condition['value'] = $request->email;
			$whereArray[] = $condition;
		}
		
		if(isset($request->designation)){
			$condition['field'] = 'users.designation';
			$condition['condition'] = '=';
			$condition['value'] = $request->designation;
			$whereArray[] = $condition;
		}
		
		if(isset($request->role)){
			$condition['field'] = 'role.role_name';
			$condition['condition'] = '=';
			$condition['value'] = $request->role;
			$whereArray[] = $condition;
		}
		
		if(isset($request->grade_id)){
			$condition['field'] = 'grade.grade_id';
			$condition['value'] = $request->grade_id;	
			$whereArray['FIND_IN_SET'][] = $condition;
		}
		
		return $whereArray;
	}
	
	public function current_user_report(Request $request)
    {
		
		$data = $whereArray = array();

		
		$user_collection = \App\Model\User::whereNull('users.deleted_at')
		->join(DB::raw('(SELECT u.user_id, GROUP_CONCAT(org.id) as grade_id, GROUP_CONCAT(org.node_name SEPARATOR "---") as grade_name FROM user_grades as u LEFT JOIN organization_charts as org ON org.id = u.chart_value_id WHERE u.chart_value_id IS NOT NULL GROUP BY u.user_id) as grade'),'grade.user_id','=','users.id','left')
		->join(DB::raw('(SELECT hr.model_id as user_id, hr.role_id, r.name as role_name FROM model_has_roles as hr LEFT JOIN roles as r ON r.id = hr.role_id GROUP BY hr.model_id) as role'),'role.user_id','=','users.id','left');
		
		$whereArray = $this->currentUserReprotfilterCondition($request, $whereArray);
				
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){				
				if($key === 'between'){				
					foreach($where as $k=>$v){
						$user_collection->whereBetween($v['field'],$v['value']);
					}
				}elseif($key === 'FIND_IN_SET'){				
					foreach($where as $k=>$v){
						$user_collection->whereRaw('FIND_IN_SET('.$v['value'].','.$v['field'].')');
					}
				}
				else{				
					$user_collection->where($where['field'],$where['condition'],$where['value']);
				}
			} 
		}	

		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$user_collection->where(function($query) use ($search_for){
				$query->orWhere('users.first_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.last_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.designation','LIKE', '%'.$search_for.'%');
				$query->orWhere('users.mobile', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.email', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('role.role_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('grade.grade_name', 'LIKE', '%'.$search_for.'%');
			});				
		}
		
		//echo $peer_collection->toSql(); exit;
		$peers = $user_collection->get();
		//pr($peers,1);
		$action = "";
        return datatables()->of($peers)->addColumn('action', function($row) use($action) {
			
			$action ='<a href="'.route('users.passport',[encode_url($row->user_id)]).'" title="View" class="btn btn-blue">View Passport</a>';
									
			return $action;
        })->addColumn('first_name', function($row){
			return $row->first_name;
		})->addColumn('last_name', function($row){
			return $row->last_name;
		})->addColumn('email', function($row){
			return $row->email;
		})->addColumn('mobile', function($row){
			return $row->mobile;
		})->addColumn('designation', function($row){
			return ($row->designation != '') ? $row->designation : '-';
		})->addColumn('role', function($row){
			return ucfirst($row->role_name);
		})->addColumn('grade', function($row){
			$grade_name = "";
			$grade = explode('---',$row->grade_name);			
			if($row->grade_name != ""){
				foreach($grade as $key=>$name){
					$grade_name .= '<p><span class="maxname">'.$name.'</span></p>';
				}				
			}else{
				$grade_name = "-";
			}	
			return $grade_name;
		})->make(true);
		
    }

	//Datatable conditional filters 
	private function approvalfilterCondition(Request $request, $whereArray){
		
		if(isset($request->journey_id)){
			$condition['field'] = 'j.id';
			$condition['condition'] = '=';
			$condition['value'] = $request->journey_id;
			$whereArray[] = $condition;
		}		
		if(isset($request->journey_name)){
			$condition['field'] = 'j.journey_name';
			$condition['condition'] = '=';
			$condition['value'] = $request->journey_name;
			$whereArray[] = $condition;
		}		
		if(isset($request->milestone_id)){
			$condition['field'] = 'm.id';
			$condition['condition'] = '=';
			$condition['value'] = $request->milestone_id;
			$whereArray[] = $condition;
		}	

		if(isset($request->milestone_name)){
			$condition['field'] = 'm.title';
			$condition['condition'] = '=';
			$condition['value'] = $request->milestone_name;
			$whereArray[] = $condition;
		}
		
		if(isset($request->requested_by)){
			$condition['field'] = 'a.created_by';
			$condition['condition'] = '=';
			$condition['value'] = $request->requested_by;
			$whereArray[] = $condition;
		}

		if(isset($request->price)){
			$condition['field'] = 'price';
			$condition['condition'] = '=';
			$condition['value'] = $request->price;
			$whereArray[] = $condition;
		}	
		
		if(isset($request->approver_id)){
			$condition['field'] = 'm.approver_id';
			$condition['condition'] = '=';
			$condition['value'] = $request->approver_id;
			$whereArray[] = $condition;
		}		
		
		if(isset($request->requested_for)){
			$con = explode('--',$request->requested_for);
			
			$condition['field'] = 'm.type_ref_id';
			$condition['condition'] = '=';
			$condition['value'] = $con[0];
			$whereArray[] = $condition;
			
			$condition['field'] = 'm.type';
			$condition['condition'] = '=';
			$condition['value'] = $con[1];
			$whereArray[] = $condition;
		}
	
		if(isset($request->status)){
			$condition['field'] = 'a.status';
			$condition['condition'] = '=';
			$condition['value'] = $request->status;
			$whereArray[] = $condition;
		}
		if(isset($request->milestone_type_id)){
			$condition['field'] = 'm.content_type_id';
			$condition['condition'] = '=';
			$condition['value'] = $request->milestone_type_id;
			$whereArray[] = $condition;
		}

		if(!is_admin()){
			$condition['field'] = 'm.approver_id';
			$condition['condition'] = '=';
			$condition['value'] = user_id();
			$whereArray[] = $condition;
		}
		
		return $whereArray;
	}
	
	public function approval_report_list(Request $request)
    {
		$data = $whereArray = array();
		
		$approvals = DB::table('approvals as a');
		$approvals->join('milestones as m','m.id','=','a.milestone_id');
		$approvals->join('journeys as j','j.id','=','m.journey_id');		
		$approvals->join('content_types as ct','ct.id','=','m.content_type_id');
		$approvals->join('users as u','u.id','=','m.created_by');
		$approvals->join('users as u1','u1.id','=','m.approver_id');
		$approvals->join('milestone_assignments as ma','ma.milestone_id','=','a.milestone_id','left');		        
		$approvals->where('ma.status','!=','revoked');
		$approvals->whereNull('m.deleted_at');
		$approvals->select(['a.*','a.id as approval_id','a.status as approval_status','a.created_at as requested_date','j.journey_name','m.type','m.type_ref_id','m.title','m.difficulty','u.id as user_id','ct.name as content_type',DB::raw('CONCAT(u.first_name," ", u.last_name) as requested_by'),'m.approver_id',DB::raw('CONCAT(u1.first_name," ", u1.last_name) as approver_name'),DB::raw('SUM(m.price) as price'),DB::raw(
		'(CASE WHEN m.type = "user" 
		THEN (SELECT CONCAT(first_name," ", last_name) FROM users WHERE id = m.type_ref_id)
		WHEN m.type = "group"
		THEN (SELECT group_name FROM groups WHERE id = m.type_ref_id)
		WHEN m.type = "grade" 
		THEN (SELECT node_name FROM organization_charts WHERE id = m.type_ref_id)
		ELSE null
		END) as requested_for'
		),DB::raw('GROUP_CONCAT(DISTINCT ma.status) as assigned_status')]);
		$whereArray = $this->approvalfilterCondition($request, $whereArray);
		
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){				
				 if($key === 'between'){				
					foreach($where as $k=>$v){
						$approvals->whereBetween($v['field'],$v['value']);
					}
				}else{				
					$approvals->where($where['field'],$where['condition'],$where['value']);
				}
			} 
		}
		
		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$approvals->where(function($query) use ($search_for){
				$query->where('u1.approver_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('j.journey_name', 'LIKE', '%'.$search_for.'%');
				$query->where('m.title', 'LIKE', '%'.$search_for.'%');
				//$query->orWhere('m.difficulty', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('u.first_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('u.last_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('u1.first_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('u1.last_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('ct.name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('a.status', 'LIKE', '%'.$search_for.'%');
			});			
		}
		$approvals->groupBy('a.id');
		$approvals->orderBy('a.id', 'DESC');
		//echo $approvals->toSql(); exit;
		$approvalData = $approvals->get();
		//pr($approvalData,1);
		foreach($approvalData as $key => $row){

			// if($row->user_id == user_id()){
				// $requested_by = __('lang.my_self');  
		    // }else{
				$requested_by = ucfirst($row->requested_by);
		    //}
			
			if($row->type == 'user'){
				// if($row->type_ref_id == user_id()){
					// $requested_for = __('lang.my_self');
				// }else{
					$requested_for = ucfirst($row->requested_for); 
				//}
		    }else{
				$type = ucfirst($row->type);
				$requested_for = ucfirst($row->requested_for)."<p><span class='".$type."'>(".$type.")</span></p>";
		    }
		   
           $data[$key]['id']        	= ''; 
		   $data[$key]['price'] 		= '$'.$row->price;
		   $data[$key]['approver_name']	= ucfirst($row->approver_name); 
		   $data[$key]['journey_name']	= ucfirst($row->journey_name); 
		   $data[$key]['title']			= ucfirst($row->title); 
		   $data[$key]['difficulty']	= ucfirst($row->difficulty); 
		   $data[$key]['status']		= ucfirst($row->approval_status); 
		   $data[$key]['requested_by']	= $requested_by;
           $data[$key]['requested_for'] = $requested_for;
           $data[$key]['content_type']  = ucfirst($row->content_type);
		   $data[$key]['created_at'] 	= get_date($row->requested_date); 		   
	   }
	   return datatables()->of($data)->make(true);
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
		
		if(isset($request->admin_count)){
			$condition['field'] = 'admin.admin_count';
			$condition['condition'] = '=';
			$condition['value'] = ($request->admin_count == 0) ? null : $request->admin_count;	
			$whereArray[] = $condition;			
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
		
		if(isset($request->milestone_count)){
			$condition['field'] = 'milestones.milestone_count';
			$condition['condition'] = '=';
			$condition['value'] = ($request->milestone_count == 0) ? null : $request->milestone_count;
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
	
	public function group_report_list(Request $request)
    {		
		$data = $whereArray = array();
		
		$group_collection = \App\Model\Group::join(DB::raw('(SELECT id, CONCAT(first_name," ",last_name) as created_name FROM users) as created'),'created.id','=','groups.created_by','left')
		->join(DB::raw('(SELECT ml.group_id, COUNT(u.id) as admin_count, GROUP_CONCAT(u.id SEPARATOR "---") as admin_id, GROUP_CONCAT(CONCAT(u.first_name," ",u.last_name) SEPARATOR "---") as admin_name FROM users as u LEFT JOIN group_user_lists as ml ON u.id = ml.user_id WHERE ml.is_admin = 1 AND ml.deleted_at IS NULL GROUP BY ml.group_id) as admin'),'admin.group_id','=','groups.id','left')
		->join(DB::raw('(SELECT type_ref_id as group_id, COUNT(*) as journey_count FROM journeys WHERE type="group" AND deleted_at IS NULL GROUP BY type_ref_id) as journeys'),'journeys.group_id','=','groups.id','left')
		->join(DB::raw('(SELECT type_ref_id as group_id, COUNT(*) as milestone_count FROM milestones WHERE type="group" AND deleted_at IS NULL GROUP BY type_ref_id) as milestones'),'milestones.group_id','=','groups.id','left')
		->join(DB::raw('(SELECT group_id, GROUP_CONCAT(user_id) as group_member_ids , COUNT(user_id) as member_count FROM group_user_lists WHERE deleted_at IS NULL GROUP BY group_id) as members'),'members.group_id','=','groups.id','left');
		
		// if(!is_admin()){
			// $group_collection->whereRaw('(groups.visibility = "public" OR FIND_IN_SET('.user_id().',members.group_member_ids))');
		// }
		
		$group_collection->select('groups.id as group_id','groups.group_name','members.member_count','members.group_member_ids','admin.admin_name','admin.admin_id','groups.created_at','groups.created_by','journeys.journey_count','milestones.milestone_count','created.created_name');
		
		
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
		
		//echo $group_collection->toSql(); exit;
		$groups = $group_collection->get();
	        return datatables()->of($groups)->addColumn('user_count', function($row){
			return ($row->member_count != "") ? $row->member_count : 0;
		})->addColumn('admin_count', function($row){
			return count(explode('---',$row->admin_id));
		})->addColumn('journey_count', function($row){
			return ($row->journey_count != "") ? $row->journey_count : 0;
		})->addColumn('milestone_count', function($row){
			return ($row->milestone_count != "") ? $row->milestone_count : 0;
		})->addColumn('created_by', function($row){
			// if($row->created_by == user_id()){
				// return __('lang.my_self');
			// }else{
				return '<span class="maxname">'.$row->created_name.'</span>';
			//}
		})->addColumn('created_at', function($row){
			return get_date($row->created_at);
		})->make(true);
		
    }
	
	//Datatable conditional filters 
	private function tempcheckfilterCondition(Request $request, $whereArray){
		
		if(isset($request->question)){
			$condition['field'] = 'tempchecks.question';
			$condition['condition'] = '=';
			$condition['value'] = $request->question;
			$whereArray[] = $condition;
		}
		
		if(isset($request->user_id)){
			$condition['field'] = 'assignment.user_id';
			$condition['condition'] = '=';
			$condition['value'] = $request->user_id;
			$whereArray[] = $condition;
		}
		
		if(isset($request->rating)){
			$condition['field'] = 'assignment.rating';
			$condition['condition'] = '=';
			$condition['value'] = $request->rating;
			$whereArray[] = $condition;
		}

		if(isset($request->created_by)){
			$condition['field'] = 'assignment.created_by';
			$condition['condition'] = '=';
			$condition['value'] = $request->created_by;
			$whereArray[] = $condition;
		}
 
		return $whereArray;
	}
	
	public function tempcheck_report_list(Request $request){
		$action ="";
		$data = $whereArray = array();		

		$temp_collection = \App\Model\Tempcheck::join(DB::raw('(SELECT user_id, created_by, tempcheck_id, AVG(rating) as rating FROM tempcheck_assignments Group by tempcheck_id,user_id) as assignment'),'assignment.tempcheck_id','=','tempchecks.id')
		->join(DB::raw('(SELECT id, CONCAT(first_name," ",last_name) as assignee FROM users) as  u1'),'u1.id','=','assignment.user_id')
		->join(DB::raw('(SELECT id, CONCAT(first_name," ",last_name) as assigned_by FROM users) as  u2'),'u2.id','=','assignment.created_by');

		$whereArray = $this->tempcheckfilterCondition($request, $whereArray);
				
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){				
				if($key === 'between'){				
					foreach($where as $k=>$v){
						$temp_collection->whereBetween($v['field'],$v['value']);
					}
				}elseif($key === 'FIND_IN_SET'){				
					foreach($where as $k=>$v){
						$temp_collection->whereRaw('FIND_IN_SET('.$v['value'].','.$v['field'].')');
					}
				}
				else{				
					$temp_collection->where($where['field'],$where['condition'],$where['value']);
				}
			} 
		}	
		
		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$temp_collection->where(function($query) use ($search_for, $request){
				$query->orWhere('u1.assignee', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('u2.assigned_by', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('tempchecks.question', 'LIKE', '%'.$search_for.'%');
				//$query->orWhere(DB::raw("DATE_FORMAT(due_date, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
			});			
		}
	
		$tempchecks = $temp_collection->select(['u1.id as user_id','tempchecks.question','u1.assignee','u2.assigned_by','assignment.rating','tempchecks.id as tempcheck_id'])->get();
		
        return datatables()->of($tempchecks)->addColumn('assignee', function($row){
			return $row->assignee;
		})->addColumn('assigned_by', function($row){
			return $row->assigned_by;
		})->addColumn('question', function($row){
			return $row->question;
		})->addColumn('rating', function($row){
			return (($row->rating == '') ? '--' : round($row->rating,2)."/10");
		})->make(true);
	}
}
