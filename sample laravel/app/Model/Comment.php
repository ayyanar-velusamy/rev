<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
	
	public function user()
    {
        return $this->belongsTo('\App\Model\User');
    }
	
	public function commentable()
    {
        return $this->morphTo();
    }

	public function replies()
    {
        return $this->hasMany('\App\Model\Comment', 'parent_id')->orderBy('id','desc');
    }
}
