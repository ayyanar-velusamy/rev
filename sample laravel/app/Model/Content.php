<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
	use SoftDeletes;
	
    public function milestone()
	{
		return $this->belongsTo('App\Model\Milestone');
	}
	
	public function type()
	{
		return $this->hasOne('App\Model\ContentType','id','content_type_id');
	}
	
	public function creator(){
		$c = $this->hasOne('App\Model\User','id','created_by')->select('first_name','last_name')->first();
		
		if($this->created_by == user_id()){
			return __('lang.my_self');
		}
        return $c->first_name." ".$c->last_name;
    }
	
	public function rating(){
        $rating = \Illuminate\Support\Facades\DB::select('SELECT AVG(ma.rating) as rating FROM milestones as m LEFT JOIN milestone_assignments as ma ON m.id = ma.milestone_id WHERE m.parent_type = "library" AND m.parent_id= :parent_id GROUP BY m.parent_id',['parent_id'=>$this->id]);
		
		if($rating){
			return round($rating[0]->rating,2);
		}
		return 0;
    }
}
