<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class MilestoneAssignment extends Model
{
    use SoftDeletes;
	
	public function setCompletedDateAttribute($date)
	{
		$this->attributes['completed_date'] = empty($date) ? null : Carbon::parse($date);
	}
	
	public function setNotesAttribute($notes)
	{
		$this->attributes['notes'] = empty($notes) ? null : $notes;
	}

	public function milestone(){
		return $this->hasOne('App\Model\Milestone','id','milestone_id');
	}
}
