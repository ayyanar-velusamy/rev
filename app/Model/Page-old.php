<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Hashids\Hashids;

class Page extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;
	
    protected $hashids; 
	
	protected $softDelete = true;
	
	public function __construct(){
		$this->hashids = new Hashids(config('app.name'),20);
	}
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
    ];
	
	public function getFullNameAttribute() {
        //return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
	
	
	// Encryption method used in common helper
	public function encode_url($data){
		return $this->hashids->encode($data);
	}
	
	// Decryption method used in common helper
	public function decode_url($data){
		return @$this->hashids->decode($data)[0];
	}
	
	public function is_group_admin(){
		return ($this->hasMany('App\Model\GroupUserList','user_id','id')->where(['is_admin'=>1])->count() > 0) ? true : false;
    }
	
	public function has_pending_approval(){
		return ($this->hasMany('App\Model\Milestone','approver_id','id')
		->join('approvals as a','a.milestone_id','=','milestones.id')->where('a.status','pending')->count() > 0) ? true : false;
    }
	
	
	
}
