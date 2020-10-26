<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends \Spatie\Permission\Models\Role
{
    use SoftDeletes;
	
	public $fillable = ['name','created_by'];
	
	public static function boot() {
        parent::boot();

		static::saving(function($table)  {
			$table->created_by = user_id();
		});
	}
	
	public function creator(){
		$c = $this->hasOne('App\Model\User','id','created_by')->select('first_name','last_name')->first();
		if($this->created_by == user_id()){
			return __('lang.my_self');
		}
        return $c->first_name." ".$c->last_name;
    }
}
