<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Model\Group;
use App\Model\OrganizationChart;

class JourneyAssignment extends Model
{
	use SoftDeletes;
	
	public $timestamps = true;
	
    protected $fillable = ['journey_id','type','type_ref_id','user_id'];
	
	public function journey(){
		return $this->hasOne('App\Model\Journey','id','journey_id');
	}
	
	public static function assigner(){
		$assigners = JourneyAssignment::
		 join('journeys', 'journeys.id', '=', 'journey_assignments.journey_id')
		->join('users', 'users.id', '=', 'journey_assignments.created_by')->select('users.id as user_id',DB::raw('CONCAT(users.first_name," ",users.last_name) as assigner_name'),'journeys.id as journey_id')->orderBy('users.first_name','asc')->get()->unique('user_id');
		
		foreach($assigners as $assigner){
			if($assigner->user_id == user_id()){
				$assigner->assigner_name = __('lang.my_self');
			}
		}		
		return $assigners;
	}
	
	public function user(){
		$c = $this->hasMany('App\Model\User','id','user_id')->select('first_name','last_name')->first();
		
		if($this->user_id == user_id()){
			return __('lang.my_self');
		}
        return $c->first_name." ".$c->last_name;
	}
	
	public function group_name($id){
		return \App\Model\Group::findOrFail($id)->group_name . " (Group)";
 	}
	
	public function grade_name($id){
		return \App\Model\OrganizationChart::findOrFail($id)->node_name . " (Grade)";
	}
	
	public function milestones(){
		return $this->hasMany('App\Model\MilestoneAssignment','journey_id','journey_id')->orderBy('end_date', 'DESC');
	}
	
	public function creator(){
		$c = $this->hasOne('App\Model\User','id','created_by')->select('first_name','last_name')->first();
		
		if($this->created_by == user_id()){
			return __('lang.my_self');
		}
        return $c->first_name." ".$c->last_name;
    }
	
}
