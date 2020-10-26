<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupUserList extends Model
{
	use SoftDeletes;
	
	protected $guarded = [
	  'id'
	];
	   
	public function group_users()
	{
		return $this->hasMany('App\Model\User','id','user_id')->select('id','first_name','last_name')->get();
	}
}
