<?php

namespace App\Http\Controllers;
use App\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeerController extends Controller
{
	use Authorizable;
	
	//Datatable conditional filters 
	private function peerfilterCondition(Request $request, $whereArray){
		
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

		if(isset($request->designation)){
			$condition['field'] = 'users.designation';
			$condition['condition'] = '=';
			$condition['value'] = $request->designation;
			$whereArray[] = $condition;
		}

		if(isset($request->points_earned)){
			$condition['field'] = 'rate.points_earned';
			$condition['condition'] = '=';
			$condition['value'] = $request->points_earned;
			$whereArray[] = $condition;
		}

		if(isset($request->completed_milestone_count)){
			$condition['field'] = 'rate.completed_milestone_count';
			$condition['condition'] = '=';
			$condition['value'] = ($request->completed_milestone_count == 0) ? null : $request->completed_milestone_count;
			$whereArray[] = $condition;
		}

		return $whereArray;
	}
	
	public function ajax_list(Request $request)
    {
		
		$data = $whereArray = array();

		$whereArray[0]['field'] = 'users.id';
		$whereArray[0]['condition'] = '!=';
		$whereArray[0]['value'] = user_id();
		
		$peer_collection = \App\Model\User::join(DB::raw('(SELECT ma.user_id, COUNT(DISTINCT CONCAT(m.id,ma.user_id)) as completed_milestone_count, COALESCE(SUM(ma.point),0) as points_earned FROM milestone_assignments as ma LEFT JOIN  milestones as m ON m.id = ma.milestone_id WHERE ma.status = "completed" GROUP BY ma.user_id) as rate'),'rate.user_id','=','users.id','left');	
		$peer_collection->whereNull('users.deleted_at');
		$peer_collection->select('users.id as user_id','users.image','users.first_name','users.last_name','users.designation','rate.completed_milestone_count','rate.points_earned');
		
		$whereArray = $this->peerfilterCondition($request, $whereArray);
				
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){				
				if($key === 'between'){				
					foreach($where as $k=>$v){
						$peer_collection->whereBetween($v['field'],$v['value']);
					}
				}elseif($key === 'FIND_IN_SET'){				
					foreach($where as $k=>$v){
						$peer_collection->whereRaw('FIND_IN_SET('.$v['value'].','.$v['field'].')');
					}
				}
				else{				
					$peer_collection->where($where['field'],$where['condition'],$where['value']);
				}
			} 
		}	

		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$peer_collection->where(function($query) use ($search_for){
				$query->orWhere('users.first_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.last_name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('users.designation', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('rate.points_earned', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('rate.completed_milestone_count', 'LIKE', '%'.$search_for.'%');
			});				
		}
		
		//echo $peer_collection->toSql(); exit;
		$peers = $peer_collection->get();
		//pr($peers,1);
		$action = "";
        return datatables()->of($peers)->addColumn('action', function($row) use($action) {
			
			$action ='<a href="'.route('users.passport',[encode_url($row->user_id)]).'" title="View" class="btn btn-blue">View Passport</a>';
									
			return $action;
        })->addColumn('profile_picture', function($row){
			return '<img width="50" height="50" title="Profile Image" src="'.profile_image($row->image).'">';
		})->addColumn('first_name', function($row){
			return $row->first_name;
		})->addColumn('last_name', function($row){
			return $row->last_name;
		})->addColumn('designation', function($row){
			return ($row->designation != '') ? $row->designation : '-';
		})->addColumn('completed_milestone_count', function($row){
			return ($row->completed_milestone_count != '') ? $row->completed_milestone_count : 0;
		})->addColumn('points_earned', function($row){
			return ($row->points_earned != '') ? $row->points_earned : 0;
		})->make(true);
		
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$point_filter = \App\Model\User::join(DB::raw('(SELECT ma.user_id, COUNT(DISTINCT CONCAT(m.id,ma.user_id)) as completed_milestone_count, COALESCE(SUM(ma.point),0) as points_earned FROM milestone_assignments as ma LEFT JOIN  milestones as m ON m.id = ma.milestone_id WHERE ma.status = "completed" GROUP BY ma.user_id) as rate'),'rate.user_id','=','users.id','left')->whereNull('users.deleted_at')->select('rate.completed_milestone_count','rate.points_earned')->get();

		$user_filter = \App\Model\User::whereNull('deleted_at')->get();
        return view('peer_management.list',compact('user_filter','point_filter')); 
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
		$user_id = decode_url($id);
		$user = \App\Model\User::findOrFail($user_id);
		$user_grade =  \App\Model\UserGrade::where(['user_id' => $user_id])->select('chart_name_id','chart_value_id')->get();
		$org_data = \App\Model\ChartSidebar::all('id','set_id','set_name');
		return view('peer_management.passport',compact('user','org_data','user_grade')); 
    }

	public function passport($id){
		$user_id = decode_url($id);
		if($user_id == user_id()){
			return redirect(route('passport'));
		}
		return $this->show($id);
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
	
	//Function to render My Learning Journey view page
	//Input : Journey id
	//Output : render view
	public function journey_view($id)
	{
		$journey = \App\Model\Journey::where('id',1)->get()->first();
		if($journey){			
			$journey_types = \App\Model\JourneyType::withoutGlobalScope('id')->whereStatus('active')->get();
			$content_types = \App\Model\ContentType::whereStatus('active')->get(); 
			$approvers = \App\Model\User::permission('approval_approvals')->get();
			
			return view('peer_management.journey_show',compact('journey','journey_types','content_types','approvers'));
		}else{
			return redirect(route('journeys.index'));
		}
    }
}
