<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UserGrade extends Model
{
	
	protected $fillable = ['user_id', 'chart_name_id', 'chart_value_id','crated_at','updated_at'];
	
    protected $guarded = ['id'];
	
	protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user_id', function (Builder $builder) {
			$users = \App\Model\User::whereNull('deleted_at')->get()->pluck('id');
            $builder->whereIn('user_id',$users);
        });
    }
}
