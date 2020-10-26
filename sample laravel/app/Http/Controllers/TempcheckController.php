<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Authorizable;
use Illuminate\Support\Facades\DB;

use App\Model\Tempcheck;
use App\Model\TempcheckAssignment;
use App\Model\User;
use App\Model\Group;
use App\Model\GroupUserList;
use App\Model\OrganizationChart;
use App\Model\UserGrade;

use App\Http\Requests\StoreTempcheckPost;
use App\Http\Requests\UpdateTempcheckPut;
use App\Http\Requests\StoreTempcheckAssignPost;
use App\Http\Requests\StoreTempcheckRatingPost;

class TempcheckController extends BaseController
{
	
	use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 

	//Datatable conditional filters 
	private function tempCheckfilterCondition(Request $request, $whereArray){
		
		if(isset($request->frequency)){
			$condition['field'] = 'frequency';
			$condition['condition'] = '=';
			$condition['value'] = $request->frequency;
			$whereArray[] = $condition;
		}

		if(isset($request->due_date)){
			$condition['field'] = 'due_date';
			$due_date = json_decode($request->due_date,true); 
			$condition['value'] = [$due_date['start'].' 00:00:00', $due_date['end'].' 23:59:59'];
			$whereArray['between'][] = $condition;
		}
 
		return $whereArray;
	}

	public function ajax_list(Request $request)
    {
		$data = $whereArray = array();

		$temp_collection = Tempcheck::whereNull('deleted_at');
		
		$whereArray = $this->tempCheckfilterCondition($request, $whereArray);
				
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
				$query->orWhere('question', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('frequency', 'LIKE', '%'.$search_for.'%');
				$query->orWhere(DB::raw("DATE_FORMAT(due_date, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
			});			
		}

		//echo $temp_collection->toSql(); exit;
		$tempchecks = $temp_collection->get();

		$action ="";
        return datatables()->of($tempchecks)->addColumn('action', function($row) use($action) {
			
			$action .='<a title="View" href="'.route('tempchecks.show',[encode_url($row->id)]).'" class="btn btn-blue">View</a>';
			
			if($row->status == 'new' && $this->user->hasPermissionTo('add_tempchecks') && $row->created_by == user_id()){			
				$action .='<a title="Assign" href="'.route('tempchecks.assign',[encode_url($row->id)]).'" class="btn btn-blue">Assign</a>';
			}
			
			if($row->status == 'new' && $row->created_by == user_id()){
				if($this->user->hasPermissionTo('edit_tempchecks')){
					$action .='<a title="Edit" href="'.route('tempchecks.edit',[encode_url($row->id)]).'" class="btn btn-lightblue">Edit</a>';
				}
				
				if($this->user->hasPermissionTo('delete_tempchecks')){
					$action .='<a title="Delete" href="javascript:" onclick="deleteTempcheck('."'".encode_url($row->id)."'".','."'".addslashes($row->question)."'".')" class="btn btn-red">Delete</a>';
				}
			}
			
			return $action;
        })->addColumn('frequency', function($row){
			return ucfirst($row->frequency);
		})->addColumn('due_date', function($row){
			return get_date($row->due_date);
		})->make(true);
    }
	
    public function index()
    {
		// $tempObject = Tempcheck::where(function ($query) {
			// $query->where('status', '=', 'new')
				  // ->orWhere('status', '=', 'assigned');
		// })->where('created_by',user_id());
		
		// if($tempObject->count() > 0){
			// $tempcheck = $tempObject->first();
			// return view('tempcheck.tempcheck_show',compact('tempcheck'));
		// }

        return view('tempcheck.tempcheck_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		// $tempObject = Tempcheck::where(function ($query) {
			// $query->where('status', '=', 'new')
				  // ->orWhere('status', '=', 'assigned');
		// })->where('created_by',user_id());
		
		// if($tempObject->count() > 0){
			// return redirect(route('tempchecks.index'));
		// }
		
        return view('tempcheck.tempcheck_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTempcheckPost $request)
    {
        $tempcheck = new Tempcheck();
        $tempcheck->question   		= $request->question;
        $tempcheck->frequency  		= $request->frequency;
        $tempcheck->frequency_day   = $request->frequency_day;
        $tempcheck->due_date   		= get_db_date($request->due_date);
        $tempcheck->created_by   	= user_id();

        if($tempcheck->save()){
			$this->response['status']   = true;
			$this->response['message']  = __('message.tempcheck_create_success');
			$this->response['redirect'] = route('tempchecks.index');
		}else{
			$this->response['status']   = false;
			$this->response['message']  = __('message.tempcheck_create_failed');
		}

        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tempcheck  $tempcheck
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tempcheck = Tempcheck::findOrFail(decode_url($id));
		return view('tempcheck.tempcheck_show', compact('tempcheck'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tempcheck  $tempcheck
     * @return \Illuminate\Http\Response
     */	
    public function edit($id)
    {
		$tempcheck = Tempcheck::findOrFail(decode_url($id));
		
		if($tempcheck->created_by == user_id() || is_admin()){
			return view('tempcheck.tempcheck_edit', compact('tempcheck'));
		}else{
			return redirect(route('tempchecks.index'));
		}       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tempcheck  $tempcheck
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTempcheckPut $request, $id)
    {
        $tempcheck = Tempcheck::findOrFail($id);
        $tempcheck->question   		= $request->question;
        $tempcheck->frequency  		= $request->frequency;
        $tempcheck->frequency_day   = $request->frequency_day;
		$tempcheck->due_date   		= get_db_date($request->due_date);

        if($tempcheck->save()){
			$this->response['status']   = true;
			$this->response['message']  = __('message.tempcheck_update_success');
			$this->response['redirect'] = route('tempchecks.index');
		}else{
			$this->response['status']   = false;
			$this->response['message']  = __('message.tempcheck_update_failed');
		}

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tempcheck  $tempcheck
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tempcheck = Tempcheck::findOrFail(decode_url($id));
		
		if (empty($tempcheck)) {
			$this->response['status']   = false;
            $this->response['message']  = __('message.tempcheck_not_found');
		}else{
			if($tempcheck->delete() ) {  
				$this->response['status']   = true;
				$this->response['message']  = __('message.tempcheck_delete_success');
				$this->response['redirect'] = route('tempchecks.index');
			} else {
				$this->response['status']   = false;
				$this->response['message']  = __('message.tempcheck_delete_failed');
			}
		}
		return $this->response();
    }
	
	public function assign($id){
		$tempcheck = Tempcheck::findOrFail(decode_url($id));		
		if($tempcheck->created_by == user_id() || is_admin()){
			$users 	= User::where('status','active')->where('id','!=',1)->where('id','!=',user_id())->get();
			$groups = Group::all();
			$grades = OrganizationChart::all();
		return view('tempcheck.tempcheck_assign',compact('users','groups','grades','tempcheck'));
		}else{
			return redirect(route('tempchecks.index'));
		} 
	}
	
	public function trend_index(){

		$assignee_filter = TempcheckAssignment::join('users','users.id','=','tempcheck_assignments.user_id')->where('tempcheck_assignments.created_by',user_id())->select(['users.id as user_id','users.first_name','users.last_name'])->orderBy('users.first_name','asc')->groupBy('users.id')->get();
		
		$user_filter = \App\Model\User::whereNull('deleted_at')->whereStatus('active')->select(['designation'])->orderBy('designation','asc')->get();
		return view('tempcheck.tempcheck_trend_list',compact('user_filter','assignee_filter'));
	}
	
	public function assigned_index(){

		$assigned_filter = TempcheckAssignment::join('users','users.id','=','tempcheck_assignments.created_by')->select(['users.id as user_id','users.first_name','users.last_name'])->orderBy('users.first_name','asc')->groupBy('users.id')->get();

		return view('tempcheck.tempcheck_assigned_list',compact('assigned_filter'));
	}
	
	public function trend($id, $user_id){
		$assignment = TempcheckAssignment::where('tempcheck_id',decode_url($id))
		->where('user_id',decode_url($user_id))
		->whereNotNull('rating')
		->join('tempchecks','tempchecks.id','=','tempcheck_assignments.tempcheck_id')
		->orderBy('tempcheck_assignments.id', 'desc')->first();

		if(!empty($assignment)){
			return view('tempcheck.tempcheck_trend_show',compact('assignment'));
		}
		return redirect(route('tempchecks.index'));
	}

	public function trend_graph($id, $user_id){
		$data['categories'] = $data['value'] = array();
		$assignment = TempcheckAssignment::where('tempcheck_id',decode_url($id))
		->where('user_id',decode_url($user_id))
		->join('tempchecks','tempchecks.id','=','tempcheck_assignments.tempcheck_id')
		->orderBy('tempcheck_assignments.id', 'asc')->get();
		if($assignment->count() > 0){
			foreach($assignment as $key=>$assign){				
				array_push($data['categories'],get_date($assign->survay_date));
				array_push($data['value'],$assign->rating);
			}
		}
		
		$this->response['status']   = true;
		$this->response['data']   = $data;
		return $this->response();
	}
	
	public function rating($id){
		$assignment = TempcheckAssignment::find(decode_url($id));
		if($assignment->rating == "" && $assignment->user_id == user_id()){
			return view('tempcheck.tempcheck_trend_rating',compact('assignment'));
		}
		return redirect(route('tempchecks.trend',[$id]));
	}
	
	public function store_rating(StoreTempcheckRatingPost $request){
		
		$assignment = TempcheckAssignment::find(decode_url($request->tempcheck_id));
		$assignment->rating = $request->rating;
		$assignment->comment = $request->comment;
		
		if($assignment->save()) {  
			$this->response['status']   = true;
			$this->response['message']  = __('message.tempcheck_rating_success');
			$this->response['redirect'] = route('tempchecks.index');
		} else {
			$this->response['status']   = false;
			$this->response['message']  = __('message.tempcheck_rating_failed');
		}
		return $this->response();
	}
	
	//Datatable conditional filters 
	private function trendfilterCondition(Request $request, $whereArray){
		
		if(isset($request->user_id)){
			$condition['field'] = 'users.id';
			$condition['condition'] = '=';
			$condition['value'] = $request->user_id;
			$whereArray[] = $condition;
		}

		if(isset($request->designation)){
			$condition['field'] = 'users.designation';
			$condition['condition'] = '=';
			$condition['value'] = $request->designation;
			$whereArray[] = $condition;
		}
 
		return $whereArray;
	}

	public function trend_list(Request $request){
		$action ="";
		$data = $whereArray = array();
		

		$temp_collection = Tempcheck::join(DB::raw('(SELECT user_id, tempcheck_id, AVG(rating) as rating FROM tempcheck_assignments WHERE created_by = '.user_id().' Group by tempcheck_id,user_id) as assignment'),'assignment.tempcheck_id','=','tempchecks.id')
		->join('users','users.id','=','assignment.user_id');

		$whereArray = $this->trendfilterCondition($request, $whereArray);
				
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
				$query->orWhere('users.first_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.last_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.email', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.designation', 'LIKE', '%'.$search_for.'%');
				//$query->orWhere(DB::raw("DATE_FORMAT(due_date, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
			});			
		}
	
		$tempchecks = $temp_collection->select(['users.id as user_id','users.first_name','users.last_name','users.email','users.designation','assignment.rating','tempchecks.id as tempcheck_id','tempchecks.question'])->get();
		
        return datatables()->of($tempchecks)->addColumn('action', function($row) use($action) {
			$action .='<a href="'.route('tempchecks.trend',[encode_url($row->tempcheck_id),encode_url($row->user_id)]).'" class="btn btn-blue">View</a>';
		
			return $action;
        })->addColumn('first_name', function($row){
			return $row->first_name.' '.$row->last_name;
		})->addColumn('designation', function($row){
			return ($row->designation != "") ? ucfirst($row->designation) : '-';
		})->addColumn('email', function($row){
			return $row->email;
		})->addColumn('question', function($row){
			return $row->question;
		})->addColumn('rating', function($row){
			return (($row->rating == '') ? '--' : round($row->rating,2)."/10");
		})->make(true);
	}
	
	//Datatable conditional filters 
	private function assignedfilterCondition(Request $request, $whereArray){
		
		if(isset($request->frequency)){
			$condition['field'] = 't.frequency';
			$condition['condition'] = '=';
			$condition['value'] = $request->frequency;
			$whereArray[] = $condition;
		}

		if(isset($request->assigned_by)){
			$condition['field'] = 'tempcheck_assignments.created_by';
			$condition['condition'] = '=';
			$condition['value'] = $request->assigned_by;
			$whereArray[] = $condition;
		}

		if(isset($request->due_date)){
			$condition['field'] = 't.due_date';
			$due_date = json_decode($request->due_date,true); 
			$condition['value'] = [$due_date['start'].' 00:00:00', $due_date['end'].' 23:59:59'];
			$whereArray['between'][] = $condition;
		}
 
		return $whereArray;
	}

	public function assigned_list(Request $request){
		$action ="";
		$data = $whereArray = array();

		$temp_collection = TempcheckAssignment::join('users','users.id','=','tempcheck_assignments.created_by')
		->join('tempchecks as t','t.id','=','tempcheck_assignments.tempcheck_id')
		 ->where('tempcheck_assignments.user_id',user_id())
		 ->where('tempcheck_assignments.rating',Null);
	
		$whereArray = $this->assignedfilterCondition($request, $whereArray);
				
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
				$query->orWhere('question', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('frequency', 'LIKE', '%'.$search_for.'%');
				$query->orWhere(DB::raw("DATE_FORMAT(due_date, '%b %d, %Y')"), 'LIKE', '%'.$search_for.'%');
			});			
		}
			
		$tempchecks  = $temp_collection->select(['users.first_name','users.last_name','t.frequency','tempcheck_assignments.survay_date','tempcheck_assignments.id'])->get();

        return datatables()->of($tempchecks)->addColumn('action', function($row) use($action) {
			$action .='<a href="'.route('tempchecks.rating',[encode_url($row->id)]).'" class="btn btn-blue">Respond</a>';
		
			return $action;
        })->addColumn('first_name', function($row){
			return $row->first_name." ".$row->last_name;
		})->addColumn('frequency', function($row){
			return ucfirst($row->frequency);
		})->addColumn('due_date', function($row){
			return get_date($row->survay_date);
		})->make(true);
	}
	
	public function store_assign(StoreTempcheckAssignPost $request){
		$temp_id = decode_url($request->tempcheck_id);
		$user = $group = $grade = array();
		if(!empty($request->assignment_ids)){
			foreach(explode(',',$request->assignment_ids[0]) as $assign){
				$id = explode('_',$assign);
				if($id[0] == 'user'){
					array_push($user,$id[1]);
				}
				
				if($id[0] == 'group'){
					array_push($group,$id[1]);
				}
				
				if($id[0] == 'grade'){
					array_push($grade,$id[1]);
				}
			}
		}
		if(!empty($user)){
			$user_ids = array_combine($user,$user);
			$this->assign_to_user($user_ids,$temp_id, 'user');			
		}
		
		if(!empty($group)){
			$user_ids = GroupUserList::whereIn('group_id', $group)->distinct()->pluck('user_id','id');
			$this->assign_to_user($user_ids,$temp_id, 'group');
		}
		
		if(!empty($grade)){
			$user_ids = UserGrade::whereIn('chart_value_id', $grade)->distinct()->pluck('user_id','id');
			$this->assign_to_user($user_ids,$temp_id, 'grade');
		}
		return $this->response();
	}
	
	
	private function assign_to_user($users, $temp_id, $type){
		$data = $notification_user_id = [];
		$tempcheck = Tempcheck::findOrFail($temp_id);
		$survay_dates = get_tempcheck_survay_dates(date('d-m-Y'),$tempcheck->due_date,$tempcheck->frequency,$tempcheck->frequency_day);
		if(!empty($users)){
			foreach($users as $k=>$v){
				foreach($survay_dates as $survay_date){
					$exist = TempcheckAssignment::where(['tempcheck_id'=>$temp_id,'user_id'=>$v,'survay_date'=>$survay_date])->get();
					if(count($exist) == 0){
						$data[] = array(
							'tempcheck_id' 	=> $temp_id,
							'type'		 	=> $type,
							'type_ref_id'	=> $k,
							'user_id'	 	=> $v,
							'survay_date'	=> $survay_date,
							'created_at'	=> get_db_date_time(),
							'created_by' 	=> user_id()
							);
						if($v != user_id()){
							$notification_user_id[] = $v;
						}
					}
				}
			}
			if(TempcheckAssignment::insert($data)) {  
				$this->response['status']   = true;
				$this->response['message']  = __('message.tempcheck_assigned_success');
				$this->response['redirect'] = route('tempchecks.index');
				
				//Web notification
				$users = \App\Model\User::whereIn('id',$notification_user_id)->groupBy('id')->get();
				\Notification::send($users, new \App\Notifications\TempcheckAssignNotification(['temp_id'=>$temp_id]));
			
			} else {
				$this->response['status']   = false;
				$this->response['message']  = __('message.tempcheck_assigned_failed');
			}
		}else{
			$this->response['status']   = false;
			$this->response['message']  = __('message.tempcheck_user_not_found');
		}
		return;
	}

}
