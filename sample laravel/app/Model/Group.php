<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Model\User;

class Group extends Model
{
	use SoftDeletes;
	
    protected $guarded = [
      'id'
    ];
    public function group_user_list()
    {
        return $this->hasMany('App\Model\GroupUserList','group_id')->distinct();
    }
	
	public function user_ids(){
        return $this->hasMany('App\Model\GroupUserList','group_id')->pluck('user_id');
    }
	
	public function admin_ids(){
        return $this->hasMany('App\Model\GroupUserList','group_id')->where('is_admin',1)->distinct()->pluck('user_id');
    }
	
	public function journey_ids(){
        return $this->hasMany('App\Model\JourneyAssignment','type_ref_id')->where('type','group')->distinct()->pluck('journey_id')->count();
    }
	
	public function creator(){
		$c = $this->hasOne('App\Model\User','id','created_by')->select('first_name','last_name')->first();
		
		if($this->created_by == user_id()){
			return __('lang.my_self');
		}
        return $c->first_name." ".$c->last_name;
    }
	
	public function admin_name(){
         $admin = User::findOrFail($this->admin_ids(),['first_name','last_name']);
		 return $admin;
    }
}
