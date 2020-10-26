<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
	
	protected $fillable = ['name','display_name']; 
	
    public static function defaultModules()
	{
		return [ 
			['name'=>'role','display_name'=> "User Role Management"],
			['name'=>'user','display_name'=> "User Management"], 
		];
	}
	
	public function permissions(){
		return $this->hasMany('App\Model\Permission');
	}
}
