<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupPost extends Model
{
    use SoftDeletes;
	
	public function user()
    {
        return $this->belongsTo('\App\Model\User','created_by');
    }
	
	public function journey()
    {
        return $this->hasOne('\App\Model\Journey','id','journey_id');
    }
	
	public function comments()
    {
        return $this->morphMany('\App\Model\Comment', 'commentable')->whereNull('parent_id')->orderBy('id','desc');
    }
}
