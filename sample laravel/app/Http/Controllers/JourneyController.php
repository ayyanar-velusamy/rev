<?php
namespace App\Http\Controllers;

use App\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Model\Journey;
use App\Model\JourneyType;
use App\Model\JourneyAssignment;
use App\Model\Milestone;
use App\Model\MilestoneAssignment;
use App\Model\Content;
use App\Model\ContentType;
use App\Model\User;
use App\Model\Group;
use App\Model\GroupUserList;
use App\Model\OrganizationChart;
use App\Model\UserGrade;
use App\Model\Approval;

use App\Http\Requests\StoreJourneyPost;
use App\Http\Requests\UpdateJourneyPut;
use App\Http\Requests\StoreMilestonePost;
use App\Http\Requests\UpdateMilestonePut;
use App\Http\Requests\StroeJourneyAssignPost;
use App\Http\Requests\StroeJourneyRatingPost;
use App\Http\Requests\StoreDuplicateJourneyPost;
use App\Http\Requests\StoreMilestoneCompletePost;
use App\Http\Requests\StoreMilestoneNotePost;
use App\Http\Requests\StoreAddToMyJourneyPost;

class JourneyController extends BaseController
{  
	
	use Authorizable;
	
	Public function __construct(){
		parent::__construct();
	}
		
	public function ajax_list(Request $request)
    {			
		if($request->table_name =="predefinedLearningJourneyList"){
			return $this->predefined_learning_journey_list($request);
		}elseif($request->table_name == "myLearningJourneyList"){
			return $this->my_learning_journey_list($request);
		}else{
			return $this->assigned_learning_journey_list($request);
		}				
    }
	
	//Assigned learning journey milestone ajax list	
	public function milestone_list(Request $request)
    {
		$journey_id = decode_url($request->journey_id);
		
		if($request->table_name =="prdefinedMilestoneList"){	
			return $this->prdefined_milestone_list($journey_id);
		}elseif($request->table_name =="assignedMilestoneList"){
			return $this->assigned_milestone_list($journey_id, $request->category, $request->assignment_type);
		}elseif($request->table_name =="passportMilestoneList"){			
			return $this->passport_milestone_list($journey_id, $request->user_id);
		}else{
			return $this->my_journey_milestone_list($journey_id);
		}	
    }
	
	//Function to render Journey List filter Options page
	//Input : NA
	//Output : NA
	public function journey_list_filter($journey_list){
		
		$total_assignee = $active_assignee = array();		
		$journeys 	= DB::table('journey_assignment_view')->whereNotIn('journey_type_id', [4,5])->select('journey_id as id','journey_name','journey_type_id','user_id','assigned_by','assigned_status',DB::raw('CONCAT(journey_id,"--",COALESCE(user_id,0),"--",journey_type_id,"--",journey_name) as select_id'))->orderBy('journey_name','asc')->get()->unique('select_id');

		$assigned_by = DB::table('journey_assignment_view')->whereNotNull('assigned_by')->whereNotIn('journey_type_id',[2,5])->select('user_id','journey_type_id','assigned_by','assigned_status','assigned_name')->orderBy('assigned_name','asc')->get()->unique();
		
		$created_by = DB::table('journey_assignment_view')->select('journey_type_id','created_by','assigned_status','created_name')->orderBy('created_name','asc')->get()->unique();
			
		$milestone_counts = DB::table('journey_assignment_view')->whereNotNull('user_id')->where('journey_type_id','!=',2)->select('user_id','created_by','assigned_status','milestone_count')->orderBy('milestone_count','asc')->get()->unique();
		
		$pre_milestone_counts = DB::table('journey_assignment_view')->where('journey_type_id',2)->select('milestone_count')->orderBy('milestone_count','asc')->get()->unique('milestone_count');
		
		$assigned_group_list = GROUP::select('id','group_name')->orderBy('group_name','asc')->get();
		
		$pdj_assignment_counts = DB::table('journey_assignment_view as jav')->join(DB::raw('(SELECT journey_parent_id, COUNT(DISTINCT user_id) as total_assignee, COUNT(DISTINCT (CASE WHEN complete_percentage = 100 THEN null ELSE user_id END)) as active_assignee FROM journey_assignment_view group by journey_parent_id) as jav1'),'jav.journey_id','=','jav1.journey_parent_id','left')->select(['total_assignee','active_assignee'])
		->where('jav.journey_type_id',2)->get();

		foreach($pdj_assignment_counts as $pdj){
			if($pdj->total_assignee == ""){
				array_push($total_assignee,0);
				array_push($active_assignee,0);
			}else{
				array_push($total_assignee,$pdj->total_assignee);
				array_push($active_assignee,$pdj->active_assignee);
			}
		}
		$total_assignees = array_unique($total_assignee);
		$active_assignees = array_unique($active_assignee);
		
		$assigned_to = Journey::assigned_to_grouped();
        return view('journey_management.'.$journey_list.'_list_filter',compact('journeys','assigned_by','milestone_counts','pre_milestone_counts','assigned_to','created_by','total_assignees','active_assignees','assigned_group_list'));
	}
	
			
    //Function to render Journey List page
	//Input : NA
	//Output : NA
    public function index()
    {
		$total_assignee = $active_assignee = array();		
		$journeys 	= DB::table('journey_assignment_view')->whereNotIn('journey_type_id', [4,5])->select('journey_id as id','journey_name','journey_type_id','user_id','assigned_by','assigned_status',DB::raw('CONCAT(journey_id,"--",COALESCE(user_id,0),"--",journey_type_id,"--",journey_name) as select_id'))->orderBy('journey_name','asc')->get()->unique('select_id');

		$assigned_by = DB::table('journey_assignment_view')->whereNotNull('assigned_by')->whereNotIn('journey_type_id',[2,5])->select('user_id','journey_type_id','assigned_by','assigned_status','assigned_name')->orderBy('assigned_name','asc')->get()->unique();
		
		$created_by = DB::table('journey_assignment_view')->select('journey_type_id','created_by','assigned_status','created_name')->orderBy('created_name','asc')->get()->unique();
			
		$milestone_counts = DB::table('journey_assignment_view')->whereNotNull('user_id')->where('journey_type_id','!=',2)->select('user_id','created_by','assigned_status','milestone_count')->orderBy('milestone_count','asc')->get()->unique();
		
		$pre_milestone_counts = DB::table('journey_assignment_view')->where('journey_type_id',2)->select('milestone_count')->orderBy('milestone_count','asc')->get()->unique('milestone_count');
		
		$assigned_group_list = GROUP::select('id','group_name')->orderBy('group_name','asc')->get();
		
		$pdj_assignment_counts = DB::table('journey_assignment_view as jav')->join(DB::raw('(SELECT journey_parent_id, COUNT(DISTINCT user_id) as total_assignee, COUNT(DISTINCT (CASE WHEN complete_percentage = 100 THEN null ELSE user_id END)) as active_assignee FROM journey_assignment_view group by journey_parent_id) as jav1'),'jav.journey_id','=','jav1.journey_parent_id','left')->select(['total_assignee','active_assignee'])
		->where('jav.journey_type_id',2)->get();

		foreach($pdj_assignment_counts as $pdj){
			if($pdj->total_assignee == ""){
				array_push($total_assignee,0);
				array_push($active_assignee,0);
			}else{
				array_push($total_assignee,$pdj->total_assignee);
				array_push($active_assignee,$pdj->active_assignee);
			}
		}
		$total_assignees = array_unique($total_assignee);
		$active_assignees = array_unique($active_assignee);
		
		$assigned_to = Journey::assigned_to_grouped();
        return view('journey_management.journey_list',compact('journeys','assigned_by','milestone_counts','pre_milestone_counts','assigned_to','created_by','total_assignees','active_assignees','assigned_group_list'));
    }

	//Function to render Journey create page
	//Input : NA
	//Output : NA
    public function predefine_journey_create()
    {
		$approvers = User::permission('approval_approvals')->whereNull('deleted_at')->get(); 
		$journey_types = JourneyType::whereStatus('active')->get(); 
		$content_types = ContentType::whereStatus('active')->get();
		$journey_type_id = 2;
        return view('journey_management.journey_add',compact('journey_type_id','journey_types','content_types','approvers'));
    }
		
    //Function to render Journey create page
	//Input : NA
	//Output : NA
    public function create($id="")
    {
		if($id != ""){
			$journey = Journey::findOrFail(decode_url($id));
			$journey_type_id = $journey->journey_type_id;
		}else{
			$journey = [];
			$journey_type_id = 1;
		}	
		$approvers = User::permission('approval_approvals')->whereNull('deleted_at')->get(); 
		$journey_types = JourneyType::whereStatus('active')->get(); 
		$content_types = ContentType::whereStatus('active')->get(); 
		
        return view('journey_management.journey_add',compact('journey','journey_type_id','journey_types','content_types','approvers'));
    }

    //Function to store Journey 
	//Input : request
	//Output : status/message
    public function store(StoreJourneyPost $request)
    {
		if(isset($request->primary_id) && $request->primary_id != ""){
			$journey = Journey::findOrFail(decode_url($request->primary_id));
			$journey_status = $journey->status;
		}else{
			$journey = new Journey();
			$journey_status = 'draft';
		}
		
		if($request->status == 'active' && $journey->milestones->count() <= 0){
			$this->response['status']      	  = false;
			$this->response['journey_status'] = $journey->status;
			$this->response['message']     	  = lang_message('atlest_one_milestone_required');
		}else{		
			$journey->journey_name   		= $request->journey_name;
			$journey->journey_type_id  		= $request->journey_type_id;
			$journey->visibility 			= $request->journey_visibility;
			$journey->journey_description 	= $request->journey_description;
			$journey->status 				= $request->status; //saved as draft
			$journey->read 					= ($request->journey_read != "") ? $request->journey_read : 'optional';
			$journey->created_by 			= user_id();
			
			if($request->journey_type_id == 1){
				$journey->type_ref_id		= user_id();
			}
			 
			if($journey->save()){
				
				//Assign my learning journey current user itself 
				if($journey->journey_type_id == 1){
					$this->assign_journey($journey->id, $journey->journey_name);
				}
				
				//Send milestones for approval 
				if($journey->journey_type_id == 1 && $journey->status != $journey_status && $journey->status === 'active'){
					$this->approval_request($journey);
				}
				
				$this->response['status']  		  = true;
				$this->response['save_type']      = $request->save_type;
				$this->response['journey_status'] = $journey->status;
				$this->response['visibility'] 	  = $journey->visibility;
				$this->response['read'] 	  	  = $journey->read;
				$this->response['journey_type_id']= $journey->journey_type_id;
				$this->response['journey_id']     = encode_url($journey->id);
				$this->response['message']  	  = lang_message('journey_'.$journey->status.'_success','journey',$journey->journey_name);
			}else{
				$this->response['status']   = false;
				$this->response['message']  = lang_message('journey_'.$request->status.'_failed','journey',$request->journey_name);
			}
		}
		return $this->response();
    }
	
	
	//Function to assign journey as my learning journey
	//Input : journey_id 
	//Output : status/message
	private function assign_journey($journey_id, $journey_name){		
		$this->response = assign_journey([['ref_id'=>user_id(),'user_id'=>user_id()]],$journey_id, $journey_name);
		return true;
	}
	
	//Function to send journey milestones for approval
	//Input : journey_id 
	//Output : status/message
	private function approval_request(Journey $journey){
		if($journey){
			if($journey->milestones){
				$milestones = $journey->milestones()->wherePaymentType('paid')->get();
				if($milestones->count() > 0){
					foreach($milestones as $milestone){
						approval_request($milestone->id);
					}
				}
			}			
		}
		return true;
	}	
	
	//Function to store the milestone 
	//Input : request
	//Output : status/message
	public function store_milestone(StoreMilestonePost $request)
    {
		if($journey_id = decode_url($request->journey_id)){
			
			$journey = Journey::findOrFail($journey_id);
						
			$milestone = new Milestone();
			$milestone->journey_id 		= $journey_id;
			$milestone->title           = $request->title;
			$milestone->content_type_id = $request->content_type_id;
			$milestone->provider  	    = $request->provider;
			$milestone->url  	   		= $request->url;
			$milestone->approver_id		= $request->approver_id;
			$milestone->price  	   	    = $request->price;
			$milestone->difficulty  	= $request->difficulty;
			$milestone->description  	= $request->description;
			$milestone->read  			= ($request->read != "") ? $request->read : 'optional';
			$milestone->tags  	   	   	= ($request->tags != "") ? implode(",",$request->tags) : "";
			$milestone->length  	   	= $request->get('length',0);
			$milestone->start_date  	= ($request->start_date != "") ? get_db_date($request->start_date) : get_db_date();
			$milestone->end_date  	   	= get_db_date($request->end_date);
			$milestone->visibility 		= $request->visibility;
			$milestone->payment_type   	= $request->payment_type;
			$milestone->created_by 	    = user_id();
			
			//if my learning than add ref type and id
			if($journey->journey_type_id == 1){				
				$milestone->type		 	= 'user';
				$milestone->type_ref_id		= user_id();
			}
			
			//if assigned learning journey than add ref type and id
			if($journey->journey_type_id == 3){				
				$milestone->type		 	= $journey->type;
				$milestone->type_ref_id		= $journey->type_ref_id;
			}
			
			if($milestone->save()){	
			
				//Add milestone as Library content
				$this->create_library_content($request, $milestone->id);
								
				if($journey->journey_type_id == 1){
					//Assign milestone to my learning journey current user itself 
					$this->assign_milestone($journey_id, $milestone->id, $request->notes, $request->payment_type,$request->assignment_type, $journey->journey_type_id, $journey->status, $milestone->title);
				}
				
				if($journey->journey_type_id == 3){
					//Assign milestone to my learning journey already assigned user itself 
					$this->assign_assigned_journey_milestone($journey_id, $milestone->id, $request->notes, $request->payment_type,$journey->assignment_type, $journey->journey_type_id, $journey->status,$milestone->title);
				}
				
				
				
				$this->response['status']   	= true;
				$this->response['milestone']    = true;
				$this->response['message']  	= lang_message('milestone_create_success','milestone',$milestone->title);
				
			}else{
				$this->response['status']   	= false;
				$this->response['milestone']    = true;
				$this->response['message']  	= lang_message('milestone_create_failed','milestone',$request->title);
			}
	
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('milestone_require_journey');
		}
		return $this->response();
    }
	
	//Function to assign milestone as my learning journey
	//Input : journey_id 
	//Output : status/message
	private function assign_milestone($j_id, $m_id, $notes, $payment_type, $assignment_type, $journey_type_id, $journey_status, $milestone_name){
		
		$detail = [
			'journey_id' 		=> $j_id,
			'journey_type_id' 	=> $journey_type_id,
			'journey_status' 	=> $journey_status,
			'assignment_type' 	=> (isset($assignment_type)) ? $assignment_type : 'my',
			'milestone_id' 		=> $m_id,
			'milestone_name' 	=> $milestone_name,
			'payment_type' 		=> $payment_type,
			'notes' 			=> $notes
		];
		$this->response = assign_milestone_to_user(user_id(),user_id(),$detail, 'user');
		return true;
	}
	
	//Function to assign milestone as my learning journey
	//Input : journey_id 
	//Output : status/message
	private function assign_assigned_journey_milestone($j_id, $m_id, $notes, $payment_type, $assignment_type, $journey_type_id, $journey_status, $milestone_name){
		$assigned_user = JourneyAssignment::where('journey_id',$j_id)->select(['user_id','type','type_ref_id','assignment_type'])->get();
	
		$detail = [
			'journey_id' 		=> $j_id,
			'journey_type_id' 	=> $journey_type_id,
			'journey_status' 	=> $journey_status,
			'assignment_type' 	=> (isset($assigned_user[0])) ? $assigned_user[0]->assignment_type : 'my',
			'milestone_id' 		=> $m_id,			
			'milestone_name' 	=> $milestone_name,
			'payment_type' 		=> $payment_type,
			'notes' 			=> $notes
		];
		if($assigned_user){
			foreach($assigned_user as $user){
				$this->response = assign_milestone_to_user($user->user_id,$user->type_ref_id,$detail,$user->type);
			}
		}
		return true;
	}
	
	
	//Function to store the library contnet 
	//Input : request
	//Output : status/message
	private function create_library_content(Request $request, $milestone_id){
			
		$exist = Content::where(['title'=>$request->title,'url'=>$request->url]);

		if($exist->count() > 0){
			$this->response['status']   = false;
			$this->response['message']  = lang_message('content_already_exist');
		}else{
			$content = new Content();			
			$content->milestone_id     = $milestone_id;
			$content->title            = $request->title;
			$content->content_type_id  = $request->content_type_id;
			$content->provider  	   = $request->provider;
			$content->url  	   		   = $request->url;
			$content->price  	   	   = $request->price;	
			$content->approver_id	   = $request->approver_id;			
			$content->difficulty  	   = $request->difficulty;
			$content->description  	   = $request->description;
			$content->tags  	   	   = ($request->tags != "")?implode(",",$request->tags) : "";
			$content->type  	   	   = 'journey';
			$content->payment_type     = $request->payment_type;
			$content->created_by 	   = user_id();
			
			if($content->save()){
				$this->response['status']  	= true;
				$this->response['message']  = lang_message('content_create_success','content',$content->title);
			}else{
				$this->response['status']   = false;
				$this->response['message']  = lang_message('content_create_failed','content',$request->title);
			}
		}
		return $this->response();
	}	
	
    //Function to render Journey view page
	//Input : Journey id
	//Output : render view
    public function show($id)
    {
		$total_assignee = $active_assignee = 0;
		
		$journey = Journey::findOrFail(decode_url($id));
		
		$assingee_details = DB::select('(SELECT COUNT(DISTINCT user_id) as total_assignee, COUNT(DISTINCT (CASE WHEN complete_percentage = 100 THEN null ELSE user_id END)) as active_assignee FROM journey_assignment_view WHERE journey_parent_id = :id GROUP BY journey_parent_id)',['id'=>$journey->id]);
		
		if(!empty($assingee_details)){
			$total_assignee = ($assingee_details[0]->total_assignee != "") ? $assingee_details[0]->total_assignee : 0; 
			$active_assignee = ($assingee_details[0]->active_assignee != "") ? $assingee_details[0]->active_assignee : 0; 
		}
		
		$journey_types = JourneyType::whereStatus('active')->get(); 
		$content_types = ContentType::whereStatus('active')->get(); 
		$approvers = User::permission('approval_approvals')->get();
		
		return view('journey_management.predefined_journey_show',compact('journey','journey_types','content_types','approvers','active_assignee','total_assignee'));
    }
	
	//Function to render My Learning Journey view page
	//Input : Journey id
	//Output : render view
	public function my_journey_show($id)
	{
		$assigned = JourneyAssignment::where('journey_id',decode_url($id))->get();
		if($assigned->count() > 0){
			$journey = $assigned->first()->journey;				
			$journey_types = JourneyType::withoutGlobalScope('id')->whereStatus('active')->get();
			$content_types = ContentType::whereStatus('active')->get(); 
			$approvers = User::permission('approval_approvals')->get();
			
			return view('journey_management.my_journey_show',compact('journey','journey_types','content_types','approvers'));
		}else{
			return redirect(route('journeys.index'));
		}
    }
	
	//Function to render Assigned Learning Journey view page
	//Input : Journey id
	//Output : render view
	public function assigned_journey_show($id, $type="")
    {		
		$assigned_collection = JourneyAssignment::where('journey_id',decode_url($id))
		->where(function($q){			 
				$q->orWhere('assignment_type','library')
				->orWhere('assignment_type','predefined');
		});
		if(!is_admin()){
			$assigned_collection->where('created_by',user_id());
		}
		$assigned = $assigned_collection->get();
		
		if(!empty($assigned->first())){
			$assigned_data = $assigned->first();
			$journey = Journey::findOrFail($assigned_data->journey_id);
			$assigned_to = Journey::assigned_to($journey->id)->first();
			$journey_types = JourneyType::withoutGlobalScope('id')->whereStatus('active')->get();
			$content_types = ContentType::whereStatus('active')->get(); 
			$approvers = User::permission('approval_approvals')->get();
			return view('journey_management.assigned_journey_show',compact('journey','journey_types','content_types','approvers','assigned_to','assigned_data'));
		}else{
			return redirect(route('journeys.index'));
		}
    }

    //Function to render Journey edit page
	//Input : NA
	//Output : NA
    public function edit($id)
    {
		$journey = Journey::findOrFail(decode_url($id));
		if($journey && $journey->journey_type_id != 3 && (($journey->created_by == user_id() && $this->user->hasAnyPermission(['edit_journeys'])) || $this->user->hasAnyPermission(['edit_others_journeys']))){
			$journey_types = JourneyType::withoutGlobalScope('id')->whereStatus('active')->get(); 
			$content_types = ContentType::whereStatus('active')->get(); 
			$approvers = User::permission('approval_approvals')->whereNull('deleted_at')->get();
			
			return view('journey_management.journey_edit',compact('journey','journey_types','content_types','approvers'));			
		}else{
			return redirect(route('journeys.index'));
		}
    }
	
	//Function to render Assigned Learning Journey edit page
	//Input : Journey id
	//Output : render view
    public function assigned_journey_edit($id)
    {
		$assigned_collection = JourneyAssignment::where('journey_id',decode_url($id))
		->where(function($q){			 
				$q->orWhere('assignment_type','library')
				->orWhere('assignment_type','predefined');
		});
		$assigned_collection->where('created_by',user_id());
		$assigned = $assigned_collection->get();
	
		if(!empty($assigned->first())){
			$assigned_data = $assigned->first();
			$journey = Journey::findOrFail($assigned_data->journey_id);		
			if($journey && ($journey->created_by == user_id() && $this->user->hasAnyPermission(['edit_journeys']))){
				
				$assigned_to = Journey::assigned_to($journey->id)->first();
				$journey_types = JourneyType::withoutGlobalScope('id')->whereStatus('active')->get(); 
				$content_types = ContentType::whereStatus('active')->get(); 
				$approvers = User::permission('approval_approvals')->whereNull('deleted_at')->get();
				
				return view('journey_management.assigned_journey_edit',compact('journey','journey_types','content_types','approvers','assigned_to'));
			}else{
				return redirect(route('journeys.index'));
			}
		}else{
			return redirect(route('journeys.index'));
		}
    }

    //Function to update Journey
	//Input : request, id
	//Output : status
    public function update(UpdateJourneyPut $request, $id)
    {
		$journey = Journey::findOrFail($id);		
		if($request->status == 'active' && $journey->milestones->count() <= 0){
			$this->response['status']      	  = false;
			$this->response['journey_status'] = $journey->status;
			$this->response['message']     	  = lang_message('atlest_one_milestone_required');
		}else{
			$journey_status = $journey->status;
			
     		$journey->journey_name   		= $request->journey_name;
			$journey->journey_type_id  		= $request->journey_type_id;
			$journey->visibility 			= $request->journey_visibility;
			$journey->journey_description 	= $request->journey_description;
			$journey->status 				= $request->status;
			$journey->read 					= ($request->journey_read != "") ? $request->journey_read : 'optional';
			$journey->updated_by 			= user_id();
	
			if($journey->save()){
				
				//Send milestones for approval 
				if($journey->journey_type_id == 1 && $journey_status != $journey->status && $journey->status == 'active'){
					$this->approval_request($journey);
				}
				
				//predefined journey update notification
				if($journey->journey_type_id == 2 && $journey->created_by != user_id()){
					$user = User::findOrFail($journey->created_by);
					\Notification::send($user, new \App\Notifications\PDJEditNotification(['journey_id'=>$journey->id, 'journey_name' => $journey->journey_name]));
				}
				
				//Assigned Journey update web notification		
				if($journey->journey_type_id == 3){
					alj_email_and_web_notificaiton($journey->id,'updated');
				}
				
				$this->response['status']   = true;
				$this->response['journey_status'] = $journey->status;
				$this->response['visibility'] 	  = $journey->visibility;
				$this->response['read'] 	  	  = $journey->read;
				$this->response['journey_type_id']= $journey->journey_type_id;
				$this->response['journey_id']     = encode_url($journey->id);
				$this->response['message']        = lang_message('journey_update_success','journey',$journey->journey_name);
			}else{
				$this->response['status']   = false;
				$this->response['journey_status'] = $journey->status;
				$this->response['message']  = lang_message('journey_update_failed','journey',$request->journey_name); 
			}
		}
		return $this->response();
    }
	
	//Function to update milestone
	//Input : request
	//Output : status
	public function update_milestone(UpdateMilestonePut $request, $id)
    {
		$has_access = false;		
		$milestone = Milestone::FindOrFail(decode_url($id));
		if($milestone){
			
			if($milestone->created_by == user_id() && $this->user->hasPermissionTo('edit_journeys')){
				$has_access = true;
			}elseif($this->user->hasPermissionTo('edit_others_journeys')){
				$has_access = true;
			}
			
			$journey = $milestone->journey();
			
			if($has_access){	
				$milestone->journey_id 		= decode_url($request->journey_id);
				$milestone->title           = $request->title;
				$milestone->content_type_id = $request->content_type_id;
				$milestone->provider  	    = $request->provider;
				$milestone->url  	   		= $request->url;
				//$milestone->payment_type   	= $request->payment_type;
				//$milestone->approver_id		= $request->approver_id;
				//$milestone->price  	   	    = $request->price;
				$milestone->start_date  	= get_db_date($request->start_date);
				$milestone->end_date  	   	= get_db_date($request->end_date);
				$milestone->difficulty  	= $request->difficulty;
				$milestone->description  	= $request->description;
				$milestone->read  			= ($request->read != "") ? $request->read : 'optional';
				$milestone->tags  	   	   	= ($request->tags != "") ? implode(",",$request->tags) : "";			
				$milestone->length  	   	= $request->get('length',0);
				$milestone->visibility 		= $request->visibility;
				$milestone->updated_by 	    = user_id();
				
				if($journey->journey_type_id == 2){
					$milestone->payment_type   	= $request->payment_type;
					$milestone->approver_id		= $request->approver_id;
					$milestone->price  	   	    = $request->price;
				}
				if($milestone->save()){	
					//Update the notes to all assignee notes
					MilestoneAssignment::where('milestone_id', decode_url($id))->update(['notes'=>$request->notes]);
					
					//predefined journey milestone update web notification
					
					if($journey->journey_type_id == 2 && $journey->created_by != user_id()){
						$user = User::findOrFail($journey->created_by);
						\Notification::send($user, new \App\Notifications\PDJMilestoneEditNotification(['journey_id'=>$journey->id, 'journey_name' => $journey->journey_name,'milestone_name'=>$milestone->title]));
					}
					
					//Assigned journey milestone update web notification
					if($journey->journey_type_id == 3){
						
						//Assigned Journey Milestone update web and email notification		
						alj_milestone_email_and_web_notificaiton(decode_url($id),'updated');
						
						// $user_ids = MilestoneAssignment::where('milestone_id',decode_url($id))->pluck('user_id');
						// $users = User::whereIn('id',$user_ids)->get();
						// \Notification::send($users, new \App\Notifications\ALJMilestoneEditNotification(['journey_id'=>$journey->id, 'journey_name' => $journey->journey_name,'milestone_name'=>$milestone->title]));
					}
				
					$this->response['status']   	= true;
					$this->response['milestone']    = true;
					$this->response['message']  	= lang_message('milestone_update_success','milestone',$milestone->title);
				}else{
					$this->response['status']   	= false;
					$this->response['milestone']    = true;
					$this->response['message']  	= lang_message('milestone_update_failed','milestone',$request->title);
				}
			}else{
				$this->response['status']   = false;
				$this->response['message']  = lang_message('unauthorized_access');
			}
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('milestone_not_found');
		}
		return $this->response();
    }

    //Function to delete Journey
	//Input : journey id
	//Output : status
    public function destroy($id)
    {
		$has_access = false;
		$journey = Journey::findOrFail(decode_url($id));
		$journey_name = $journey->journey_name;
		$journey_type_id = $journey->journey_type_id;
		$created_by = $journey->created_by;
		
		if($created_by == user_id() && $this->user->hasPermissionTo('delete_journeys')){
			$has_access = true;
		}elseif($this->user->hasPermissionTo('delete_others_journeys')){
			$has_access = true;
		}
		
		if($has_access){
			if($journey->delete()){
				Milestone::Where('journey_id',decode_url($id))->delete();
				
				//predefined journey delete notification
				if($journey_type_id == 2 && $created_by != user_id()){
					$user = User::findOrFail($created_by);
					\Notification::send($user, new \App\Notifications\PDJDeleteNotification(['journey_id'=>decode_url($id), 'journey_name' => $journey->journey_name]));
				}

				//Assigned journey delete notification
				if($journey_type_id == 3){
					alj_email_and_web_notificaiton(decode_url($id),'deleted');
				}
				
				$this->response['status']   = true;
				//$this->response['reload']   = true;
				$this->response['message']  = lang_message('journey_delete_success','journey',$journey_name);
			}else{
				$this->response['status']   = false;
				$this->response['message']  = lang_message('journey_delete_failed','journey',$journey_name);
			}
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('unauthorized_access');
		}
		return $this->response();
    }
	
	//Function to delete milestone
	//Input : milestone id
	//Output : status
	public function destroy_milestone($id)
    {
		$has_access = false;
		$milestone = Milestone::findOrFail(decode_url($id));
		$milestone_name = $milestone->title;
		$journey = $milestone->journey();
		
		if($milestone->created_by == user_id() && $this->user->hasPermissionTo('delete_journeys')){
			$has_access = true;
		}elseif($this->user->hasPermissionTo('delete_others_journeys')){
			$has_access = true;
		}
		
		if($has_access){			
			if($milestone->delete()){
				
				//predefined journey milestone delete notification
				if($journey->journey_type_id == 2 && $journey->created_by != user_id()){
					$user = User::findOrFail($journey->created_by);
					\Notification::send($user, new \App\Notifications\PDJMilestoneDeleteNotification(['journey_id'=>$journey->id, 'journey_name' => $journey->journey_name,'milestone_name'=>$milestone_name]));
				}
				if($journey->journey_type_id == 3){
					alj_milestone_email_and_web_notificaiton($milestone->id,'deleted');
				}
					
				$this->response['status']   = true;
				$this->response['message']  = lang_message('milestone_delete_success','milestone',$milestone_name);
			}else{
				$this->response['status']   = false;
				$this->response['message']  = lang_message('milestone_delete_failed','milestone',$milestone_name);
			}
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('unauthorized_access');
		}
		return $this->response();
    }
	
	//Function to render journey rating view 
	//Input : journey id
	//Output : NA
	public function journey_rating($id){
		$assignment = JourneyAssignment::find(decode_url($id));
		if($assignment->rating == "" && $assignment->user_id == user_id()){
			return view('tempcheck.tempcheck_trend_rating',compact('assignment'));
		}
		return redirect(route('tempchecks.trend',[$id]));
	}
	
	//Function to store journey rating 
	//Input : request
	//Output : status
	public function store_journey_rating(StroeJourneyRatingPost $request){
		
		$assignment = JourneyAssignment::find(decode_url($request->journey_id));
		$assignment->rating = $request->rating;
		$assignment->comment = $request->comment;
		
		if($assignment->save()) {  
			$this->response['status']   = true;
			$this->response['message']  = __('message.journey_rating_success');
		} else {
			$this->response['status']   = false;
			$this->response['message']  = __('message.journey_rating_failed');
		}
		return $this->response();
	}
	
	//Function to render assign learning journey to User/Group/Grade view page
	//Input : journey id
	//Output : NA
	public function journey_assign($id){
		
		if($this->user->hasPermissionTo('assign_journeys')){
			
			$journey = Journey::findOrFail(decode_url($id));

			if(empty($journey) || $journey->journey_type_id != 2 || $journey->status != "active"){
				return redirect(route('journeys.index'));
			}
			
			$approvers = User::permission('approval_approvals')->whereNull('deleted_at')->get();
			$content_types = ContentType::whereStatus('active')->get(); 
			$users 	= User::where('status','active')->where('id','!=',1)->where('id','!=',user_id())->get();
			
			if(is_admin()){
				$groups = Group::select(['id','group_name'])->orderBy('group_name','asc')->get();
			}else{
				$groups = Group::join(DB::raw('(SELECT group_id, GROUP_CONCAT(DISTINCT user_id) as group_member_ids FROM group_user_lists WHERE is_admin = 1 AND deleted_at IS NULL GROUP BY group_id) as members'),'members.group_id','=','groups.id','left')->whereRaw('(groups.visibility = "public" OR FIND_IN_SET('.user_id().',members.group_member_ids))')->select(['groups.id','groups.group_name'])->orderBy('groups.group_name','asc')->get();
			}
			
			$grades = OrganizationChart::all();
			
			return view('journey_management.journey_assign',compact('users','groups','grades','journey','content_types','approvers'));
		}else{
			return redirect(route('journeys.index'));
		}
	}
	
	//Function to Store predefined learning journey assignment to User/Group/Grade 
	//Input : request
	//Output : Status
	public function store_journey_assign(StroeJourneyAssignPost $request){
		
		if($this->user->hasPermissionTo('assign_journeys')){		
			if(!empty($request->user)){
				$user_ids = array_map(function($id) { return ['ref_id'=>$id,'user_id'=>$id]; }, $request->user);
				$this->response = assign_journey_to_user($user_ids, $request, 'user');
			}
			
			if(!empty($request->group)){				
				$group_ids = GroupUserList::whereIn('group_id', $request->group)->select('group_id as ref_id','user_id')->groupBy('group_id','user_id')->get()->toArray();
				$this->response = assign_journey_to_user($group_ids, $request, 'group');
			}
			
			if(!empty($request->grade)){
				$grade_ids = UserGrade::whereIn('chart_value_id', $request->grade)->select('chart_value_id as ref_id','user_id')->groupBy('chart_value_id','user_id')->get()->toArray();
				$this->response = assign_journey_to_user($grade_ids, $request, 'grade');
			}
			$this->response['redirect'] = route('journeys.index');
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('unauthorized_access');
		}
		
		return $this->response();
	}
		
	//get milestone details
	public function get_milestone(Request $request, $id=""){
		$data = array();
		$post_data = $request->all();
		if($id != ""){
			$milestone = Milestone::join('milestone_assignments as ma', 'milestones.id', '=', 'ma.milestone_id','left')
			->join('approvals as a', 'a.milestone_id', '=', 'milestones.id', 'left')
			->join('journeys as j', 'j.id', '=', 'milestones.journey_id')
			->join('users as u', 'u.id', '=', 'milestones.created_by','left')
			->join('users as u1', 'u1.id', '=', 'ma.created_by','left')
			->where(function($q) use($request){
			  if($request->category == 'owner'){
				$q->orWhere('ma.created_by',user_id())
				->orWhereNull('ma.user_id');
			  }else{
				$q->where('ma.user_id', '=', user_id())
				->orWhereNull('ma.user_id');				  
			  }
			})
			->where('milestones.id', decode_url($id))
			->select(
			'ma.*',
			'milestones.*',
			'milestones.id as milestone_id',
			'ma.user_id as assigned_user_id',
			'milestones.journey_id as journey_id',
			'j.journey_type_id',
			'j.visibility as journey_visibility',
			'j.read as journey_read',
			'j.status  as journey_status',
			'a.status  as approval_status',
			'a.comment as approval_comment',
			'u.id as created_id',
			'u1.id as assigned_id',
			DB::raw('CONCAT(u.first_name, " ", u.last_name) as created_by'),
			DB::raw('CONCAT(u1.first_name, " ", u1.last_name) as assigned_by')
			)->get()->first();
		
			if($milestone){
				$data = $milestone;
				if($milestone->created_id == user_id()){
					$data->created_by = __('lang.my_self');
				}
				
				if($milestone->assigned_id == user_id()){
					$data->assigned_by = __('lang.my_self');
				}
				
				$data->current_user_id = user_id();
				$data->journey_id = encode_url($milestone->journey_id);
				$data->days_left = date_differance($milestone->end_date, get_db_date());
			}
		}

		 $content_type_id = (!empty($data)) ? $data->content_type_id : $post_data['content_type_id'];
		 $lengthSec ="Length";
		 $providerSec = 'Provider ';
		 if($content_type_id > 1 && $content_type_id < 6){
			$lengthTxt = $providerTxt = "";				
			if($content_type_id == 2 || $content_type_id == 3){
				$lengthTxt = "(minutes) ";
				if($content_type_id == 3){
					$providerTxt = "Episode Name ";
				}
			}		
			if($content_type_id == 4){
			  $lengthTxt = "(pages) ";
			  $providerTxt = "Author ";
			}		
			if($content_type_id == 5){
			  $lengthTxt = "(hours) ";
			  $providerTxt = "Provider Name ";
			}		
			if($lengthTxt != ""){
				$lengthSec = 'Length '.$lengthTxt;
			}		
			if($providerTxt != ""){
				$providerSec = $providerTxt;
			}			
		 }
		$approvers = User::permission('approval_approvals')->whereNull('deleted_at')->get();
		$content_types = ContentType::whereStatus('active')->get();
		return view('journey_management.milestone_model',compact('data','approvers','content_types','post_data','lengthSec','providerSec','content_type_id'));
	}

	//get milestone details
	public function get_milestone_detail(Request $request, $id, $user_id =""){
		$data = array();
		
		$post_data = $request->all();
		$user_id = ($user_id != "") ? decode_url($user_id) : user_id();
		$milestone = Milestone::withTrashed()->join('milestone_assignments as ma', 'milestones.id', '=', 'ma.milestone_id','left')
		->join('approvals as a', 'a.milestone_id', '=', 'milestones.id', 'left')
		->join('journeys as j', 'j.id', '=', 'milestones.journey_id')
		->join('users as u', 'u.id', '=', 'milestones.created_by','left')
		->join('users as u1', 'u1.id', '=', 'ma.created_by','left')
		->where(function($q) use($user_id, $request){
		  if($request->category == 'owner'){
			$q->where('ma.created_by',$user_id);
		  }else{
			$q->where('ma.user_id', '=', $user_id);		  
		  }
		})
		->where('milestones.id', decode_url($id))
		->select(
		'ma.*',
		'milestones.*',
		'milestones.id as milestone_id',
		'ma.user_id as assigned_user_id',
		'milestones.journey_id as journey_id',
		'j.journey_type_id',
		'j.visibility as journey_visibility',
		'j.read as journey_read',
		'j.status  as journey_status',
		'a.status  as approval_status',
		'a.comment as approval_comment',
		'u.id as created_id',
		'u1.id as assigned_id',
		DB::raw('CONCAT(u.first_name, " ", u.last_name) as created_by'),
		DB::raw('CONCAT(u1.first_name, " ", u1.last_name) as assigned_by')
		)->get()->first();
	
		if($milestone){
			$data = $milestone;
			if($milestone->created_id == user_id()){
				$data->created_by = __('lang.my_self');
			}
			
			if($milestone->assigned_id == user_id()){
				$data->assigned_by = __('lang.my_self');
			}
			
			$data->current_user_id = 'NA';
			$data->journey_id = encode_url($milestone->journey_id);
			$data->days_left = date_differance($milestone->end_date, get_db_date());
		}

		 $content_type_id = $data->content_type_id;
		 $lengthSec ="Length";
		 $providerSec = 'Provider ';
		 if($content_type_id > 1 && $content_type_id < 6){
			$lengthTxt = $providerTxt = "";				
			if($content_type_id == 2 || $content_type_id == 3){
				$lengthTxt = "(minutes) ";
				if($content_type_id == 3){
					$providerTxt = "Episode Name ";
				}
			}		
			if($content_type_id == 4){
			  $lengthTxt = "(pages) ";
			  $providerTxt = "Author ";
			}		
			if($content_type_id == 5){
			  $lengthTxt = "(hours) ";
			  $providerTxt = "Provider Name ";
			}		
			if($lengthTxt != ""){
				$lengthSec = 'Length '.$lengthTxt;
			}		
			if($providerTxt != ""){
				$providerSec = $providerTxt;
			}			
		 }
		$approvers = User::permission('approval_approvals')->get();
		$content_types = ContentType::whereStatus('active')->get();
		return view('journey_management.milestone_model',compact('data','approvers','content_types','post_data','lengthSec','providerSec','content_type_id'));
	}
		
	
	//get milestone assignment note details
	public function get_milestone_note(Request $request, $id){
		$data = array();
		$milestone_notes = MilestoneAssignment::where('user_id',user_id())->where('milestone_id', decode_url($id))
		->select('id','notes')->get()->first();
		
		if($milestone_notes){
			$data['id'] = encode_url($milestone_notes->id);
			$data['title'] = Milestone::findOrFail(decode_url($id))->title;
			$data['notes'] = $milestone_notes->notes;
		}
			
		$this->response['status']   = true;
		$this->response['message']  = lang_message('get_milestone_note_success');
		$this->response['data'] 	=  $data;
	
		return $this->response();
	}
	//get active assignee for particular predefined Journey
	public function get_active_assignee(Request $request, $id){
		$data = array();
		$journey = Journey::findOrFail(decode_url($id));
		
		$active_assignees = User::whereRaw("FIND_IN_SET(id,(SELECT GROUP_CONCAT(DISTINCT (CASE WHEN complete_percentage = 100 THEN null ELSE user_id END)) as active_assignee_user_id FROM journey_assignment_view WHERE journey_parent_id = $journey->id GROUP BY journey_parent_id))")->select(['id',DB::raw('CONCAT(first_name," ",last_name) as name')])->get();
		
		if($active_assignees){
			foreach($active_assignees as &$active_assignee){
				$active_assignee->id = encode_url($active_assignee->id);
			}
			$data = $active_assignees;
		}
				
		$this->response['status']   = true;
		$this->response['message']  = lang_message('get_active_assignee_success');
		$this->response['data'] 	= $data;
	
		return $this->response();
	}
	
	
	//get all assingees for particular Assinged Journey
	public function get_all_assignee(Request $request, $id){
		$data = array();
		$journey_id = decode_url($id);
		
		$all_assignees = DB::table('journey_assignment_view')->where('journey_id',$journey_id)
		->select(['user_id as id','user_name as name','complete_percentage','milestone_count','completed_milestone_count'])->get();
		
		if($all_assignees){
			foreach($all_assignees as &$all_assignee){
				$all_assignee->encrpted_id = encode_url($all_assignee->id);
			}
			$data = $all_assignees;
		}
				
		$this->response['status']   = true;
		$this->response['message']  = lang_message('get_all_assignee_success');
		$this->response['data'] 	= $data;
	
		return $this->response();
	}
	
	//get total assignee for particular predefined  journey
	public function get_total_assignee(Request $request, $id){
		$data = array();
		$journey = Journey::findOrFail(decode_url($id));
		
		$total_assignees = User::whereRaw("FIND_IN_SET(id,(SELECT GROUP_CONCAT(DISTINCT user_id) as total_assignee_user_id FROM journey_assignment_view WHERE journey_parent_id = $journey->id GROUP BY journey_parent_id))")->select(['id',DB::raw('CONCAT(first_name," ",last_name) as name')])->get();
		
		if($total_assignees){
			foreach($total_assignees as &$total_assignee){
				$total_assignee->encrpted_id = encode_url($total_assignee->id);
			}
			$data = $total_assignees;
		}
		
		$this->response['status']   = true;
		$this->response['message']  = lang_message('get_active_assignee_success');
		$this->response['data'] 	= $data;
	
		return $this->response();
	}
	
	//get milestone assignment note details
	public function update_milestone_note(StoreMilestoneNotePost $request, $id){
				
		if(MilestoneAssignment::where('id', decode_url($id))->update(['notes'=>$request->notes])){
			$this->response['status']   		 	   = true;
			$this->response['update_milestone_note']   = true;
			$this->response['message']  = lang_message('update_milestone_note_success','milestone',$request->title);
		}
		return $this->response();
	}
	
	//complete milestone with rating
	public function complete_milestone(StoreMilestoneCompletePost $request){
		$approval_status = 'approved';
		$milestone_id = decode_url($request->milestone_id);
		
		$assignment = MilestoneAssignment::where('milestone_id',$milestone_id)->where('user_id',user_id())->get()->first();
		if($assignment){
			if($assignment->milestone->payment_type != 'free'){
				$approval = Approval::where('milestone_id',$milestone_id)->get()->first();
				if($approval && $approval->status != 'approved'){
					$approval_status = $approval->status;
				}
			}
			if($approval_status == 'approved'){			
				if($assignment && $assignment->stauts != "completed"){
					$completed_time = get_db_date_time();
					MilestoneAssignment::where('milestone_id',$milestone_id)->where('user_id',user_id())->update([
					'status' => 'completed', 
					'point'=>calclulatePoints($milestone_id,$completed_time),
					'rating'=>$request->rating,
					'completed_date'=>$completed_time
					]);
					
					//Assigned Journey Milestone complete web and email notification		
					alj_milestone_email_and_web_notificaiton($milestone_id,'complete');
					
					$remain_count = DB::select('SELECT COUNT(ma.user_id) as remain_milestone_count FROM milestones as m LEFT JOIN  milestone_assignments as ma ON m.id = ma.milestone_id WHERE m.deleted_at IS NULL AND ma.status = "assigned" AND m.journey_id = :journey_id AND ma.user_id = :user_id  GROUP BY ma.user_id',['journey_id'=>$assignment->journey_id,'user_id'=>user_id()]);
					
					if(empty($remain_count)){
						JourneyAssignment::where(['journey_id'=>$assignment->journey_id,'user_id'=>user_id()])->update(['status'=>'completed']);
						alj_email_and_web_notificaiton($assignment->journey_id,'complete');
					}
							
					$this->response['status']   	= true;
					$this->response['reting_journey_id']  	= encode_url($assignment->journey_id);
					$this->response['message']  	= lang_message('milestone_complete_success','milestone',$assignment->milestone->title);
				}else{
					$this->response['status']   = false;
					$this->response['message']  = lang_message('milestone_completed_already','milestone',$assignment->milestone->title);
				}
			}else{
				$this->response['status']   = false;
				$this->response['message']  = lang_message('milestone_approval_'.$approval_status,'milestone',$assignment->milestone->title);
			}
				$this->response['rating']   = true;
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('something_went_wrong');
		}	
		
		return $this->response();
	}
	
	//ignore the assigned journey
	public function ignore_journey(Request $request){	

		$journey_id = decode_url($request->journey_id);
		$journey = Journey::findOrFail($journey_id);
		if($journey->read != 'compulsory'){
			if($this->update_assigned_journey_status($request, 'ignored')){

				//Assigned Journey ignore web and email notification		
				alj_email_and_web_notificaiton(decode_url($request->journey_id),'ignored');
				
				$this->response['status']   = true;
				$this->response['message']  = lang_message('journey_ignore_success','journey',$request->name);
			}else{
				$this->response['status']   = false;
				$this->response['message']  = lang_message('journey_ignore_failed','journey',$request->name);
			}
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('journey_compulsory_ignore_failed','journey',$request->name);
		}
		return $this->response();
	}
	
	//unignore the assigned journey
	public function unignore_journey(Request $request){	
	
		if($this->update_assigned_journey_status($request, 'assigned')){

			//Assigned Journey unignore web and email notification		
			alj_email_and_web_notificaiton(decode_url($request->journey_id),'assigned');
			
			$this->response['status']   = true;
			$this->response['message']  = lang_message('journey_unignore_success','journey',$request->name);
		}else{
			$this->response['status']   = false;
			$this->response['message']  =  lang_message('journey_unignore_failed','journey',$request->name);
		}
		return $this->response();
	}
	
	//Revoke the assigned journey
	public function revoke_journey(Request $request){
		
		if($this->update_assigned_journey_status($request, 'revoked')){
			
			//Assigned Journey Revoke web and email notification		
			alj_email_and_web_notificaiton(decode_url($request->journey_id),'revoked');
			
			$this->response['status']   = true;
			$this->response['message']  = lang_message('journey_revoke_success','journey',$request->name);
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('journey_revoke_failed','journey',$request->name);
		}
		return $this->response();
	}
	
	private function update_assigned_journey_status(Request $request, $status){
		
		$journey_id = decode_url($request->journey_id);
		$type_ref_id = decode_url($request->type_ref_id);
		$journey_collection = JourneyAssignment::where('journey_id',$journey_id);
				
		if($request->type == 'user'){
			$journey_collection->where('user_id',$type_ref_id);
		}
		
		if($journey_collection->update(['status' => $status])){			
			//ignore the milestones belongs to this journey
			$milestone_collection = MilestoneAssignment::where('journey_id',$journey_id);
			if($request->type == 'user'){
				$milestone_collection->where('user_id',$type_ref_id);
			}
			$milestone_collection->where('status','!=','completed');
			$milestone_collection->update(['status' => $status]);
			return true;
		}else{
			return false;
		}
		
	}
				
	//Revoke the assigned milestone
	public function revoke_milestone(Request $request){
	
		//Revoke the milestones 
		if($this->update_assigned_milestone_status($request, 'revoked')){	
			
			//Assigned Journey Milestone Revoke web and email notification		
			alj_milestone_email_and_web_notificaiton(decode_url($request->milestone_id),'revoked');
		
			$this->response['status']   = true;
			$this->response['message']  = lang_message('milestone_revoke_success','milestone',$request->name); 
		}else{
			$this->response['status']   = false;
			$this->response['message']  =lang_message('milestone_revoke_failed','milestone',$request->name);
		}
		return $this->response();
	}
	
	//ignore the assigned milestone
	public function ignore_milestone(Request $request){
		$milestone_id = decode_url($request->milestone_id);
		$milestone = Milestone::findOrFail($milestone_id);
		
		if($milestone->read != 'compulsory'){		
			if($this->update_assigned_milestone_status($request, 'ignored')){
				
				//Assigned Journey Milestone ignore web and email notification		
				alj_milestone_email_and_web_notificaiton(decode_url($request->milestone_id),'ignored');
				
				$this->response['status']   = true;
				$this->response['message']  = lang_message('milestone_ignore_success','milestone',$request->name); 
			}else{
				$this->response['status']   = false;
				$this->response['message']  = lang_message('milestone_ignore_failed','milestone',$request->name); 
			}
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('milestone_compulsory_ignore_failed','milestone',$request->name);
		}
		return $this->response();
	}
		
	//unignore the assigned milestone
	public function unignore_milestone(Request $request){
				
		if($this->update_assigned_milestone_status($request, 'assigned')){
			
			//Assigned Journey Milestone Un-ignore web and email notification		
			alj_milestone_email_and_web_notificaiton(decode_url($request->milestone_id),'assigned');
			
			$this->response['status']   = true;
			$this->response['message']  = lang_message('milestone_unignore_success','milestone',$request->name);
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('milestone_unignore_failed','milestone',$request->name);
		}
		return $this->response();
	}
	
	private function update_assigned_milestone_status(Request $request, $status){
				
		$milestone_id = decode_url($request->milestone_id);
		$type_ref_id = decode_url($request->type_ref_id);
		
		$milestone_collection = MilestoneAssignment::where('milestone_id',$milestone_id);
		
		if($request->type == 'user'){
			$milestone_collection->where('user_id',$type_ref_id);
		}
		$milestone_collection->where('status','!=','completed');
		if($milestone_collection->update(['status' => $status])){			
			return true;
		}else{
			return false;
		}
		
	}
	
	//Delete the assigned journey
	public function delete_assigned_journey(Request $request){
		$journey_id = decode_url($request->journey_id);
		$type = $request->type;
		$type_ref_id = decode_url($request->type_ref_id);
			
		if(JourneyAssignment::where('journey_id',$journey_id)->where('type',$type)->where('type_ref_id',$type_ref_id)->delete()){
			
			//Delete the milestones belongs to this journey
			MilestoneAssignment::where('journey_id',$journey_id)->where('type',$type)->where('type_ref_id',$type_ref_id)->delete();
			
			$this->response['status']   = true;
			//$this->response['reload']   = true;
			$this->response['message']  = lang_message('assined_journey_delete_success','journey',$request->name);
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('assined_journey_delete_failed','journey',$request->name);
		}
		return $this->response();
	}
	
	//Duplicate the predefined learning journey
	public function duplicate(StoreDuplicateJourneyPost $request){
		
		$journey_id = decode_url($request->journey_id);
		$journey = Journey::findOrFail($journey_id);
		
		//Duplicate the Journey
		$journey_copy = $journey->replicate();
		$journey_copy->journey_name = $request->journey_name;
		$journey_copy->created_by = user_id();
		
		if($journey_copy->save()){
			
			//Duplicate the Milestones
			foreach($journey->milestones as $milestone){
				$milestone_copy = $milestone->replicate();
				$milestone_copy->journey_id = $journey_copy->id;
				$milestone_copy->created_by = user_id();
				$milestone_copy->save();
			}
			
			$this->response['status']   = true;
			$this->response['action']   = 'journey_duplicate';
			$this->response['message']  = lang_message('journey_duplicate_success','journey',$request->journey_name);
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('journey_duplicate_failed','journey',$request->journey_name);
		}
		return $this->response();
	}
	
	//Add predefined learning journey to my learning journey View
	public function add_to_my_learning_journey(Request $request, $id){
		$journey = Journey::findOrFail(decode_url($id));

		if(empty($journey) || $journey->journey_type_id != 2){
			return back()->with('error','Invalid journey');
		}
		
		$approvers = User::permission('approval_approvals')->whereNull('deleted_at')->get();
		
		$content_types = ContentType::whereStatus('active')->get(); 
		
		//$user_journeys = DB::table('journey_assignment_view')->where('journey_type_id','!=',2)->where('user_id',user_id())->select(['journey_id','journey_name'])->get();
	
		return view('journey_management.predefined_journey_add_to',compact('journey','content_types','approvers'));
	}
	
	//Add predefined learning journey to my learning journey store
	public function store_add_to_my_learning_journey(StoreAddToMyJourneyPost $request){
	
		$user_ids = [['ref_id'=>user_id(),'user_id'=>user_id()]];
		$this->response = assign_journey_to_user($user_ids, $request, 'user');
		
		if($this->response['status']){
			$this->response['status']   = true;
			$this->response['redirect'] = route('journeys.index');
			$this->response['message']  = lang_message('journey_add_to_success','journey',$request->journey_name);	
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('journey_add_to_failed','journey',$request->journey_name);
		}			
		
		return $this->response();
	}
		
	//Journey break down graphical representation 
	public function journey_break_down($id, $category, $user_id = "")
    {
		$visibility = ($user_id != "" && $user_id == "library" && $user_id == "predefined") ? 'public' : 'all';
		$assignment_type = ($user_id != "" && ($user_id == "library" || $user_id == "library")) ? $user_id : '';
		
		$journey = Journey::withTrashed()->findOrFail(decode_url($id));
		$user_id = ($category == 'user') ? (($user_id != "") ? decode_url($user_id) : user_id()) : '';
		
		$journey_data = jouney_break_down(decode_url($id), $journey->journey_type_id, $user_id, $journey->deleted_at, $category, $visibility, $assignment_type);
		
		$assigned_count = $completed_count = 0;
		return view('journey_management.journey_break_down',compact('journey_data','assigned_count','completed_count'));
    }
	
	//Datatable conditional filters 
	private function predefinedJourneyfilterCondition(Request $request, $whereArray){
		
		if(isset($request->journey_id)){
			$condition['field'] = 'journey_id';
			$condition['condition'] = '=';
			$condition['value'] = $request->journey_id;
			$whereArray[] = $condition;
		}
		
		if(isset($request->journey_name)){
			$condition['field'] = 'journey_name';
			$condition['condition'] = '=';
			$condition['value'] = $request->journey_name;
			$whereArray[] = $condition;
		}
					
		if(isset($request->milestone_count)){
			$condition['field'] = 'milestone_count';
			$condition['condition'] = '=';
			$condition['value'] = $request->milestone_count;
			$whereArray[] = $condition;
		}
		
		if(isset($request->created_by)){
			$condition['field'] = 'created_by';
			$condition['condition'] = '=';
			$condition['value'] = $request->created_by;
			$whereArray[] = $condition;
		}

		if(isset($request->total_assignee)){
			$condition['field'] = 'total_assignee';
			$condition['condition'] = '=';
			$condition['value'] = ($request->total_assignee == 0) ? null : $request->total_assignee;
			$whereArray[] = $condition;
		}

		if(isset($request->active_assignee)){
			$condition['field'] = 'active_assignee';
			$condition['condition'] = '=';
			$condition['value'] = ($request->active_assignee == 0) ? null : $request->active_assignee;
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
	
	private function assignedJourneyfilterCondition(Request $request, $whereArray){
		
		if(isset($request->journey_id)){
			$condition['field'] = 'j.journey_id';
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
		if(isset($request->assigned_by)){
			$condition['field'] = 'j.created_by';
			$condition['condition'] = '=';
			$condition['value'] = $request->assigned_by;
			$whereArray[] = $condition;
		}
		if(isset($request->assignment_type)){
			$condition['field'] = 'j.assignment_type';
			$condition['condition'] = '=';
			$condition['value'] = $request->assignment_type;
			$whereArray[] = $condition;
		}
		if(isset($request->assigned_to)){
			$con_v = explode('--',$request->assigned_to);
			
			if(isset($request->group_id)){
				$condition['field'] = 'j.user_id';
				$condition['condition'] = '=';
				$condition['value'] = $con_v[0];
			}else{
				$condition['field'] = 'j.type';
				$condition['condition'] = '=';
				$condition['value'] = $con_v[1];
				
				$whereArray[] = $condition;
				
				$condition['field'] = 'j.type_ref_id';
				$condition['condition'] = '=';
				$condition['value'] = $con_v[0];
			}
			$whereArray[] = $condition;
		}
				
		if(isset($request->read)){
			$condition['field'] = 'j.read';
			$condition['condition'] = '=';
			$condition['value'] = $request->read;
			$whereArray[] = $condition;
		}					

		if(isset($request->created_date)){
			$condition['field'] = 'j.created_at';
			//$condition['value'] = parseDateRange($request->created_date);
			$created_date = json_decode($request->created_date,true); 
			$condition['value'] = [$created_date['start'].' 00:00:00', $created_date['end'].' 23:59:59'];
			$whereArray['between'][] = $condition;
		}		

		return $whereArray;
	}
	//Datatable conditional filters 
	private function myJourneyfilterCondition(Request $request, $whereArray){
		
		if(isset($request->journey_id)){
			$condition['field'] = 'j.journey_id';
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
		
		if(isset($request->assigned_by)){
			$condition['field'] = 'j.assigned_by';
			$condition['condition'] = '=';
			$condition['value'] = $request->assigned_by;
			$whereArray[] = $condition;
		}
		if(isset($request->read)){
			$condition['field'] = 'j.read';
			$condition['condition'] = '=';
			$condition['value'] = $request->read;
			$whereArray[] = $condition;
		}					
		if(isset($request->milestone_count)){
			$condition['field'] = 'jav.milestone_count';
			$condition['condition'] = '=';
			$condition['value'] = $request->milestone_count;
			$whereArray[] = $condition;
		}
		if(isset($request->created_date)){
			$condition['field'] = 'j.created_at';
			//$condition['value'] = parseDateRange($request->created_date);
			$created_date = json_decode($request->created_date,true); 
			$condition['value'] = [$created_date['start'].' 00:00:00', $created_date['end'].' 23:59:59'];
			$whereArray['between'][] = $condition;
		}		
		if(isset($request->completed_date)){
			$condition['field'] = 'j.targeted_complete_date';
			//$condition['value'] = parseDateRange($request->completed_date);
			$completed_date = json_decode($request->completed_date,true); 
			$condition['value'] = [$completed_date['start'].' 00:00:00', $completed_date['end'].' 23:59:59'];
			$whereArray['between'][] = $condition;
		}
		return $whereArray;
	}
	
				
	//My learning journey ajax list	
	private function my_learning_journey_list(Request $request)
    {
		$data = $whereArray = array();
		
		$whereArray[0]['field'] = 'j.user_id';
		$whereArray[0]['condition'] = '=';
		$whereArray[0]['value'] = user_id();
		
		$whereArray[1]['field'] = 'j.assigned_status';
		$whereArray[1]['condition'] = '!=';
		$whereArray[1]['value'] = 'revoked';

		$whereArray[2]['field'] = 'j.journey_type_id';
		$whereArray[2]['condition'] = '!=';
		$whereArray[2]['value'] = 5;

		$whereArray = $this->myJourneyfilterCondition($request, $whereArray);
		
		//DB::flushQueryLog();
		//DB::enableQueryLog();
			
		$journeys = DB::table('journey_assignment_view as j')
			->join(DB::raw('(SELECT journey_id, SUM(milestone_count) as milestone_count, SUM(completed_milestone_count) as completed_milestone_count,
			ROUND(((SUM(completed_milestone_count)/ SUM(milestone_count + revoked_milestone_count))* 100)) AS complete_percentage FROM journey_assignment_view WHERE user_id = "'.user_id().'" group by journey_id) as jav'),'jav.journey_id','=','j.journey_id','left');
	
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){				
				 if($key === 'between'){				
					foreach($where as $k=>$v){
						$journeys->whereBetween($v['field'],$v['value']);
					}
				}else{				
					$journeys->where($where['field'],$where['condition'],$where['value']);
				}
			} 
		}	
		
		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$journeys->where(function($query) use ($search_for){
				$query->orWhere('j.journey_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('jav.milestone_count', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('j.assigned_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('j.read', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('j.tags', 'LIKE', '%'.$search_for.'%');
				$query->orWhere(DB::raw("DATE_FORMAT(j.targeted_complete_date, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
				$query->orWhere(DB::raw("DATE_FORMAT(j.created_at, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
			});				
		}
		
		$journeys->groupBy('j.journey_id');
		//echo $journeyData = $journeys->toSql(); exit;
		//pr($journeyData,1);
		$journeyData = $journeys->get();		
		foreach($journeyData as $key => $row){
		   $action = "";
			
			$action .='<a href="'.route('journeys.my_journey',[encode_url($row->journey_id)]).'" title="View" class="btn btn-blue">View</a>';
			
			if($row->journey_type_id != 3){
				if($this->user->hasPermissionTo('edit_journeys') && $row->created_by == user_id()){
					$action .='<a href="'.route('journeys.edit',[encode_url($row->journey_id)]).'" title="Edit" class="btn btn-lightblue">Edit</a>';
				}
				
				if($this->user->hasPermissionTo('delete_journeys') && $row->created_by == user_id()){
					$action .=' <span class="expand-dot"><i class="icon-Expand animation " title="More"></i><div class="btn-dropdown"> <ul class="list-unstyled"> <li><button type="button" title="Delete" onclick="deleteMyLearningJourney('."'".encode_url($row->journey_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->journey_name."'".')" class="btn btn-red">Delete</button></li> </ul> </div></span>';
				}
			}else{
				if(($row->type == 'group' && is_group_admin($row->type_ref_id)) || $row->type == 'user'){
					if($row->read == 'optional'){
						
						if($row->assigned_status == 'ignored'){
							$action .='<a  title="Unignore" onclick="unignoreMyLearningJourney('."'".encode_url($row->journey_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->journey_name."'".')" class="btn btn-green">Unignore</a>';
						}else if($row->assigned_status == 'assigned'){
							$action .='<a  title="Ignore" onclick="ignoreMyLearningJourney('."'".encode_url($row->journey_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->journey_name."'".')" class="btn btn-red">Ignore</a>';
						}
						
					}
					// else{
						// if($row->assigned_status == 'assigned'){
							// $action .='<button class="btn btn-danger" title="You are not able to ignore a compulsory assigned journey" disabled>Ignore</button>';
						// }
					// }
				}
			}

			if($row->assigned_by == user_id()){
				$assigned_by = __('lang.my_self');  
		    }else{
				$assigned_by = ucfirst($row->assigned_name); 
		    }
			
			$complete_percentage = ($row->complete_percentage != "") ? $row->complete_percentage." %" : "-";
			
			$targeted_complete_date = get_date($row->targeted_complete_date);
			
		    if($row->status == 'draft'){
			  $complete_percentage = $targeted_complete_date = '-';
			  $journey_name = ucfirst($row->journey_name)."<p><span class='draft'>(Draft)</span></p>"; 
		    }else if($row->type == 'group' && is_group_admin($row->type_ref_id)){
			  $journey_name = ucfirst($row->journey_name)."<p><span class='group'>(".group_name($row->type_ref_id).")</span></p>"; 
		    }else{
			  $journey_name = ucfirst($row->journey_name);  
		    }
		   
           $data[$key]['id']        		= ''; 
		   $data[$key]['journey_name']		= $journey_name; 
		   $data[$key]['milestone_count']	= $row->milestone_count;//get_milestone_count($row->journey_id,user_id()); 
		   $data[$key]['assigned_by']		= $assigned_by;
	       $data[$key]['read']  			= ucfirst($row->read); 
           $data[$key]['completed_date']  	= $targeted_complete_date;
           $data[$key]['progress']  		= $complete_percentage;
           $data[$key]['assigned_status']  	= $row->assigned_status;
           $data[$key]['tags']  			= $row->tags;
		   $data[$key]['created_at'] 		= get_date($row->created_at); 		   
		   $data[$key]['action']    		= $action; 
	   }
	   
	   return datatables()->of($data)->make(true);

    }
	
	//Predefined learning journey ajax list	
	private function predefined_learning_journey_list(Request $request){
		
		$data = $whereArray = array();
		
		$whereArray[0]['field'] = 'jav.journey_type_id';
		$whereArray[0]['condition'] = '=';
		$whereArray[0]['value'] = 2;

		$whereArray = $this->predefinedJourneyfilterCondition($request, $whereArray);

		$journeys = DB::table('journey_assignment_view as jav');
		$journeys->join(DB::raw('(SELECT journey_parent_id, COUNT(DISTINCT user_id) as total_assignee, GROUP_CONCAT(DISTINCT user_id) as total_assignee_user_id, COUNT(DISTINCT (CASE WHEN complete_percentage = 100 THEN null ELSE user_id END)) as active_assignee, GROUP_CONCAT(DISTINCT (CASE WHEN complete_percentage = 100 THEN null ELSE user_id END)) as active_assignee_user_id FROM journey_assignment_view group by journey_parent_id) as jav1'),'jav.journey_id','=','jav1.journey_parent_id','left');

		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){				
				 if($key === 'between'){				
					foreach($where as $k=>$v){
						$journeys->whereBetween($v['field'],$v['value']);
					}
				}else{				
					$journeys->where($where['field'],$where['condition'],$where['value']);
				}
			} 
		}	
		
		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$journeys->where(function($query) use ($search_for){
				$query->orWhere('jav.journey_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('jav.milestone_count', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('jav.read', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('jav.created_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('jav.visibility', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('jav.tags', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('jav1.total_assignee', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('jav1.active_assignee', 'LIKE', '%'.$search_for.'%');
				$query->orWhere(DB::raw("DATE_FORMAT(jav.created_at, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
			});				
		}
		
		//$journeys->groupBy('jav.journey_id');
		//echo $journeyData = $journeys->toSql(); exit;
		$journeyData = $journeys->get();
		//pr($journeyData,1);
		foreach($journeyData as $key => $row){
		   $action = $expand = "";
			
			if($row->status != 'draft'){
				if($request->table_name =="predefinedLearningJourneyList"){	
					if($this->user->hasPermissionTo('assign_journeys')){
						$action .='<a title="Assign" href="'.route('journeys.assign',[encode_url($row->journey_id)]).'" class="btn btn-darkgreen">Assign</a>';
					}
				}
			}
			
			$action .='<a title="View" href="'.route('journeys.show',[encode_url($row->journey_id)]).'" class="btn btn-blue">View</a>';
			
			if(is_admin() || ($this->user->hasPermissionTo('edit_journeys') && $row->created_by == user_id())){
				$expand .='<li><a title="Edit" href="'.route('journeys.edit',[encode_url($row->journey_id)]).'" class="btn btn-lightblue">Edit</a></li>';
			}
			
			if(is_admin() || ( $this->user->hasPermissionTo('delete_journeys') && $row->created_by == user_id())){
				$expand .='<li><button title="Delete" type="button" onclick="deleteJourney('."'".encode_url($row->journey_id)."'".','."'".$row->journey_name."'".')" class="btn btn-red">Delete</button></li>';
			}
											
			$expand .='<li><button title="Duplicate" type="button" onclick="duplictePredefinedJourney('."'".encode_url($row->journey_id)."'".')" class="btn btn-darkgreen">Duplicate</button></li>';
			
			if($row->status != 'draft'){
				$expand .='<li><button title="Add to My Learning Journey" type="button" onclick="addToMyJourney('."'".encode_url($row->journey_id)."'".')" class="btn btn-darkblue">Add to...</a></li>';
			}
			
			if($expand != ""){
				$action .='<span class="expand-dot"><i class="icon-Expand animation" title="More" ></i><div class="btn-dropdown"> <ul class="list-unstyled">'.$expand.'</ul> </div></span>';
			}
			
			if($row->created_by == user_id()){
				$created_name = __('lang.my_self');  
		    }else{
				$created_name = ucfirst($row->created_name); 
		    }
			
		    if($row->status == 'draft'){
			  $journey_name = ucfirst($row->journey_name)."<p><span class='draft'>(Draft)</span></p>"; 
		    }else if($row->type == 'group' && is_group_admin($row->type_ref_id)){
			  $journey_name = ucfirst($row->journey_name)."<p><span class='group'>(".group_name($row->type_ref_id).")</span></p>"; 
		    }else{
			  $journey_name = ucfirst($row->journey_name);  
		    }
			
           $data[$key]['id']        		= ''; 
		   $data[$key]['journey_name']		= $journey_name; 
		   $data[$key]['milestone_count']	= $row->milestone_count;
		   $data[$key]['created_name']		= $created_name;
		   $data[$key]['created_at'] 		= get_date($row->created_at); 		   
	       $data[$key]['visibility']  		= ucfirst($row->visibility); 
	       $data[$key]['dummy_total_assignee']  	= ($row->total_assignee != "") ? $row->total_assignee : '0';
	       $data[$key]['total_assignee']  	= ($row->total_assignee != "") ? '<a href="javascript:" onclick="journeyTotalAssignees('."'".encode_url($row->journey_id)."'".','."'".$row->journey_type_id."'".')" >'.$row->total_assignee.'</a>' : '0';
	       $data[$key]['active_assignee']  	= ($row->active_assignee != "") ? $row->active_assignee : '0';
           $data[$key]['tags']  			= $row->tags;
		   $data[$key]['action']    		= $action; 
	   }
	   
	   return datatables()->of($data)->make(true);
	}
	
	// //Assigned learning journey ajax list	
	// private function assigned_learning_journey_list(Request $request)
    // {
		// $data = $whereArray = array();
				
		// $whereArray[0]['field'] = 'j.journey_type_id';
		// $whereArray[0]['condition'] = '=';
		// $whereArray[0]['value'] = 3;
		
		// $whereArray[1]['field'] = 'j.created_by';
		// $whereArray[1]['condition'] = '=';
		// $whereArray[1]['value'] = user_id();
		
		// $whereArray = $this->assignedJourneyfilterCondition($request, $whereArray);
		
		// $journeys = DB::table('journeys as j');
		// $journeys->join(DB::raw('(SELECT journey_id, GROUP_CONCAT(DISTINCT tags) as tags FROM milestones WHERE deleted_at IS NULL GROUP BY journey_id) as m'),'m.journey_id','=','j.id','left');
		// $journeys->join(DB::raw('(SELECT id, CONCAT(first_name," ",last_name) as assigned_name FROM users) as u'),'u.id','=','j.created_by','left');
		
		// $journeys->join(DB::raw('(SELECT journey_id, SUM(milestone_count) as milestone_count, SUM(completed_milestone_count) as completed_milestone_count,
		// ROUND(((SUM(completed_milestone_count)/ SUM(milestone_count))* 100)) AS complete_percentage FROM journey_assignment_view group by journey_id) as jav'),'jav.journey_id','=','j.id','left');
		
		// $journeys->leftJoin(DB::raw(
		// '(SELECT id as ref_id, CONCAT(first_name," ", last_name) as name, CONCAT("user") as type FROM users UNION ALL SELECT id as ref_id, group_name as name, CONCAT("group") as type FROM groups UNION ALL SELECT id as ref_id, node_name as name, CONCAT("grade") as type FROM organization_charts) as grouped_table'
		// ), function($join){
			// $join->on('grouped_table.type','=','j.type')
			// ->on(\DB::raw("FIND_IN_SET(grouped_table.ref_id,j.type_ref_id)"),">",\DB::raw("'0'"));
		// });
		
		// $journeys->select([
		// 'j.id as journey_id',		
		// 'j.journey_name',		
		// 'j.type',		
		// 'j.type_ref_id',		
		// 'j.read',
		// 'j.created_by',
		// 'j.journey_type_id',
		// 'm.tags',
		// 'jav.milestone_count',
		// 'jav.completed_milestone_count',
		// 'jav.complete_percentage',
		// 'u.assigned_name',
		// 'grouped_table.name as assigned_to',
		// DB::raw('(SELECT status FROM journey_assignments WHERE journey_id = j.id AND status = "revoked" LIMIT 1) as revoked'
		// ),
		// 'j.created_at as created_at']);
        		
		// if(!empty($whereArray)){
			// foreach($whereArray as $key => $where){				
				 // if($key === 'between'){				
					// foreach($where as $k=>$v){
						// $journeys->whereBetween($v['field'],$v['value']);
					// }
				// }else{				
					// $journeys->where($where['field'],$where['condition'],$where['value']);
				// }
			// } 
		// }	
		
		// if($request->input('search.value')){
			// $search_for = $request->input('search.value');
			// $journeys->where(function($query) use ($search_for){
				// $query->orWhere('j.journey_name', 'LIKE', '%'.$search_for.'%');
				// $query->orWhere('u.assigned_name', 'LIKE', '%'.$search_for.'%');
				// $query->orWhere('j.read', 'LIKE', '%'.$search_for.'%');
				// $query->orWhere('m.tags', 'LIKE', '%'.$search_for.'%');
				// $query->orWhere('grouped_table.name', 'LIKE', '%'.$search_for.'%');
				// $query->orWhere(DB::raw("DATE_FORMAT(j.created_at, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
			// });			
		// }
		
		// //$journeys->groupBy('j.id');
		// $journeys->orderBy('j.id', 'DESC');
		// //echo $journeyData = $journeys->toSql(); exit;
		// $journeyData = $journeys->get();
	
		// foreach($journeyData as $key => $row){
		    // $action = "";
			
			// $action .='<a href="'.route('journeys.assigned_journey_show',[encode_url($row->journey_id)]).'" title="View" class="btn btn-blue">View</a>';			
		
			// if($this->user->hasPermissionTo('edit_journeys') && $row->created_by == user_id()){
				// $action .='<a href="'.route('journeys.assigned_journey_edit',[encode_url($row->journey_id)]).'" title="Edit" class="btn btn-lightblue">Edit</a>';
			// }
			
			// if($this->user->hasPermissionTo('delete_journeys') && $row->created_by == user_id()){
				
				// $action .=' <span class="expand-dot"><i class="icon-Expand animation " title="More"></i><div class="btn-dropdown"> <ul class="list-unstyled">'; 
				
				// if($row->revoked != 'revoked'){
					// $action .= '<li><button type="button" title="Revoke" onclick="revokeJourney('."'".encode_url($row->journey_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->journey_name."'".')" class="btn btn-green">Revoke</button></li>';
				// }
				
				// $action .='<li><button type="button" title="Delete" onclick="deleteMyLearningJourney('."'".encode_url($row->journey_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->journey_name."'".')" class="btn btn-red">Delete</button></li>';
				
				// $action .='<li><button type="button" title="All Assignees" onclick="journeyAllAssignees('."'".encode_url($row->journey_id)."'".','."'".$row->journey_type_id."'".')" class="btn btn-lightblue">All Assignees</button></li>';
				
				// $action .='</ul></div></span>';
			// }
						
			// if($row->created_by == user_id()){
				// $assigned_name = __('lang.my_self');  
		    // }else{
				// $assigned_name = ucfirst($row->assigned_name);
		    // };
			// $assigned_to = $row->assigned_to;
			// if($row->type == 'user'){
				// if($row->type_ref_id == user_id()){
					// $assigned_to = __('lang.my_self');
				// }else{
					// $assigned_to = ucfirst($row->assigned_to); 
				// }
		    // }else{
				// $type = ucfirst($row->type);
				// $assigned_to = ucfirst($assigned_to)."<p><span class='".$type."'>(".$type.")</span></p>";
		    // }
		   
           // $data[$key]['id']        	= ''; 
		   // $data[$key]['journey_name']		= ucfirst($row->journey_name); 
		   // $data[$key]['assigned_date']		= get_date($row->created_at); 
		   // $data[$key]['assignment_type']	= "pending"; 
		   // $data[$key]['assigned_by']		= $assigned_name; 
		   // $data[$key]['assigned_to']		= $assigned_to; 
           // $data[$key]['read']  			= ucfirst($row->read);
           // $data[$key]['tags']  			= "work pending";
           // $data[$key]['progress']  		= ($row->complete_percentage != "") ? $row->complete_percentage." %" : "-";		   
		   // $data[$key]['action']    		= $action; 
	   // }
	   // return datatables()->of($data)->make(true);
    // }
	
	//Assigned learning journey ajax list	
	private function assigned_learning_journey_list(Request $request)
    {
		$data = $whereArray = array();
				
		$whereArray[0]['field'] = 'j.assigned_by';
		$whereArray[0]['condition'] = '=';
		$whereArray[0]['value'] = user_id();
				
		$whereArray = $this->assignedJourneyfilterCondition($request, $whereArray);
		
		if(isset($request->group_id)){			
			$whereArray[1]['field'] = 'j.type_ref_id';
			$whereArray[1]['condition'] = '=';
			$whereArray[1]['value'] = $request->group_id;
			
			$journeys = DB::table('journey_assignment_view as j')->select(['j.*',DB::raw("(j.user_name) as assigned_to")]);
			$journeys->groupBy('j.user_id','j.assignment_type');
		}else{
			$journeys = DB::table('journey_assignment_view as j')
			->join(DB::raw('(SELECT journey_id, SUM(milestone_count) as milestone_count, SUM(completed_milestone_count) as completed_milestone_count,
			ROUND(((SUM(completed_milestone_count)/ SUM(milestone_count + revoked_milestone_count))* 100)) AS complete_percentage FROM journey_assignment_view where assigned_by = '.user_id().' group by journey_id) as jav'),'jav.journey_id','=','j.journey_id','left')
			->where(function($q){			 
				$q->orWhere('j.assignment_type','library')
				->orWhere('j.assignment_type','predefined');
			})
			->select([
			'j.journey_id',
			'j.journey_name',
			'j.journey_type_id',
			DB::raw("GROUP_CONCAT(DISTINCT j.type) as type"),
			DB::raw("GROUP_CONCAT(DISTINCT j.type_ref_id) as type_ref_id"),
			DB::raw("GROUP_CONCAT(DISTINCT j.tags) as tags"),
			DB::raw("GROUP_CONCAT(DISTINCT j.assigned_by) as assigned_by"),
			DB::raw("GROUP_CONCAT(DISTINCT j.assigned_name) as assigned_name"),
			DB::raw("GROUP_CONCAT(DISTINCT j.assigned_status) as assigned_status"),
			DB::raw("GROUP_CONCAT(DISTINCT j.type_name) as assigned_to"),
			DB::raw("GROUP_CONCAT(DISTINCT j.assignment_type) as assignment_type"),
			'j.created_by',
			'j.read',
			'jav.milestone_count',
			'jav.completed_milestone_count',
			'jav.complete_percentage',
			'j.created_at',
			DB::raw('GROUP_CONCAT(j.assignment_id) as assignment_id')]);		
			$journeys->groupBy('j.journey_id','j.assignment_type');
			$journeys->orderBy('j.journey_id', 'DESC');
		} 
   		
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){				
				 if($key === 'between'){				
					foreach($where as $k=>$v){
						$journeys->whereBetween($v['field'],$v['value']);
					}
				}else{				
					$journeys->where($where['field'],$where['condition'],$where['value']);
				}
			} 
		}	
		
		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$journeys->where(function($query) use ($search_for, $request){
				$query->orWhere('j.journey_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('j.assigned_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('j.assignment_type', 'LIKE', '%'.$search_for.'%');
				if(isset($request->group_id)){
					$query->orWhere('j.user_name', 'LIKE', '%'.$search_for.'%');
				}else{
					$query->orWhere('j.type_name', 'LIKE', '%'.$search_for.'%');
				}
				$query->orWhere('j.read', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('j.tags', 'LIKE', '%'.$search_for.'%');
				$query->orWhere(DB::raw("DATE_FORMAT(j.created_at, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
			});			
		}
		
		//echo $journeyData = $journeys->toSql(); exit;
		$journeyData = $journeys->get();		
		//pr($journeyData,1);
	
		foreach($journeyData as $key => $row){
		    $action = $expand = "";
			
			$action .='<a href="'.route('journeys.assigned_journey_show',[encode_url($row->journey_id),$row->assignment_type]).'" title="View" class="btn btn-blue">View</a>';			
		
			if(!isset($request->group_id) && $this->user->hasPermissionTo('edit_journeys') && $row->created_by == user_id()){
				$action .='<a href="'.route('journeys.assigned_journey_edit',[encode_url($row->journey_id),$row->assignment_type]).'" title="Edit" class="btn btn-lightblue">Edit</a>';
			}
			
			if(!isset($request->group_id) && $this->user->hasPermissionTo('delete_journeys') && $row->created_by == user_id()){
				$expand .='<li><button type="button" title="Delete" onclick="deleteMyLearningJourney('."'".encode_url($row->journey_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->journey_name."'".')" class="btn btn-red">Delete</button></li>';				
			}
			
			if(!isset($request->group_id) && $row->assigned_status != 'revoked' && (strpos($row->assigned_status,'completed') === false) && $row->created_by == user_id()){
				$expand .= '<li><button type="button" title="Revoke" onclick="revokeJourney('."'".encode_url($row->journey_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->journey_name."'".')" class="btn btn-green">Revoke</button></li>';
			}
				
			if(!isset($request->group_id) && $row->type == 'group'){
				$expand .='<li><button type="button" title="All Assignees" onclick="journeyAllAssignees('."'".encode_url($row->journey_id)."'".','."'".$row->journey_type_id."'".')" class="btn btn-lightblue">All Assignees</button></li>';
					
				$expand .='<li><a href="'.route('groups.show',[encode_url($row->type_ref_id)]).'" title="View Passport" class="btn btn-blue">View Group</a></li>';
			}
			
			if(!isset($request->group_id) && $row->type == 'user'){
				$expand .='<li><a href="'.route('users.passport',[encode_url($row->type_ref_id)]).'" title="View Passport" class="btn btn-blue">View Passport</a></li>';
			}
			
			if($expand != ""){
				$action .='<span class="expand-dot"><i class="icon-Expand animation" title="More" ></i><div class="btn-dropdown"> <ul class="list-unstyled">'.$expand.'</ul> </div></span>';
			}
						
			if($row->created_by == user_id()){
				$assigned_name = __('lang.my_self');  
		    }else{
				$assigned_name = ucfirst($row->assigned_name);
		    };
			$assigned_to = $row->assigned_to;
			if($row->type == 'user'){
				if($row->type_ref_id == user_id()){
					$assigned_to = __('lang.my_self');
				}else{
					$assigned_to = ucfirst($row->assigned_to); 
				}
		    }else{
				$type = ucfirst($row->type);
				$t_span = "<p><span class='".$type."'>(".$type.")</span></p>";
				if(isset($request->group_id))
				$t_span = "";
				
				$assigned_to = ucfirst($assigned_to).$t_span;
		    }
		   
           $data[$key]['id']        	= ''; 
		   $data[$key]['journey_name']		= ucfirst($row->journey_name); 
		   $data[$key]['assigned_date']		= get_date($row->created_at); 
		   $data[$key]['assignment_type']	= ucfirst($row->assignment_type); 
		   $data[$key]['assigned_by']		= $assigned_name; 
		   $data[$key]['assigned_to']		= $assigned_to; 
           $data[$key]['read']  			= ucfirst($row->read);
           $data[$key]['tags']  			= $row->tags;
		   if($row->assigned_status == 'ignored' || $row->assigned_status == 'revoked'){
			    $data[$key]['progress'] 		= ucfirst($row->assigned_status); 		
		   }else{
				$data[$key]['progress']  		= ($row->complete_percentage != "") ? $row->complete_percentage." %" : "-";
		   }		   
		   $data[$key]['action']    		= $action; 
	   }
	   return datatables()->of($data)->make(true);
    }
		
	//Predefined learning journey milestone ajax list	
	private function prdefined_milestone_list($journey_id)
    {
		$milestones = Milestone::join('content_types as ct', 'ct.id', '=', 'milestones.content_type_id')
		->where('milestones.journey_id',$journey_id)
		->select(['milestones.id as milestone_id','milestones.title','ct.name','milestones.read','milestones.visibility','milestones.created_by'])
		->get();
		
		$action ="";
        return datatables()->of($milestones)->addColumn('action', function($row) use($action) {
			$action .='<a href="javascript:;" onclick="loadViewMilestone(\''.encode_url($row->milestone_id).'\')" class="btn btn-blue">View</a>';
			
			if(($row->created_by == user_id() && $this->user->hasPermissionTo('edit_journeys') ) || $this->user->hasPermissionTo('edit_others_journeys')){
				$action .='<a href="javascript:;" onclick="loadEditMilestone(\''.encode_url($row->milestone_id).'\')" class="btn btn-lightblue">Edit</a>';
			}
			
			if(($row->created_by == user_id() && $this->user->hasPermissionTo('delete_journeys') ) || $this->user->hasPermissionTo('delete_others_journeys')){
				$action .='<a href="javascript:;" onclick="deleteMilestone(\''.encode_url($row->milestone_id).'\',\'\',\'\',\''.$row->title.'\')" class="btn btn-red">Delete</a>';
			}
			
			return $action;
        })->addColumn('milestone_name', function($row){
			return ucfirst($row->title);
		})->addColumn('milestone_type', function($row){
			return ucfirst($row->name);
		})->addColumn('read', function($row){
			return ucfirst($row->read);
		})->addColumn('visibility', function($row){
			return ucfirst($row->visibility);
		})->addColumn('days_left', function($row){
			return "--"; 
		})->make(true);
    }
	
	private function my_journey_milestone_list($journey_id){
		
		$milestone = MilestoneAssignment::join('milestones as m', 'm.id', '=', 'milestone_assignments.milestone_id')
		->join('journeys as j', 'j.id', '=', 'milestone_assignments.journey_id')
		->join('content_types as ct', 'ct.id', '=', 'm.content_type_id')
		->whereNull('m.deleted_at');
		
		$milestones = $milestone->where('milestone_assignments.user_id', '=', user_id())
					->where('j.journey_type_id', '=', 1)
					->where('milestone_assignments.journey_id', '=', $journey_id)				
					->where('milestone_assignments.status','!=','revoked')
					->select(['m.title','ct.name','m.end_date','m.read','m.id as milestone_id','m.created_by as milestone_created_by','milestone_assignments.status as assignment_status','m.type','m.type_ref_id','milestone_assignments.user_id as assigned_user_id','milestone_assignments.assignment_type'])
					->get();
					
		$action ="";
		$expand ="";
        return datatables()->of($milestones)->addColumn('action', function($row) use($action, $expand) {
			$action .='<a href="javascript:;" onclick="loadViewMilestone(\''.encode_url($row->milestone_id).'\')" class="btn btn-blue">View</a>';
			
			if($row->assigned_user_id == user_id()){
				$action .='<button type="button" onclick="milstoneNotesEdit(\''.encode_url($row->milestone_id).'\')" class="btn btn-green">Notes</button>';
			}

			if($row->assignment_type != 'library'){
				if($row->assignment_status != 'completed'){
					if(($row->milestone_created_by == user_id() && $this->user->hasPermissionTo('edit_journeys') ) || $this->user->hasPermissionTo('edit_others_journeys')){
						$expand .='<a href="javascript:;" onclick="loadEditMilestone(\''.encode_url($row->milestone_id).'\')" class="btn btn-lightblue">Edit</a>';
					}
				}
				
				if(($row->milestone_created_by == user_id() && $this->user->hasPermissionTo('delete_journeys') ) || $this->user->hasPermissionTo('delete_others_journeys')){
					$expand .='<a href="javascript:;" onclick="deleteMilestone('."'".encode_url($row->milestone_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->title."'".')" class="btn btn-red">Delete</a>';
				}
			}else{
				if(($row->type == 'group' && is_group_admin($row->type_ref_id)) || $row->type == 'user'){
					if($row->assignment_status =='assigned' && $row->read != 'compulsory'){
						$expand .='<a  title="Ignore" onclick="ignoreMilestone('."'".encode_url($row->milestone_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->title."'".')" class="btn btn-red">Ignore</a>';
					}
					
					if($row->assignment_status =='ignored' && $row->read != 'compulsory'){
						$expand .='<a  title="Unignore" onclick="unignoreMilestone('."'".encode_url($row->milestone_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->title."'".')" class="btn btn-green">Unignore</a>';
					}
				}
			}
			
			if($expand != ""){			
				$action .='<span class="expand-dot"><i class="icon-Expand animation" title="More" ></i><div class="btn-dropdown"> <ul class="list-unstyled">'.$expand.'</ul> </div></span>';
			}
						
			return $action;
		})->addColumn('milestone_name', function($row){
			return ucfirst($row->title);
		})->addColumn('milestone_type', function($row){
			return ucfirst($row->name);
		})->addColumn('read', function($row){
			return ucfirst($row->read);
		})->addColumn('visibility', function($row){
			return ucfirst($row->visibility);
		})->addColumn('days_left', function($row){
			return date_differance($row->end_date, get_db_date());
		})->make(true);
	}
	
	//Assigned learning journey milestone ajax list	
	private function assigned_milestone_list($journey_id, $category, $assignment_type)
    {	
		$cond = "";
		if($category == 'user'){
			$cond = "AND user_id =".user_id();
		}
			
		$milestone_coll = Milestone::join('content_types as ct', 'ct.id', '=', 'milestones.content_type_id','left')
		->join('journeys as j', 'j.id', '=', 'milestones.journey_id','left')
		->join(DB::raw('(SELECT milestone_id, assignment_type, GROUP_CONCAT(DISTINCT status) as assigned_status, GROUP_CONCAT(DISTINCT user_id) as assigned_user_id FROM milestone_assignments WHERE deleted_at IS NULL '.$cond.' GROUP BY milestone_id) as ma'), 'ma.milestone_id', '=', 'milestones.id','left');
		
		if($category == 'user'){
			$milestone_coll->where('ma.assigned_status','!=','revoked');
		}
		
		if($assignment_type == ""){
			$milestone_coll->where(function($q){			 
				$q->orWhere('ma.assignment_type','library')
				->orWhere('ma.assignment_type','predefined');
			});
		}else{
			$milestone_coll->where('ma.assignment_type',$assignment_type);
		}		
		$milestone_coll->whereNull('milestones.deleted_at')
		->where('milestones.journey_id',$journey_id)
		->select(['milestones.title','ct.name','milestones.end_date','milestones.read','milestones.id as milestone_id','ma.assigned_status','ma.assigned_user_id','milestones.type','milestones.type_ref_id','milestones.created_by']);
		$milestones = $milestone_coll->get();		
		
		$action ="";
		$expand ="";
		
        return datatables()->of($milestones)->addColumn('action', function($row) use($action, $expand,$category) {
		
			if($category == 'owner'){
				$action .='<a href="javascript:;" onclick="loadAssignedViewMilestone(\''.encode_url($row->milestone_id).'\')" class="btn btn-blue">View</a>';
			}else{
				$action .='<a href="javascript:;" onclick="loadViewMilestone(\''.encode_url($row->milestone_id).'\')" class="btn btn-blue">View</a>';				
			}

			if($category == 'owner' && (strpos($row->assigned_status,'completed') === false)){
				
				if(($row->created_by == user_id() && $this->user->hasPermissionTo('edit_journeys') ) || $this->user->hasPermissionTo('edit_others_journeys')){
					$action .='<a href="javascript:;" onclick="loadEditMilestone(\''.encode_url($row->milestone_id).'\')" class="btn btn-lightblue">Edit</a>';
				}
				
				if($row->assigned_status !='revoked'){
					$expand .= '<button type="button" title="Revoke" onclick="revokeMilestone('."'".encode_url($row->milestone_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->title."'".')" class="btn btn-green">Revoke</button>';
				}
			
				if(($row->created_by == user_id() && $this->user->hasPermissionTo('delete_journeys')) || $this->user->hasPermissionTo('delete_others_journeys')){
					$expand .='<a href="javascript:;" onclick="deleteMilestone('."'".encode_url($row->milestone_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->title."'".')" class="btn btn-red">Delete</a>';
				}					
			}
			
			if($category == 'user'){
				
				if(in_array(user_id(),explode(",",$row->assigned_user_id))){
					$action .='<button type="button" onclick="milstoneNotesEdit(\''.encode_url($row->milestone_id).'\')" class="btn btn-green">Notes</button>';
				}
				if(($row->type == 'group' && is_group_admin($row->type_ref_id)) || $row->type == 'user'){
					if($row->assigned_status =='assigned' && $row->read != 'compulsory'){
						$expand .='<a  title="Ignore" onclick="ignoreMilestone('."'".encode_url($row->milestone_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->title."'".')" class="btn btn-red">Ignore</a>';
					}
					
					if($row->assigned_status =='ignored' && $row->read != 'compulsory'){
						$expand .='<a  title="Unignore" onclick="unignoreMilestone('."'".encode_url($row->milestone_id)."'".','."'".$row->type."'".','."'".encode_url($row->type_ref_id)."'".','."'".$row->title."'".')" class="btn btn-green">Unignore</a>';
					}
				}
			}					
			
			if($expand != ""){
				$action .='<span class="expand-dot"><i class="icon-Expand animation" title="More" ></i><div class="btn-dropdown"> <ul class="list-unstyled">'.$expand.'</ul> </div></span>';
			}			
						
			return $action;
		})->addColumn('milestone_name', function($row){
			return ucfirst($row->title);
		})->addColumn('milestone_type', function($row){
			return ucfirst($row->name);
		})->addColumn('read', function($row){
			return ucfirst($row->read);
		})->addColumn('visibility', function($row){
			return ucfirst($row->visibility);
		})->addColumn('days_left', function($row){
			return date_differance($row->end_date, get_db_date());
		})->make(true);
    }
	
	public function group_percent_complete_joureny($group_id, $percentage = 50){
		if($group_id != "" ){
			$journeys = DB::table('journey_assignment_view as j')
			->join(DB::raw('(SELECT journey_id, SUM(milestone_count) as milestone_count, SUM(revoked_milestone_count) as revoked_milestone_count, SUM(completed_milestone_count) as completed_milestone_count,ROUND(((SUM(completed_milestone_count)/ SUM(milestone_count - revoked_milestone_count))* 100)) AS complete_percentage FROM journey_assignment_view group by journey_id) as jav'),'jav.journey_id','=','j.journey_id','left')
			->where('j.journey_type_id',3)->where('j.type','group')->where('j.type_ref_id',$group_id)
			->where('j.assigned_status','assigned')->where('jav.complete_percentage','<=',$percentage)
			->select([
			'j.journey_id',
			'j.journey_name',
			'jav.milestone_count',
			'jav.completed_milestone_count',
			'jav.revoked_milestone_count',
			'jav.complete_percentage']);			
			$journeys->groupBy('j.journey_id');
			$journeys->orderBy('j.journey_id', 'DESC');
			return $journeys->get();
		}else{
			return false;
		}
	}
	
	private function passport_milestone_list($journey_id, $req_user_id){

		$user_id = ($req_user_id != "") ? decode_url($req_user_id) : user_id();
		$milestone = MilestoneAssignment::join('milestones as m', 'm.id', '=', 'milestone_assignments.milestone_id')
		->join('journeys as j', 'j.id', '=', 'milestone_assignments.journey_id')
		->join('content_types as ct', 'ct.id', '=', 'm.content_type_id');
		//->whereNull('m.deleted_at');
		
		if($req_user_id != ""){
			$milestone->where('m.visibility','public');
		}
		
		$milestones = $milestone->where('milestone_assignments.user_id', '=', $user_id)
					->where('milestone_assignments.journey_id', '=', $journey_id)				
					->where('milestone_assignments.status','=','completed')
					->select(['m.title','ct.name','m.end_date','m.difficulty','m.id as milestone_id','m.created_by as milestone_created_by','milestone_assignments.status as assignment_status','m.type','m.type_ref_id','milestone_assignments.user_id as assigned_user_id','milestone_assignments.point','milestone_assignments.rating'])
					->get();
		
		$action ="";
		$expand ="";
        return datatables()->of($milestones)->addColumn('action', function($row) use($action, $expand, $user_id, $req_user_id) {
			
			$action .='<a href="javascript:;" onclick="loadPassportViewMilestone(\''.encode_url($row->milestone_id).'\')" class="btn btn-blue">View</a>';		
			
			if($user_id == user_id() && $req_user_id == ""){
				$action .='<button type="button" onclick="milstoneNotesEdit(\''.encode_url($row->milestone_id).'\')" class="btn btn-green">Notes</button>';	

				$link = milestone_certificate_link(encode_url($row->milestone_id));
					
				$action .='<span class="expand-dot btn-expn pt-0"><a class="btn btn-red">Share</a><div class="btn-dropdown"> <ul class="list-unstyled"><li><a href="javascript:" onclick="downloadCertificate(\''.encode_url($row->milestone_id).'\',2)" class="btn btn-blue">Download</a></li> <li><a href="javascript:" onclick="copyLinkModal(\''.$link.'\')" class="btn btn-darkblue">Get Link</a></li></ul> </div></span>';

			}
			return $action;
		})->addColumn('milestone_name', function($row){
			return ucfirst($row->title);
		})->addColumn('milestone_type', function($row){
			return ucfirst($row->name);
		})->addColumn('difficulty', function($row){
			return ucfirst($row->difficulty);
		})->addColumn('points_earned', function($row){
			return $row->point;
		})->addColumn('rating', function($row){
			return $row->rating;
		})->make(true);
	}

	private function passportJourneyfilterCondition(Request $request, $whereArray){
		
		if(isset($request->journey_name)){
			$condition['field'] = 'j.journey_name';
			$condition['condition'] = '=';
			$condition['value'] = $request->journey_name;
			$whereArray[] = $condition;
		}
		
		if(isset($request->assigned_by)){
			$condition['field'] = 'j.assigned_by';
			$condition['condition'] = '=';
			$condition['value'] = $request->assigned_by;
			$whereArray[] = $condition;
		}
		
		if(isset($request->points_earned)){
			$condition['field'] = 'pjv.points';
			$condition['condition'] = '=';
			$condition['value'] = $request->points_earned;
			$whereArray[] = $condition;
		}
		
		if(isset($request->rating)){
			$condition['field'] = 'pjv.ratings';
			$condition['condition'] = '=';
			$condition['value'] = ($request->rating == 0) ? Null : $request->rating;
			$whereArray[] = $condition;
		}

		if(isset($request->completed_date)){
			$condition['field'] = 'j.completed_date';
			//$condition['value'] = parseDateRange($request->completed_date);
			$completed_date = json_decode($request->completed_date,true); 
			$condition['value'] = [$completed_date['start'].' 00:00:00', $completed_date['end'].' 23:59:59'];
			$whereArray['between'][] = $condition;
		}

		return $whereArray;
	}

	public function passport(Request $request){
		
		$joureny_filter = DB::table('passport_journey_view as j')->where('user_id',user_id())->where('complete_percentage',100)->select('journey_name')->orderBy('journey_name','asc')->get()->unique();
	
		$assigned_filter = DB::table('passport_journey_view as j')->where('user_id',user_id())->select('assigned_by','assigned_name')->orderBy('assigned_name','asc')->get()->unique();
		
		$points_filter = DB::table('passport_journey_view as j')->where('user_id',user_id())->select(DB::raw('SUM(points) as points'))->groupBy('journey_id')->orderBy('points','asc')->get()->unique();
		
		$rating_filter = DB::table('passport_journey_view as j')->where('user_id',user_id())->select(DB::raw('AVG(ratings) as ratings'))->groupBy('journey_id')->orderBy('ratings','asc')->get()->unique();

		return view('passport_management.list',compact('joureny_filter','assigned_filter','points_filter','rating_filter')); 
	}

	//Passport learning journey ajax list	
	public function possport_journey_list(Request $request){
		
		$data = $whereArray = array();
		
		$whereArray[0]['field'] = 'j.user_id';
		$whereArray[0]['condition'] = '=';
		$whereArray[0]['value'] = ($request->current_user) ? user_id() : decode_url($request->current_user_id);

		$whereArray[1]['field'] = 'j.complete_percentage';
		$whereArray[1]['condition'] = '=';
		$whereArray[1]['value'] = 100;

		if(!$request->current_user){
			$whereArray[2]['field'] = 'j.visibility';
			$whereArray[2]['condition'] = '=';
			$whereArray[2]['value'] = 'public';
		}
		
		$whereArray = $this->passportJourneyfilterCondition($request, $whereArray);

		$journeys = DB::table('passport_journey_view as j')
		->join(DB::raw('(SELECT journey_id, SUM(points) as points, AVG(ratings) as ratings
			FROM passport_journey_view group by journey_id) as pjv'),'pjv.journey_id','=','j.journey_id','left');
		
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){				
				 if($key === 'between'){				
					foreach($where as $k=>$v){
						$journeys->whereBetween($v['field'],$v['value']);
					}
				}else{				
					$journeys->where($where['field'],$where['condition'],$where['value']);
				}
			} 
		}	
		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$journeys->where(function($query) use ($search_for){
				$query->orWhere('j.journey_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('j.assigned_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('j.points', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('j.ratings', 'LIKE', '%'.$search_for.'%');
				$query->orWhere(DB::raw("DATE_FORMAT(j.completed_date, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
			});				
		}

		$journeys->groupBy('j.journey_id');
		$journeyData = $journeys->get();
		//pr($journeyData,1);
		foreach($journeyData as $key => $row){
		   $action = $expand = "";
						
			if($request->current_user){
				$action .='<a title="View" href="'.route('journeys.journey_view',[encode_url($row->journey_id),'']).'" class="btn btn-blue">View</a>';
				if($row->journey_type_id != 5){
					$link = jounrey_certificate_link(encode_url($row->journey_id));
					
					$action .='<span class="expand-dot btn-expn pt-0"><a class="btn btn-red">Share</a><div class="btn-dropdown"> <ul class="list-unstyled"><li><a href="javascript:" onclick="downloadCertificate(\''.encode_url($row->journey_id).'\',1)" class="btn btn-blue">Download</a></li> <li><a href="javascript:" onclick="copyLinkModal(\''.$link.'\')" class="btn btn-darkblue">Get Link</a></li></ul> </div></span>';
				}
			}else{
				$action .='<a title="View" href="'.route('journeys.journey_view',[encode_url($row->journey_id),$request->current_user_id]).'" class="btn btn-blue">View</a>';
			}
			
			if($row->assigned_by == user_id()){
				$assigned_name = __('lang.my_self');  
		    }else{
				$assigned_name = ucfirst($row->assigned_name); 
		    }
		
		    $complete_percentage = ($row->complete_percentage != "") ? $row->complete_percentage." %" : "-";
			
           $data[$key]['id']        		= ''; 
		   $data[$key]['journey_name']		= ucfirst($row->journey_name); 
		   $data[$key]['assigned_name']		= $assigned_name;
		   $data[$key]['points_earned']		= $row->points;
		   $data[$key]['ratings']			= ($row->ratings != "") ? round($row->ratings,2) : '0';
		   $data[$key]['completed_date'] 	= ($row->completed_date != "") ? get_date($row->completed_date) : '-'; 		   
	       $data[$key]['progress']  		= $complete_percentage; 
		   $data[$key]['action']    		= $action; 
	   }
	   
	   return datatables()->of($data)->make(true);
	}

	public function backfill_milestone_list(Request $request){
		
		$user_id = ($request->category == "backfill") ? user_id() :(($request->user_id != "") ? decode_url($request->user_id) : user_id());
		
		$milestones = Milestone::join('content_types as ct', 'ct.id', '=', 'milestones.content_type_id')
		->where('milestones.journey_id',2)
		->where('milestones.type','user')
		->where('milestones.type_ref_id',$user_id)
		->select(['milestones.id as milestone_id','milestones.title','ct.name','milestones.difficulty','milestones.start_date','milestones.end_date'])
		->get();
		
		$action ="";
        return datatables()->of($milestones)->addColumn('action', function($row) use($action, $request) {
			$action .='<a href="javascript:;" onclick="loadViewBackfillMilestone(\''.encode_url($row->milestone_id).'\')" class="btn btn-blue">View</a>';
			
			if($request->category == "backfill"){
				if(($row->created_by == user_id() && $this->user->hasPermissionTo('edit_journeys') ) || $this->user->hasPermissionTo('edit_others_journeys')){
					$action .='<a href="javascript:;" onclick="loadEditBackfillMilestone(\''.encode_url($row->milestone_id).'\')" class="btn btn-lightblue">Edit</a>';
				}
				
				if(($row->created_by == user_id() && $this->user->hasPermissionTo('delete_journeys') ) || $this->user->hasPermissionTo('delete_others_journeys')){
					$action .='<a href="javascript:;" onclick="deleteMilestone(\''.encode_url($row->milestone_id).'\',\'\',\'\',\''.$row->title.'\')" class="btn btn-red">Delete</a>';
				}
			}
			
			return $action;
        })->addColumn('milestone_name', function($row){
			return ucfirst($row->title);
		})->addColumn('milestone_type', function($row){
			return ucfirst($row->name);
		})->addColumn('difficulty', function($row){
			return ucfirst($row->difficulty);
		})->addColumn('start_date', function($row){
			return get_date($row->start_date);
		})->addColumn('completion_date', function($row){
			return get_date($row->end_date);
		})->make(true);
	}

	public function get_backfill_milestone(Request $request, $id=""){
		$data = array();
		$post_data = $request->all();
		if($id != ""){
			$milestone = Milestone::findOrFail(decode_url($id));
			if($milestone){
				$data = $milestone;
				if($milestone->created_id == user_id()){
					$data->created_by = __('lang.my_self');
				}			
				$data->journey_id = encode_url($milestone->journey_id);
			}
		}		
		
		 $content_type_id = (!empty($data)) ? $data->content_type_id : $post_data['content_type_id'];
		 $lengthSec ="Length";
		 $providerSec = 'Provider ';
		 if($content_type_id > 1 && $content_type_id < 6){
			$lengthTxt = $providerTxt = "";				
			if($content_type_id == 2 || $content_type_id == 3){
				$lengthTxt = "(minutes) ";
				if($content_type_id == 3){
					$providerTxt = "Episode Name ";
				}
			}		
			if($content_type_id == 4){
			  $lengthTxt = "(pages) ";
			  $providerTxt = "Author ";
			}		
			if($content_type_id == 5){
			  $lengthTxt = "(hours) ";
			  $providerTxt = "Provider Name ";
			}		
			if($lengthTxt != ""){
				$lengthSec = 'Length '.$lengthTxt;
			}		
			if($providerTxt != ""){
				$providerSec = $providerTxt;
			}			
		 }
		 
		$content_types = ContentType::whereStatus('active')->get();
		return view('passport_management.backfill_milestone_modal',compact('data','content_types','post_data','lengthSec','providerSec','content_type_id'));
	}

	public function passport_milestone_count($id){
		$user_id = ($id == 'passport') ? user_id() : decode_url($id);		
		$this->response['status'] = true;
		$this->response['data'] = content_type_wise_points($user_id);
		return $this->response();
	}
			
	//Function to render My Learning Journey view page
	//Input : Journey id
	//Output : render view
	public function passport_journey_view($id, $user_id = "")
	{
		$assigned = \App\Model\JourneyAssignment::where('journey_id',decode_url($id))->get();
		if($assigned->count() > 0){
			$journey = \App\Model\Journey::withTrashed()->where('id',decode_url($id))->get()->first();	
			$journey_types = \App\Model\JourneyType::withoutGlobalScope('id')->whereStatus('active')->get();
			$content_types = \App\Model\ContentType::whereStatus('active')->get(); 
			$approvers = \App\Model\User::permission('approval_approvals')->get();
			
			$user_id = ($user_id != "") ? decode_url($user_id) : user_id();	

			$point_data = DB::table('passport_journey_view')->where('journey_id',decode_url($id))->where('user_id',$user_id)->get()->first();

			return view('passport_management.passport_journey_show',compact('journey','journey_types','content_types','approvers','point_data'));
		}else{
			return redirect(route('journeys.index'));
		}
    }
	
	public function backfill_milestone(){
		$backfill = \App\Model\Journey::where('journey_type_id',5)->get()
		->first();
		$content_types = \App\Model\ContentType::whereStatus('active')->get();
		return view('passport_management.backfill_milestone_add',compact('backfill','content_types'));
	}

	//Function to store the milestone 
	//Input : request
	//Output : status/message
	public function backfill_store_milestone(\App\Http\Requests\StoreBackFillMilestonePost $request)
    {
		if($journey_id = decode_url($request->journey_id)){	
				
			$milestone = new \App\Model\Milestone();
			$milestone->journey_id 		= $journey_id;
			$milestone->title           = $request->title;
			$milestone->content_type_id = $request->content_type_id;
			$milestone->difficulty  	= $request->difficulty;
			$milestone->description  	= $request->description;
			$milestone->tags  	   	   	= ($request->tags != "") ? implode(",",$request->tags) : "";
			$milestone->start_date  	= get_db_date($request->start_date);
			$milestone->end_date  	   	= get_db_date($request->end_date);
			$milestone->created_by 	    = user_id();
			$milestone->type		 	= 'user';
			$milestone->type_ref_id		= user_id();
			
			if($milestone->save()){	
				
				//assign Backfill journey to the user
				$this->assign_journey($journey_id, "backfill");
				
				$this->response['status']   	= true;
				$this->response['milestone']    = true;
				$this->response['message']  	= lang_message('milestone_create_success','milestone',$milestone->title);				
			}else{
				$this->response['status']   	= false;
				$this->response['milestone']    = true;
				$this->response['message']  	= lang_message('milestone_create_failed','milestone',$request->title);
			}
	
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('milestone_require_journey');
		}
		return $this->response();
    }
	
	//Function to update milestone
	//Input : request
	//Output : status
	public function backfill_update_milestone(\App\Http\Requests\UpdateBackFillMilestonePut $request, $id)
    {
		$has_access = false;		
		$milestone = \App\Model\Milestone::FindOrFail(decode_url($id));
		if($milestone){			
			if($milestone->created_by == user_id() && $this->user->hasPermissionTo('edit_journeys')){
				$has_access = true;
			}elseif($this->user->hasPermissionTo('edit_others_journeys')){
				$has_access = true;
			}
			
			if($has_access){	
				$milestone->journey_id 		= decode_url($request->journey_id);
				$milestone->title           = $request->title;
				$milestone->start_date  	= get_db_date($request->start_date);
				$milestone->end_date  	   	= get_db_date($request->end_date);
				$milestone->difficulty  	= $request->difficulty;
				$milestone->description  	= $request->description;
				$milestone->tags  	   	   	= ($request->tags != "") ? implode(",",$request->tags): "";
				$milestone->updated_by 	    = user_id();
				
				if($milestone->save()){	
					$this->response['status']   	= true;
					$this->response['milestone']    = true;
					$this->response['message']  	= lang_message('milestone_update_success','milestone',$milestone->title);
				}else{
					$this->response['status']   	= false;
					$this->response['milestone']    = true;
					$this->response['message']  	= lang_message('milestone_update_failed','milestone',$request->title);
				}
			}else{
				$this->response['status']   = false;
				$this->response['message']  = lang_message('unauthorized_access');
			}
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('milestone_not_found');
		}
		return $this->response();
    }
	
	public function certificate_download($id,$type){
		if($type == '1'){
			$path = jounrey_certificate_link($id,true);
		}else{
			$path = milestone_certificate_link($id,true);
		}
		return response()->download($path);
	}
}
