<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Approval extends Model
{	
		
    public $fillable = ['milestone_id','created_by'];
   
	public $timestamps = true;
	
	public function milestone(){
		return $this->hasOne('App\Model\Milestone','id','milestone_id')->first();
	}
	
	
	public static function milestones(){
		return Approval::join('milestones as m', 'm.id', '=', 'approvals.milestone_id')
		->whereNull('m.deleted_at')
		->select('m.id','m.title')
		->orderBy('m.title','asc')
		->groupBy('m.id')
		->get();
	}
	
	public static function journeys(){
		return Approval::join('milestones as m', 'm.id', '=', 'approvals.milestone_id')
		->join('journeys as j', 'j.id', '=', 'm.journey_id')
		->whereNull('j.deleted_at')
		->select('j.id','j.journey_name','j.journey_type_id')
		->orderBy('j.journey_name','asc')
		->groupBy('j.id')
		->get();
	}
	
	
	public function assignment_status(){
		return $this->hasOne('App\Model\Milestone','id','milestone_id')
		->join('milestone_assignments as ma', 'ma.milestone_id', '=', 'milestones.id')
		->select('milestones.id','milestones.journey_id','milestones.title','ma.status')
		->get();
	}
	
	public static function approvers(){
		return Approval::join('milestones as m', 'm.id', '=', 'approvals.milestone_id')
		->join('users', 'users.id', '=', 'm.approver_id')
		->select('users.id as user_id','users.first_name','users.last_name','approvals.id as apl_id')
		->groupBy('users.id')
		->orderBy('users.first_name','asc')
		->get();
	}
	
	public static function filter_by_price(){
		return Approval::join('milestones as m', 'm.id', '=', 'approvals.milestone_id')
		->join('milestone_assignments as ma', 'ma.milestone_id', '=', 'm.id')
		->select(DB::raw('SUM(m.price) as price'))
		->groupBy('approvals.id')
		->orderBy('price','asc')
		->get();
	}
	
    public static function requested_by(){
		return Approval::join('users', 'users.id', '=', 'approvals.created_by')
		->select('users.id as user_id','users.first_name','users.last_name','approvals.id as apl_id')
		->orderBy('users.first_name','asc')
		->get();
	}
	
	public static function requested_for(){
		
		return Approval::join('milestones as m', 'm.id', '=', 'approvals.milestone_id')
		->whereNull('m.deleted_at')
		->select(DB::raw(
		'(CASE WHEN m.type = "user" 
		THEN (SELECT CONCAT(first_name," ", last_name) FROM users WHERE id = m.type_ref_id)
		WHEN m.type = "group"
		THEN (SELECT group_name FROM groups WHERE id = m.type_ref_id)
		WHEN m.type = "grade" 
		THEN (SELECT node_name FROM organization_charts WHERE id = m.type_ref_id)
		ELSE null
		END) as name'
		),'type','type_ref_id',DB::raw('CONCAT(type_ref_id,"--",type) as select_id'))
		->orderBy('m.type','asc')->get()->unique('select_id');

	}
	
	public static function requested_for_grouped(){
		$grouped = [];
		
		$requested_for = Approval::requested_for();
				
		foreach($requested_for as $req){
			$grouped[$req->type][] = $req;
		}		
		return $grouped;
	}
	
	public function creator(){
		return $this->hasOne('App\Model\User','id','created_by')->select('id','email','first_name','last_name')->first();
    }
	
	public function updated_by(){
		return $this->hasOne('App\Model\User','id','updated_by')->select('id','email','first_name','last_name')->first();
     }
	
}
