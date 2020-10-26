<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends \Spatie\Permission\Models\Permission
{
	
	static function  all_passible_permissions(){
		return ['full','view','add','assign','edit','edit_others','delete','delete_others','approval']; 
	}
	
	static function module_wise_permission_methods(){
		
		$options['user'] 		= ['full','view','add','edit','delete']; 
		$options['role'] 		= ['full','view','add','edit','delete']; 
		$options['organization']= ['full','view','add','edit','delete']; 
		$options['group'] 		= ['full','view','add','edit','delete']; 
		$options['journey']  	= ['full','view','add','assign','edit','edit_others','delete',		'delete_others']; 
		$options['library'] 	= ['full','view','add','assign','edit','edit_others','delete','delete_others']; 
		$options['peer'] 		= ['full','view']; 
		$options['tempcheck'] 	= ['full','view','add','edit','delete']; 
		$options['approval'] 	= ['full','view','approval'];
		$options['statistics'] 	= ['full','view']; 
		$options['report'] 		= ['full','view']; 			
		return $options;
	}
	
    public function module(){
		return $this->belongsTo('App\Model\Module');
	}
}
