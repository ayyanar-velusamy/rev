<?php

namespace App\Http\Controllers;

use App\Authorizable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Notification;

use App\Model\Role;
use App\Model\Permission;
use App\Model\Module;

use App\Http\Requests\StoreRolePost;
use App\Http\Requests\UpdateRolePut;

class RoleController extends BaseController
{
	use Authorizable;
	
	public function ajax_list(Request $request)
    {
		$data = $whereArray = array();
		
		$roles = DB::table('roles');				
		$roles->select('roles.id','roles.name','roles.status','roles.created_at');		
		$roles->whereNull('roles.deleted_at');
		$roles->whereNotIn('roles.id',[1]);
		
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){
				$roles->where($where['field'],$where['condition'],$where['value']);
			} 
		}
		
		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$roles->where(function($query) use ($search_for){
				$query->where('roles.name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('roles.status', 'LIKE', '%'.$search_for.'%');
				$query->orWhere(DB::raw("DATE_FORMAT(roles.created_at, '%b %d, %Y, %h:%i %p')"), 'LIKE', '%'.$search_for.'%');
			});			
		}
		$roles->orderBy('roles.id', 'DESC');
		//$roles->groupBy('roles.id');
		$roleData = $roles->get();
		
		
		
		foreach($roleData as $key => $row){
		   $action = "";
		   
		   $action .='<a href="'.route('roles.show',[encode_url($row->id)]).'" class="btn btn-blue">View</a>';
			
			if($this->user->hasPermissionTo('edit_roles')){
				$action .='<a href="'.route('roles.edit',[encode_url($row->id)]).'" class="btn btn-lightblue">Edit</a>';
			}
			
			if($this->user->hasPermissionTo('delete_roles')){
				$action .='<button type="button" onclick="deleteRole('."'".encode_url($row->id)."'".','."'".$row->name."'".')" class="btn btn-red">Delete</button>';
			}				   
		   
           $data[$key]['id']        = ''; 
		   $data[$key]['name'] 		= $row->name; 
           $data[$key]['status']    = ucfirst($row->status); 
           $data[$key]['created_at']= get_date_time($row->created_at);
		   $data[$key]['action']    = $action; 
	   }
	   
	   return datatables()->of($data)->make(true);
	   
		// $action ="";
        // return datatables()->of(Role::all()->except(1))->addColumn('action', function($row) use($action) {
				// $action .='<a href="'.route('roles.show',[encode_url($row->id)]).'" class="btn btn-blue">View</a>';
			
			// if($this->user->hasPermissionTo('edit_roles')){
				// $action .='<a href="'.route('roles.edit',[encode_url($row->id)]).'" class="btn btn-lightblue">Edit</a>';
			// }
			
			// if($this->user->hasPermissionTo('delete_roles')){
				// $action .='<a onclick="deleteRole('."'".encode_url($row->id)."'".','."'".$row->name."'".')" class="btn btn-red">Delete</a>';
			// }			
			// return $action;
        // })->addColumn('status', function($row){
			// return ucfirst($row->status);
		// })->addColumn('created_at', function($row){
			// return get_date_time($row->created_at);
		// })->make(true);
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $permission_heads = Permission::all_passible_permissions();
        $modules = Module::all();
        return view('roles.list', compact('roles','modules','permission_heads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission_heads = Permission::all_passible_permissions();
        $modules = Module::all();
        return view('roles.add', compact('modules','permission_heads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRolePost $request)
    {
        if($role = Role::create($request->only('name')) ) {
			$role->status = $request->status;
			$role->save();
			
            if($role->name === 'Admin') {
                $role->syncPermissions(Permission::all());
            }else{
				$permissions = $request->get('permissions', []);
				$role->syncPermissions($permissions);
			}
			
			//Send create role web notification to privileged user
			$users = \App\Model\User::permission('view_roles')->where('id','!=',user_id())->where('status','active')->get();
			Notification::send($users, new \App\Notifications\RoleAddNotifiaciton ($role));

			$this->response['status']   = true;
			$this->response['message']  = str_replace("{role}",$request->name,__('message.role_create_success'));
			$this->response['redirect'] = route('roles.index');
        }else{
			$this->response['status']   = false;
			$this->response['message']  = str_replace("{role}",$request->name,__('message.role_create_failed'));
		}
        return $this->response();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail(decode_url($id));
		$permission_heads = Permission::all_passible_permissions();
        $modules = Module::all();
        return view('roles.view', compact('role','modules','permission_heads'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail(decode_url($id));
		$permission_heads = Permission::all_passible_permissions();
        $modules = Module::all();
        return view('roles.edit', compact('role','modules','permission_heads'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolePut $request, Role $role)
    {
        if($role = Role::findOrFail($role->id)) {
            $update = true;
			
			if($request->status != $role->status && $request->status=='inactive'){
				$update  = ($role->users()->count() > 0) ? false : true;				
			}
			
			if(!$update){
				$this->response['status']   = false;
				$this->response['message']  = str_replace("{role}",$role->name,__('message.role_has_active_users'));
			}else{
				$role->name = $request->name;
				$role->status = $request->status;
				$role->save();
				
				//Send update role web notification to privileged user
				$users = \App\Model\User::permission('view_roles')->where('id','!=',user_id())->where('status','active')->get();
				Notification::send($users, new \App\Notifications\RoleUpdateNotifiaciton ($role));
				
				// admin role has everything
				if($role->name === 'Admin') {
					$role->syncPermissions(Permission::all());
					$this->response['status']   = true;
					$this->response['message']  = str_replace("{role}",$request->name,__('message.role_update_success'));
					$this->response['redirect'] = route('roles.index');
				}else{
					$permissions = $request->get('permissions', []);
					$role->syncPermissions($permissions);
					
					$this->response['status']   = true;
					$this->response['message'] 	= str_replace("{role}",$request->name,__('message.role_update_success'));
					$this->response['redirect'] = route('roles.index');
				}
			}
        } else {
			$this->response['status']   = false;
            $this->response['message'] = __('message.role_not_found');
        }

        return $this->response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {        
		$role = Role::findOrFail(decode_url($id));
		
		if($role->users()->whereDeletedAt(null)->count() > 0){
			$this->response['status']   = false;
			$this->response['message']  = str_replace("{role}",$role->name,__('message.role_has_active_users'));
		}else if($role->delete()){			
			$this->response['status']   = true;
			$this->response['message']  = str_replace("{role}",$role->name,__('message.role_delete_success'));
		}else{
			$this->response['status']   = false;
			$this->response['message']  = str_replace("{role}",$role->name,__('message.role_delete_failed'));
		}
		return $this->response();
    }
}
