<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Milestone extends Model
{
	
	use SoftDeletes;
	
	public function journey(){
		return $this->hasOne('App\Model\Journey','id','journey_id')->get()->first();
	}
	
    public function creator(){
		$c = $this->hasOne('App\Model\User','id','created_by')->select('first_name','last_name')->first();
		if($this->created_by == user_id()){
			return __('lang.my_self');
		}
        return $c->first_name." ".$c->last_name;
    }
	
	public function approver_details(){
		return $this->hasOne('App\Model\User','id','approver_id')->first();
    }
	
	public function milestone_type_name(){
		return $this->hasOne('App\Model\ContentType','id','content_type_id')->select('name')->first()->name;
    }
	
	
	public function break_down($user_id = ""){
		$con = "";		
		if($user_id != ""){
			$con = "AND user_id =".$user_id;
		}		
		$milestones = DB::table('milestones as m');
		$milestones->join(DB::raw('(SELECT milestone_id, COUNT(DISTINCT user_id) as assigned_count, SUM(CASE WHEN (status = "completed") THEN 1 ELSE 0 END) as completed_count, GROUP_CONCAT(DISTINCT user_id) as user_id, GROUP_CONCAT(DISTINCT status) as assigned_status, GROUP_CONCAT(CONCAT_WS("--",user_id,completed_date)) as user_comp_date, GROUP_CONCAT(CONCAT_WS("--",user_id,point)) as user_point, GROUP_CONCAT(CONCAT_WS("--",user_id,rating)) as user_rating FROM milestone_assignments WHERE deleted_at IS NULL '.$con.' GROUP BY milestone_id) as ma'),'ma.milestone_id','=','m.id','left')->where('m.id',$this->id)->whereNull('m.deleted_at');
		
		if($user_id != ""){
			$milestones->where('ma.assigned_status','!=','revoked');
		}
				
		$milestones->select(['ma.milestone_id','ma.assigned_count','ma.user_id','ma.completed_count','ma.user_point','ma.user_rating','ma.user_comp_date',DB::raw('ROUND((ma.completed_count/ma.assigned_count)*100) as completed_percentage')]);

		return $milestones->get();	 
    }
	
}
