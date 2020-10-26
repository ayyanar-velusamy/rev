<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Authorizable;

class DashboardController extends BaseController
{
	//use Authorizable;
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home_old');
    }

	public function dev_dashboard()
    {
		$count['user'] = \App\Model\User::count();
		$count['group'] = \App\Model\Group::count();
		$count['tempcheck'] = \App\Model\Tempcheck::count();
        return view('home',compact('count'));
    }
	
	public function approval_graph(){
		
		$approvals = DB::table('approvals as a');
		$approvals->join('milestones as m','m.id','=','a.milestone_id','left');	
		$approvals->whereNull('m.deleted_at');
		$approvals->select([DB::raw('SUM(CASE WHEN a.status = "approved" THEN 1 ELSE 0 END) as approved'),DB::raw('SUM(CASE WHEN a.status = "pending" THEN 1 ELSE 0 END) as pending'),DB::raw('SUM(CASE WHEN a.status = "rejected" THEN 1 ELSE 0 END) as rejected')]);

		$this->response['status']   = true;
		$this->response['data']  	= $approvals->get()->first();
		return $this->response();
	}
	
	public function library_graph(){
		$contnet = DB::table('content_types as ct');
		$contnet->join(DB::raw('(SELECT content_type_id, count(id) as count FROM contents WHERE deleted_at IS NULL GROUP BY content_type_id) as c'),'c.content_type_id','=','ct.id','left')->select(['ct.id','ct.name',DB::raw('COALESCE(c.count,0) as count')])->groupBy('ct.id');
		
		$this->response['status']   = true;
		$this->response['data']  	= $contnet->get();
		return $this->response();
	}
	
	public function top_five_point_users(){
		
		$user_points = DB::select('SELECT ma.user_id, CONCAT(u.first_name, " ",u.last_name) as username, u.image, SUM(ma.point) as points FROM milestones as m LEFT JOIN  milestone_assignments as ma ON m.id = ma.milestone_id LEFT JOIN  users as u ON u.id = ma.user_id WHERE ma.status = "completed" GROUP BY ma.user_id ORDER BY points desc LIMIT 5');
				
		foreach($user_points as $points){
			$points->image = profile_image($points->image);
		}
		
		$this->response['status']   = true;
		$this->response['data']  	= $user_points;
		return $this->response();
	}
	
	public function milestone_graph(){
		
		$milestone_data = DB::select('SELECT SUM(CASE WHEN payment_type ="free" THEN 1 ELSE 0 END) AS free, SUM(CASE WHEN payment_type ="paid" THEN 1 ELSE 0 END) AS paid FROM milestones WHERE deleted_at IS NULL GROUP BY WEEK(created_at) ORDER BY WEEK(created_at)');
		
		$this->response['status']   = true;
		$this->response['data']  	= $milestone_data;
		return $this->response();
	}
	
	
	public function user_login_graph(){
		
	}
	
	public function user_signup_graph(){
		
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
}
