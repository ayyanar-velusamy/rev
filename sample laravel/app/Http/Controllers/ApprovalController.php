<?php

namespace App\Http\Controllers;

use App\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

use App\Http\Requests\StoreApprovalPost;

use App\Mail\MilestoneApproveEmail;
use App\Mail\MilestoneRejectEmail;

use App\Notifications\MilestoneApproveNotification;
use App\Notifications\MilestoneRejectNotification;

use App\Model\Approval;
use App\Model\User;

class ApprovalController extends BaseController
{	

	use Authorizable;
	
	Public function __construct(){
		parent::__construct();
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
		if(isset($request->requested_by)){
			$condition['field'] = 'a.created_by';
			$condition['condition'] = '=';
			$condition['value'] = $request->requested_by;
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
		if(isset($request->requested_date)){
			$condition['field'] = 'a.created_at';
			//$condition['value'] = parseDateRange($request->requested_date);
			$requested_date = json_decode($request->requested_date,true); 
			$condition['value'] = [$requested_date['start'].' 00:00:00', $requested_date['end'].' 23:59:59'];
			$whereArray['between'][] = $condition;
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
	
	public function ajax_list(Request $request)
    {
		$data = $whereArray = array();
		
		if(!is_admin()){
			$whereArray[0]['field'] = 'm.approver_id';
			$whereArray[0]['condition'] = '=';
			$whereArray[0]['value'] = user_id();
		}
		
		$approvals = DB::table('approvals as a');
		$approvals->join('milestones as m','m.id','=','a.milestone_id');
		$approvals->join('journeys as j','j.id','=','m.journey_id');		
		$approvals->join('content_types as ct','ct.id','=','m.content_type_id');
		$approvals->join('users as u','u.id','=','m.created_by');
		$approvals->join('milestone_assignments as ma','ma.milestone_id','=','a.milestone_id','left');		        
		$approvals->where('ma.status','!=','revoked');
		$approvals->whereNull('m.deleted_at');
		$approvals->select(['a.*','a.id as approval_id','a.status as approval_status','a.created_at as requested_date','j.journey_name','m.type','m.type_ref_id','m.title','m.difficulty','u.id as user_id','ct.name as content_type',DB::raw('CONCAT(u.first_name," ", u.last_name) as requested_by'),DB::raw('SUM(m.price) as price'),DB::raw(
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
				$query->where('m.title', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('j.journey_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('m.difficulty', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('u.first_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('u.last_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('ct.name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('a.status', 'LIKE', '%'.$search_for.'%');
				$query->orWhere(DB::raw("DATE_FORMAT(a.created_at, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
			});			
		}
		$approvals->groupBy('a.id');
		$approvals->orderBy('a.id', 'DESC');
		//echo $approvals->toSql(); exit;
		$approvalData = $approvals->get();
		//pr($approvalData,1);
		foreach($approvalData as $key => $row){
		   $action = "";
		   $expand ="";
		   
		   $action .='<a title="View" onclick="milstoneView('."'".encode_url($row->approval_id)."'".','."'".$row->status."'".')" class="btn btn-blue">View</a>';
			
			if($this->user->hasPermissionTo('approval_approvals')){
				
				if($row->approval_status != 'approved'){
					$expand .='<li><a title="Approve" onclick="milstoneApprove('."'".encode_url($row->approval_id)."'".','."'".$row->status."'".','."'".$row->title."'".')" class="btn btn-green">Approve</a></li>';
				}
				if($row->approval_status != 'rejected'){
					$expand .='<li><a title="Reject" onclick="milstoneReject('."'".encode_url($row->approval_id)."'".','."'".$row->status."'".','."'".$row->title."'".')" class="btn btn-red">Reject</a></li>';
				}
			}
			
			if((strpos($row->assigned_status,'completed') === false) && $row->assigned_status !='revoked'){
				$action .= '<span class="expand-dot"><i class="icon-Expand animation " title="More"></i><div class="btn-dropdown"> <ul class="list-unstyled">'.$expand.'</ul> </div></span>';
			}
					
			if($row->user_id == user_id()){
				$requested_by = __('lang.my_self');  
		    }else{
				$requested_by = ucfirst($row->requested_by);
		    }
			
			if($row->type == 'user'){
				if($row->type_ref_id == user_id()){
					$requested_for = __('lang.my_self');
				}else{
					$requested_for = ucfirst($row->requested_for); 
				}
		    }else{
				$type = ucfirst($row->type);
				$requested_for = ucfirst($row->requested_for)."<p><span class='".$type."'>(".$type.")</span></p>";
		    }
		   
           $data[$key]['id']        	= ''; 
		   $data[$key]['price'] 		= '$'.$row->price;//milestone_approval_price($row->milestone_id);
		   $data[$key]['journey_name']	= ucfirst($row->journey_name); 
		   $data[$key]['title']			= ucfirst($row->title); 
		   $data[$key]['difficulty']	= ucfirst($row->difficulty); 
		   $data[$key]['status']		= ucfirst($row->approval_status); 
		   $data[$key]['requested_by']	= $requested_by;
           $data[$key]['requested_for'] = $requested_for;
           $data[$key]['content_type']  = ucfirst($row->content_type);
		   $data[$key]['created_at'] 	= get_date($row->requested_date); 		   
		   $data[$key]['action']    	= $action; 
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
		$content_types  = \App\Model\ContentType::whereStatus('active')->orderBy('name','asc')->get();
		
		$milestones 	= Approval::milestones();
		
		$requested_by  	= Approval::requested_by()->unique('user_id');
		
		$requested_for 	= Approval::requested_for_grouped();
		
		$journeys 		= Approval::journeys()->unique('journey_name');
		
        return view('approval_management.list',compact('journeys','content_types','milestones','requested_by','requested_for'));
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
     * @param  \App\Model\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function show(Approval $approval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function edit(Approval $approval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Approval $approval)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Approval  $approval
     * @return \Illuminate\Http\Response
     */
    public function destroy(Approval $approval)
    {
        //
    }
	
	
	//get requested milestone details
	public function get_requested_milestone(Request $request, $id){
				
		$milestone = Approval::join('milestones as m', 'm.id', '=', 'approvals.milestone_id')
		->join('journeys as j', 'j.id', '=', 'm.journey_id')
		->join('users as u', 'u.id', '=', 'm.approver_id')
		->join('users as u1', 'u1.id', '=', 'approvals.created_by')
		->where('approvals.id', '=', decode_url($id))
		->select(
		'approvals.created_at as requested_date',
		'approvals.comment as approval_comment',
		'approvals.status as approval_status',
		'j.status as journey_status',
		'j.journey_name',
		'm.*',
		DB::raw('(SELECT GROUP_CONCAT(DISTINCT status) FROM milestone_assignments WHERE milestone_id = approvals.milestone_id) as assigned_status'),
		DB::raw('CONCAT(u.first_name, " ", u.last_name) as approver'),
		DB::raw('CONCAT(u1.first_name," ", u1.last_name) as requested_by'),
		DB::raw(
		'(CASE WHEN m.type = "user" 
		THEN (SELECT CONCAT(first_name," ", last_name) FROM users WHERE id = m.type_ref_id)
		WHEN m.type = "group"
		THEN (SELECT group_name FROM groups WHERE id = m.type_ref_id)
		WHEN m.type = "grade" 
		THEN (SELECT node_name FROM organization_charts WHERE id = m.type_ref_id)
		ELSE null
		END) as requested_for'
		))->get();
		$milestone_details = $milestone->first();
		$milestone_details->type_ref_id = encode_url($milestone_details->type_ref_id);
		$this->response['status']   = true;
		$this->response['message']  = lang_message('get_requested_milestone_success');
		$this->response['data'] 	= $milestone->first();
	
		return $this->response();
	}
	
	//Function to Approve / Reject the paid milestone
	//Input : Request data
	//Output : status
	public function status(StoreApprovalPost $request, $id){
		
		$approval = Approval::findOrFail(decode_url($id));
		
		if($approval){	
			$approver_id = $approval->milestone()->approver_id;
			if(is_admin() || ($approver_id && $approver_id === user_id())){
					
				if($approval->assignment_status()->first()->status != 'completed'){			
				
					if($request->status == $approval->status){
						$this->response['status']   = false;
						if($request->status == 'approved'){
							$this->response['message']  = lang_message('milestone_approved_already','milestone',$request->name);
						}else{
							$this->response['message']  = lang_message('milestone_rejected_already','milestone',$request->name);
						}
					}else{			
						$approval->status  		= $request->status;
						$approval->comment 		= $request->comment;
						$approval->updated_by 	= user_id();
						
						$notify_users = User::where('id', $approval->creator()->id)->get();
						
						if($approval->save()){
							$approval->title 	  = $approval->milestone()->title;
							$approval->journey_id  = $approval->milestone()->journey_id;
							$approval->milestone_id = $approval->milestone()->id;

							if($request->status == 'approved'){
								
								//Milestone Approved database notification
								if($notify_users->first()->id != user_id())
								Notification::send($notify_users, new MilestoneApproveNotification($approval));
								
								//Milestone Approved mail notification
								if($notify_users->first()->id != user_id())
								Mail::to($approval->creator()->email)->send(new MilestoneApproveEmail($approval));
								$this->response['message']  = lang_message('milestone_approved_success','milestone',$request->name);
							}else{
								
								//Milestone Rejected database notification
								if($notify_users->first()->id != user_id())
								Notification::send($notify_users, new MilestoneRejectNotification($approval));
								
								//Milestone Rejected mail notification
								if($notify_users->first()->id != user_id())
								Mail::to($approval->creator()->email)->send(new MilestoneRejectEmail($approval));
								$this->response['message']  = lang_message('milestone_rejected_success','milestone',$request->name);
							}
							$this->response['status']   = true;
						}else{
							$this->response['status']   = false;
							$this->response['message']  = lang_message('something_went_wrong');
						}
					}
				}else{
					$this->response['status']   = false;
					$this->response['message']  = lang_message('milestone_completed_already','milestone',$request->name);
				}
			}else{
				$this->response['status']   = false;
				$this->response['message']  = lang_message('unauthorized_access');
			}
		}else{
				$this->response['status']   = false;
				$this->response['message']  = lang_message('approval_not_send');
		}
		return $this->response();
	}
}
