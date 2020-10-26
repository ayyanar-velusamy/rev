<?php

namespace App\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Journey extends Model
{
	use SoftDeletes;
	
    public function milestones() {
        return $this->hasMany('App\Model\Milestone')->orderBy('end_date', 'asc');
    }
	
	public function creator(){
		$c = $this->hasOne('App\Model\User','id','created_by')->select('first_name','last_name')->first();
		
		if($this->created_by == user_id()){
			return __('lang.my_self');
		}
        return $c->first_name." ".$c->last_name;
    }
	
	public static function assigned_to($journey_id = ""){
		$collection = DB::table('journey_assignment_view')->where(function($q){			 
				$q->orWhere('assignment_type','library')
				->orWhere('assignment_type','predefined');
			});		
		
		if($journey_id != ""){
			$collection->where('journey_id',$journey_id);	
		}
		
		return $collection->select('type','type_ref_id',DB::raw('type_name as name'),DB::raw('CONCAT(type_ref_id,"--",type) as select_id'))->orderBy('type_name','asc')->get()->unique('select_id');
	}
	
	public static function assigned_to_grouped(){
		$grouped = [];		
		$assigned_to = Journey::assigned_to();				
		foreach($assigned_to as $ass){
			$grouped[$ass->type][] = $ass;
		}		
		return $grouped;
	}
	
	public function progress($type = "", $user_id ="") {
		if($type != 'assigned'){
			$user_id = ($user_id != "") ? decode_url($user_id) : user_id();
			return DB::table('journey_assignment_view')->where('journey_id', $this->id)->select(DB::raw('ROUND(((completed_milestone_count)/ (milestone_count - revoked_milestone_count))* 100) as complete_percentage'))->where('user_id',$user_id)->get()->first();
		}else{
			return DB::table('journey_assignment_view as j')->join(DB::raw('(SELECT journey_id, SUM(milestone_count) as milestone_count, SUM(completed_milestone_count) as completed_milestone_count, ROUND(((SUM(completed_milestone_count)/ SUM(milestone_count))* 100)) AS complete_percentage FROM journey_assignment_view group by journey_id) as jav'),'jav.journey_id','=','j.journey_id','left')
			->where('j.journey_id', $this->id)->select('jav.*')->groupBy('j.journey_id')->get()->first();
		}
    }
}
