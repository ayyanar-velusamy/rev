<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TempcheckAssignment extends Model
{
	use SoftDeletes;
	
    protected $fillable = ['tempcheck_id','type','type_ref_id','user_id','survay_date','created_by','created_at'];
	
	public function tempcheck(){
		return $this->belongsTo('App\Model\Tempcheck');
	}
	
	public function user(){
		return $this->hasMany('App\Model\User','id','user_id')->first();
	}
	
}
