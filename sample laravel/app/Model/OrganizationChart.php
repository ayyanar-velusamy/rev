<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrganizationChart extends Model
{
    protected $guarded = [
      'id'
    ];
	
    public $fillable = ['node_name','node_id','node_parent','set_id'];
	
    public function childs() {
           return $this->hasMany('App\Model\OrganizationChart','node_parent','node_id') ;
    }
}
