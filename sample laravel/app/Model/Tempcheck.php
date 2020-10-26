<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tempcheck extends Model
{
	use SoftDeletes;
	
    public function assignments(){
		return $this->hasMany('App\Model\TempcheckAssignment');
	}
}
