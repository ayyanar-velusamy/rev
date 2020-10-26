<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
	
	protected $fillable = ['name','display_name']; 
	
    public static function defaultModules()
	{
		return [
			['name'=>'organization','display_name'=> "Organizational Chart"],
			['name'=>'role','display_name'=> "User Role Management"],
			['name'=>'user','display_name'=> "User Management"],
			['name'=>'group','display_name'=> "Group Management"],
			['name'=>'journey','display_name'=> "Learning Journey Management"],
			['name'=>'library','display_name'=> "Library Content Management"],
			['name'=>'approval','display_name'=> "Approval Management"],
			['name'=>'peer','display_name'=> "Peers / Colleagues"],
			['name'=>'tempcheck','display_name'=> "Tempcheck"],
			['name'=>'statistics','display_name'=> "Application Stats"],
			['name'=>'report','display_name'=> "Reports"],
		];
	}
	
	public function permissions(){
		return $this->hasMany('App\Model\Permission');
	}
}
