<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ChartSidebar extends Model
{
   protected $guarded = [
      'id'
   ];

   public $fillable = ['set_id','set_name'];
	
   public function orgchart()
    {
        return $this->hasMany('App\Model\OrganizationChart', 'set_id', 'set_id');
    }
}
