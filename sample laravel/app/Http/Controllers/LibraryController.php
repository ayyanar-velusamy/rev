<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Authorizable;

use App\Model\Content;
use App\Model\ContentType;
use App\Model\User;
use App\Model\Group;
use App\Model\OrganizationChart;
use App\Model\Journey;
use App\Model\JourneyAssignment;
use App\Model\Milestone;

use App\Http\Requests\StoreContentPost;
use App\Http\Requests\UpdateContentPut;
use App\Http\Requests\StroeContentAssignPost;
use App\Http\Requests\StroeContentAddToPost;

class LibraryController extends BaseController
{
	use Authorizable;
	
	Public function __construct(){
		parent::__construct();
	}
	
	public function ajax_list()
    {
		$action ="";
        return datatables()->of(Content::all())->addColumn('action', function($row) use($action) {
			$action .='<a href="'.route('libraries.show',[encode_url($row->id)]).'" class="btn btn-blue">View</a>';
			
			if($this->user->hasPermissionTo('edit_libraries')){
				$action .='<a href="'.route('libraries.edit',[encode_url($row->id)]).'" class="btn btn-lightblue">Edit</a>';
			}
			
			if($this->user->hasPermissionTo('delete_libraries')){
				$action .='<a href="void:" onclick="deleteLibrary('."'".encode_url($row->id)."'".','."'".$row->title."'".')" class="btn btn-red">Delete</a>';
			}
			
			if($this->user->hasPermissionTo('assign_libraries')){
				$action .='<a href="'.route('libraries.assign',[encode_url($row->id)]).'" class="btn btn-primary">Assign</a>';
			}			
			
			$action .='<a onclick="addToMyJourney('."'".encode_url($row->id)."'".')" class="btn btn-green">Add to</a>';			
			
			return $action;
        })->addColumn('content_type', function($row){
			return $row->type()->first()->name;
		})->addColumn('created_by', function($row){
			return $row->creator();
		})->addColumn('created_at', function($row){
			return get_date_time($row->created_at);
		})->make(true);
    }

	//Datatable conditional filters 
	private function contentfilterCondition(Request $request, $whereArray){
		
		if(isset($request->content_name)){
			$condition['field'] = 'contents.title';
			$condition['condition'] = '=';
			$condition['value'] = $request->content_name;
			$whereArray[] = $condition;
		}

		if(isset($request->content_type)){
			$condition['field'] = 'ct.id';
			$condition['condition'] = '=';
			$condition['value'] = $request->content_type;
			$whereArray[] = $condition;
		}
					
		if(isset($request->created_by)){
			$condition['field'] = 'contents.created_by';
			$condition['condition'] = '=';
			$condition['value'] = $request->created_by;
			$whereArray[] = $condition;
		}

		if(isset($request->rating)){
			$condition['field'] = 'ma.rating';
			$condition['condition'] = '=';
			$condition['value'] = ($request->rating == 0) ? null : $request->rating;
			$whereArray[] = $condition;
		}	
		
		if(isset($request->created_date)){
			$condition['field'] = 'contents.created_at';
			//$condition['value'] = parseDateRange($request->created_date);
			$created_date = json_decode($request->created_date,true); 
			$condition['value'] = [$created_date['start'].' 00:00:00', $created_date['end'].' 23:59:59'];
			$whereArray['between'][] = $condition;
		}		
		return $whereArray;
	}

	public function render_ajax_block_list(Request $request){

		$data = $whereArray = array();
		
		$content = Content::join('content_types as ct','ct.id', '=', 'contents.content_type_id','left')
		->join(\Illuminate\Support\Facades\DB::raw('(SELECT m.parent_id, AVG(ma.rating) as rating FROM milestones as m LEFT JOIN milestone_assignments as ma ON m.id = ma.milestone_id WHERE m.parent_type = "library" GROUP BY m.parent_id) as ma'),'ma.parent_id', '=', 'contents.id','left')
		->join(\Illuminate\Support\Facades\DB::raw('(SELECT id, CONCAT(first_name," ",last_name) as created_name FROM users) as u'),'u.id', '=', 'contents.created_by','left');

		$whereArray = $this->contentfilterCondition($request, $whereArray);

		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){				
				 if($key === 'between'){				
					foreach($where as $k=>$v){
						$content->whereBetween($v['field'],$v['value']);
					}
				}else{				
					$content->where($where['field'],$where['condition'],$where['value']);
				}
			} 
		}	
		
		if(isset($request->search_string)){
			$search_for = $request->search_string;
			$content->where(function($query) use ($search_for){
				$query->orWhere('contents.title', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('contents.tags', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('u.created_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('ct.name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere(\Illuminate\Support\Facades\DB::raw("DATE_FORMAT(contents.created_at, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
			});				
		}

		$content->select(['contents.id as content_id','contents.title','ct.name','u.created_name','ma.rating','u.id as created_by','contents.created_at']);
		
		$content->groupBy('contents.id');
		//echo $contentData = $content->toSql(); exit;
		$contentData = $content->paginate(0);
		foreach($contentData as $key => $row){
		   $action = $expand = "";

		   $action .='<li><a href="'.route('libraries.show',[encode_url($row->content_id)]).'" class="btn btn-blue">View</a></li>';

			if($this->user->hasPermissionTo('assign_libraries')){
				$action .='<li><a href="'.route('libraries.assign',[encode_url($row->content_id)]).'" class="btn btn-green">Assign</a></li>';
			}	

			if($this->user->hasPermissionTo('edit_libraries')){
				$action .='<li><a href="'.route('libraries.edit',[encode_url($row->content_id)]).'" class="btn btn-lightblue">Edit</a></li>';
			}
			
			if($this->user->hasPermissionTo('delete_libraries')){
				$action .='<li><a href="javascript:" onclick="deleteLibrary('."'".encode_url($row->content_id)."'".','."'".$row->title."'".')" class="btn btn-red">Delete</a></li>';
			}
						
			$action .='<li><a href="javascript:" onclick="addToMyJourney('."'".encode_url($row->content_id)."'".')" class="btn btn-darkblue">Add to My Journey</a></li>';
			
			if($row->created_by == user_id()){
				$created_name = __('lang.my_self');  
		    }else{
				$created_name = ucfirst($row->created_name); 
		    }
		    
           $data[$key]['id']        		= encode_url($row->content_id); 
		   $data[$key]['title']				= $row->title; 
		   $data[$key]['content_type']		= $row->name; 
		   $data[$key]['rating']			= round($row->rating,2); 
		   $data[$key]['created_name']		= $created_name; 
		   $data[$key]['created_date']		= get_date($row->created_at); 
		   $data[$key]['action']    		= $action; 
	   }
	
	   $paginate = (object)(json_decode(json_encode($contentData), true));

	   $data['current_page']			= $paginate->current_page; 
	   $data['first_page_url']			= $paginate->first_page_url; 
	   $data['from']					= $paginate->from; 
	   $data['last_page']				= $paginate->last_page; 
	   $data['last_page_url']			= $paginate->last_page_url; 
	   $data['next_page_url']			= $paginate->next_page_url; 
	   $data['total']					= $paginate->total; 
	   $data['per_page']				= $paginate->per_page; 
	   $data['to']						= $paginate->to;
	   $data['path']					= $paginate->path;
	   $data['prev_page_url']			= $paginate->prev_page_url;
	   return view('library_management.library_block_list',compact('data'));
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$content_types  = \App\Model\ContentType::whereStatus('active')->get();

		$contents = Content::select(['title'])->orderBy('title','asc')->get()->unique('title');

		$created_by = Content::join(\Illuminate\Support\Facades\DB::raw('(SELECT id, CONCAT(first_name," ",last_name) as created_name FROM users) as u'),'u.id', '=', 'contents.created_by','left')->select(['u.id','u.created_name'])->groupBy('u.id')->get();
	
		$ratings = DB::select('SELECT AVG(ma.rating) as rating FROM milestones as m LEFT JOIN milestone_assignments as ma ON m.id = ma.milestone_id WHERE m.parent_type = "library" GROUP BY m.parent_id');

	    return view('library_management.library_list',compact('contents','content_types','created_by','ratings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$content_types = ContentType::whereStatus('active')->get();
		$approvers = \App\Model\User::permission('approval_approvals')->whereNull('deleted_at')->get();
        return view('library_management.library_add',compact('content_types','approvers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContentPost $request)
    {
        $content = new Content();
		$content->title            = $request->title;
		$content->content_type_id  = $request->content_type_id;
		$content->provider  	   = $request->provider;
		$content->url  	   		   = $request->url;
		$content->difficulty  	   = $request->difficulty;
		$content->description  	   = $request->description;
		$content->length  	   	   = $request->length;
		$content->payment_type     = $request->payment_type;
		$content->price  	   	   = $request->price;
		$content->approver_id	   = ($request->approver_id != "") ? $request->approver_id : '';
		$content->tags  	   	   = ($request->tags != "") ? implode(",",$request->tags) : "";
		$content->type  	   	   = 'journey';
		$content->created_by 	   = user_id();
			  
		if($content->save()){
			$this->response['status']  	= true;
			$this->response['redirect'] = route('libraries.index');
			$this->response['message']  = __('message.content_create_success');
		}else{
			$this->response['status']   = false;
			$this->response['message']  = __('message.content_create_failed');
		}
		return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $content = Content::findOrFail(decode_url($id)); 
		$content_types = ContentType::whereStatus('active')->get(); 
		$approvers = \App\Model\User::permission('approval_approvals')->whereNull('deleted_at')->get();
		
		$content_type_id = $content->content_type_id;
		
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
		 
        return view('library_management.library_show',compact('content','content_types','approvers','content_type_id','lengthSec','providerSec'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $content = Content::findOrFail(decode_url($id)); 
		$content_types = ContentType::whereStatus('active')->get(); 
		$approvers = \App\Model\User::permission('approval_approvals')->whereNull('deleted_at')->get();
		
		$content_type_id = $content->content_type_id;
		
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
        return view('library_management.library_edit',compact('content','content_types','approvers','lengthSec','providerSec','content_type_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContentPut $request, $id)
    {
        $content = Content::findOrFail($id);
		$content->title            = $request->title;
		$content->content_type_id  = $request->content_type_id;
		$content->provider  	   = $request->provider;
		$content->url  	   		   = $request->url;
		$content->difficulty  	   = $request->difficulty;
		$content->length  	   	   = $request->length;
		$content->description  	   = $request->description;
		$content->payment_type     = $request->payment_type;
		$content->price  	   	   = $request->price;
		$content->approver_id	   = ($request->approver_id != "") ? $request->approver_id : '';
		$content->tags  	   	   = ($request->tags != "") ? implode(",",$request->tags) : "";
		$content->type  	   	   = 'library';
		$content->updated_by 	   = user_id();
			  
		if($content->save()){
			$this->response['status']  	= true;
			$this->response['redirect'] = route('libraries.index');
			$this->response['message']  = __('message.content_update_success');
			
			//Web notification
			if($content->created_by != user_id()){
				$user = \App\Model\User::findOrFail($content->created_by);
				\Notification::send($user, new \App\Notifications\ContentUpdateNotification(['content_id'=>$content->id,'content_name'=>$request->title]));
			}
						
		}else{
			$this->response['status']   = false;
			$this->response['message']  = __('message.content_update_failed');
		}
		return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content = Content::findOrFail(decode_url($id));
		$title = $content->title;
		$content_id = $content->id;
		$created_by = $content->created_by;
		
		if($content->delete()){
			$this->response['status']   = true;
			$this->response['message']  = __('message.content_delete_success');
			
			//Web notification
			if($created_by != user_id()){
				$user = \App\Model\User::findOrFail($created_by);
				\Notification::send($user, new \App\Notifications\ContentDeleteNotification(['content_id'=>$content_id,'content_name'=>$title]));
			}
			
		}else{
			$this->response['status']   = false;
			$this->response['message']  = __('message.content_delete_failed');
		}
		return $this->response();
    }
	
	//Assign library content to User/Group/Grade view page
	public function content_assign($id){
		
		$content = Content::findOrFail(decode_url($id));

		if(empty($content)){
			return redirect(route('libraries.index'));
		}

		$approvers = User::permission('approval_approvals')->whereNull('deleted_at')->get();
		$content_types = ContentType::whereStatus('active')->get(); 
		
		$users 	= User::where('status','active')->where('id','!=',1)->where('id','!=',user_id())->get();
		
		if(is_admin()){
			$groups = Group::select(['id','group_name'])->orderBy('group_name','asc')->get();
		}else{
			$groups = Group::join(DB::raw('(SELECT group_id, GROUP_CONCAT(DISTINCT user_id) as group_member_ids FROM group_user_lists WHERE deleted_at IS NULL GROUP BY group_id) as members'),'members.group_id','=','groups.id','left')->whereRaw('(groups.visibility = "public" OR FIND_IN_SET('.user_id().',members.group_member_ids))')->select(['groups.id','groups.group_name'])->orderBy('groups.group_name','asc')->get();
		}
		
		return view('library_management.library_assign',compact('users','groups','content','content_types','approvers'));
	}
	
	//Store content assignment for User/Group/Grade 
	public function store_content_assign(StroeContentAssignPost $request){
		$failed_data = [];
		
		$content_id = decode_url($request->content_id);
		
		$content = Content::findOrFail($content_id);	
	
		if($content){
			if(!empty($request->user)){
				$user_ids = array_map(function($id) { return ['ref_id'=>$id,'user_id'=>$id]; }, $request->user);
				//pr($user_ids,1);
				foreach($user_ids as $user){
					$detail = $this->create_milestone($request,$content,'user',$user['ref_id']);
					
					if(!empty($detail)){
						
						//Assign journey to user						
						library_assign_journey([['ref_id'=>$user['ref_id'],'user_id'=>$user['user_id']]],$request->journey_id,'user');
			
						$response = assign_milestone_to_user($user['user_id'],$user['ref_id'],$detail,'user');
						
						if(!$response['status'] && isset($response['user_id'])){
							$failed_data['user'][] = ['user_id'=>$response['user_id']];
						}
					}					
				}
			}

			if(!empty($request->group)){
				$milestone_details = array();
				$group_ids = \App\Model\GroupUserList::whereIn('group_id', $request->group)->select('group_id as ref_id','user_id')->groupBy('group_id','user_id')->get()->toArray();
				
				$total_m_duplicate = array_unique(array_map(function($i){ return $i['ref_id']; }, $group_ids));
				
				foreach($total_m_duplicate as $dup_k=>$dup_v){
					$milestone_details[$dup_v] = $this->create_milestone($request,$content,'group',$dup_v);
				}
				
				foreach($group_ids as $group){
					if(!empty($milestone_details[$group['ref_id']])){
						
						//Assign journey to user
						library_assign_journey([['ref_id'=>$group['ref_id'],'user_id'=>$group['user_id']]],$request->journey_id,'group');
						}
						
						$response = assign_milestone_to_user($group['user_id'],$group['ref_id'],$milestone_details[$group['ref_id']],'group');
						
						if(!$response['status'] && isset($response['user_id'])){
							$failed_data['group'][] = ['group_id'=>$group['ref_id'],'user_id'=>$response['user_id']];
						}
					}					
			}
			if(empty($failed_data)){
				$this->response = $response;
				$this->response['redirect'] = route('libraries.index');
			}else{
				$this->response['status']    = false;
				$this->response['user_ids']  = $this->content_assign_failed_list($failed_data);
				$this->response['message']   = lang_message('alreay_assinged_to_some_user');
			}
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('something_went_wrong');
		}
		return $this->response();
	}
	
	private function content_assign_failed_list($failed_data){
		if(isset($failed_data['user'])){
			$user_ids = array_unique(array_map(function($i){ return $i['user_id']; }, $failed_data['user']));
			$user = \App\Model\User::whereIn('id',$user_ids)->select(['first_name','last_name'])->get();
		}else{
			$user_ids = array_unique(array_map(function($i){ return $i['user_id']; }, $failed_data['group']));
			$user = \App\Model\User::whereIn('id',$user_ids)->select(['first_name','last_name'])->get();
		}	
		return $user;
	}
	
	private function create_milestone($request,$content,$type,$ref_id){
		$details = array();
		
		$exist = \App\Model\Milestone::where(['journey_id'=>$request->journey_id,'parent_type'=>'library','parent_id'=>$content->id])->get();
		
		if($exist->count() == 0){
			$milestone = new Milestone();
			$milestone->journey_id 		= $request->journey_id;
			$milestone->parent_type 	= 'library';
			$milestone->parent_id 		= $content->id;
			$milestone->title           = $content->title;
			$milestone->content_type_id = $content->content_type_id;
			$milestone->provider  	    = $content->provider;
			$milestone->url  	   		= $content->url;
			$milestone->price  	   	    = $content->price;
			$milestone->approver_id		= $request->approver_id;
			$milestone->difficulty  	= $content->difficulty;
			$milestone->description  	= $content->description;
			$milestone->read  			= ($request->read != "") ? $request->read : 'optional';
			$milestone->tags  	   	   	= $content->tags;
			$milestone->length  	   	= $content->length;
			$milestone->start_date  	= ($request->start_date != "") ? get_db_date($request->start_date) : get_db_date();
			$milestone->end_date  	   	= get_db_date($request->target_date);
			$milestone->visibility 		= $request->visibility;
			$milestone->payment_type   	= $content->payment_type;
			$milestone->created_by 	    = user_id();
			$milestone->type		 	= $type;
			$milestone->type_ref_id		= $ref_id;
			
			if($milestone->save()){
				$details = [
					'journey_id' 		=> $request->journey_id,
					'journey_type_id' 	=> 4,
					'journey_status' 	=> 'active',
					'assignment_type' 	=> 'library',
					'milestone_id' 		=> $milestone->id,
					'milestone_name' 	=> $milestone->title,
					'payment_type' 		=> $milestone->payment_type,
					'notes' 			=> ''
				];
			}
		}else{
			$details = [
				'journey_id' 		=> $request->journey_id,
				'journey_type_id' 	=> 4,
				'journey_status' 	=> 'active',
				'assignment_type' 	=> 'library',
				'milestone_id' 		=> $exist->first()->id,
				'milestone_name' 	=> $exist->first()->title,
				'payment_type' 		=> $exist->first()->payment_type,
				'notes' 			=> ''
			];
			
		}
		return $details;
	}
	public function get_journey(Request $request){
		
		$journey = array();	
		$journey_id = array();	
		$j_ids = array();	
		$output_id = array();	

		if(!empty($request->user_id)){
			$journey = DB::table('journey_assignment_view')->where(['visibility'=>'public','type'=>'user'])->whereIn('type_ref_id',$request->user_id)->where('status','!=','revoked')->select('journey_id','type_ref_id')->get();
			
			foreach($journey as $j){
				$journey_id[$j->type_ref_id][] = $j->journey_id;
			}
			
			foreach($request->user_id as $u){
				$j_ids[$u] = isset($journey_id[$u]) ? $journey_id[$u] : [];
			}
			if(count($j_ids) > 1){
				$output_id[0] = call_user_func_array('array_intersect', $j_ids);
			}else{
				$output_id = $j_ids;
			}
		}
		
		if(!empty($request->group_id)){
			$journey = DB::table('journey_assignment_view')->where(['visibility'=>'public','type'=>'group'])->whereIn('type_ref_id',$request->group_id)->where('status','!=','revoked')->select('journey_id','type_ref_id')->get();
			
			foreach($journey as $j){
				$journey_id[$j->type_ref_id][] = $j->journey_id;
			}
			
			foreach($request->group_id as $g){
				$j_ids[$g] = isset($journey_id[$g]) ? $journey_id[$g] : [];
			}
			
			if(count($j_ids) > 1){
				$output_id[0] = call_user_func_array('array_intersect', $j_ids);
			}else{
				$output_id = $j_ids;
			};
		}
		
		$j_id = array_values($output_id);
		$j_id[0][] = 1;
		$unique_id = array_unique($j_id[0]);
		
		$journey = DB::table('journey_assignment_view')->where('journey_type_id','!=',5)->whereIn('journey_id',$unique_id)->pluck('journey_name','journey_id');

		$this->response['status']   = true;
		$this->response['journeys'] = $journey;
		$this->response['message']  = __('Journey list');
		
		return $this->response();
	}
	
	//Add as a milestone to my learning journey View
	
	public function add_to_my_journey_milestone(Request $request, $id){
		$content = Content::findOrFail(decode_url($id));

		if(empty($content)){
			return back()->with('error','Invalid library content');
		}
		
		$journey_ids = JourneyAssignment::whereIn('type_ref_id', [user_id()])->where(['type'=>'user'])->where('status','!=','revoked')->where('status','!=','deleted')->where('assignment_type','!=','library')->distinct()->pluck('journey_id');
		
		$journey = Journey::whereIn('id',$journey_ids)->where('journey_type_id','!=',5)->pluck('journey_name','id');
		$approvers = User::permission('approval_approvals')->whereNull('deleted_at')->get();
		
		$content_types = ContentType::whereStatus('active')->get(); 
		return view('library_management.library_content_add_to',compact('journey','content','content_types','approvers'));
	}
	
	//Store a milestone to my learning journey 
	public function store_add_to_my_journey_milestone(StroeContentAddToPost $request){
		
		$content_id = decode_url($request->content_id);
		
		$content = Content::findOrFail($content_id);
		
		if($content){
			
			$detail=$this->create_milestone($request,$content,'user',user_id());
			$assignment_type = "my";			
			$journey = \App\Model\JourneyAssignment::where('journey_id',$request->journey_id)->where('user_id',user_id())->where('assignment_type','!=','library')->get();
			
			if($journey->count() > 0){
				$detail['assignment_type'] = $journey->first()->assignment_type;
			}
			
			if(!empty($detail)){
				$this->response = assign_milestone_to_user(user_id(),user_id(),$detail,'user');
			}
			
			$this->response['status']   = true;
			$this->response['message']  = lang_message('content_add_to_success','content',$content->title);
			$this->response['redirect'] = route('journeys.my_journey',[encode_url($request->journey_id)]);
		}else{
			$this->response['status']   = false;
			$this->response['message']  = lang_message('something_went_wrong');			
		}
		return $this->response();
	}
	
	public function get_url_meta_tags(Request $request){
		$this->response['status']   = true;
		$this->response['data']     = get_url_meta_tags($request->url);
		$this->response['message']  = lang_message('get_meta_tags_success');
		return $this->response();
	}
}
